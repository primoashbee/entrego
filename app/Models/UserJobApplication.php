<?php

namespace App\Models;

use App\Models\User;
use App\Models\ManPower;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserJobApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    const APPLIED = "APPLIED";
    const WAITING_FOR_EXAM_RESULT = "WAITING_FOR_EXAM_RESULT";
    const EXAM_PASSED = "EXAM_PASSED";
    const EXAM_FAILED = "EXAM_FAILED";
    const FOR_SENDING_INTERVIEW = "FOR_SENDING_INTERVIEW";
    const INTERVIEW_SENT = "INTERVIEW_SENT";

    const REJECTED = "REJECTED";
    const APPROVED = "APPROVED";

    const FOR_REQUIREMENTS = "FOR_REQUIREMENTS";
    
    const HIRED = "HIRED";
    const DEPLOYED = "DEPLOYED";
    const JOB_OFFER = "JOB_OFFER";
    const CANCELLED = "CANCELLED";
    const STATUSES = [
        [
            "value"=> self::APPLIED,
            "label"=> "APPLIED"
        ],
        [
            "value"=> self::EXAM_PASSED,
            "label"=> "EXAM PASSED"
        ],
        [
            "value"=> self::EXAM_FAILED,
            "label"=> "EXAM FAILED"
        ],
        [
            "value"=> self::INTERVIEW_SENT,
            "label"=> "INTERVIEW SENT"
        ],
        [
            "value"=> self::FOR_SENDING_INTERVIEW,
            "label"=> "FOR SENDING INTERVIEW"
        ],
        [
            "value"=> self::REJECTED,
            "label"=> "REJECTED"
        ],
        [
            "value"=> self::APPROVED,
            "label"=> "APPROVED"
        ],
        [
            "value"=> self::FOR_REQUIREMENTS,
            "label"=> "FOR REQUIREMENTS"
        ],
        [
            "value"=> self::JOB_OFFER,
            "label"=> "JOB OFFER"
        ],
        [
            "value"=> self::DEPLOYED,
            "label"=> "DEPLOYED"
        ],
        [
            "value"=> self::CANCELLED,
            "label"=> "CANCELLED"
        ],
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(ManPower::class,'man_power_id','id');
    }

    public function getStatusNameAttribute()
    {
        return str_replace('_',' ', $this->status);
    }

    public function userQuiz()
    {
        return $this->hasOne(UserQuiz::class,'application_id');
    }
    
    public function canBeDeployed()
    {
        return $this->user->requirementsFullfilled();
    }

    public function scopeActive()
    {
        return $this->whereNotIn('status', [self::APPLIED, self::REJECTED, self::DEPLOYED, self::CANCELLED]);
    }

    public function scopeDeployed()
    {
        return $this->where('status', self::DEPLOYED);
    }

    public static function variation($date)
    {   
        $last = self::whereMonth('created_at', $date->copy()->subMonth()->month)->count() ;
        $now = self::whereMonth('created_at', $date->month)->count();
     
        if($last == 0){
            $variaton = 100;
        }else{
            $variaton = round(1 * abs(100 - (($now / $last) * 100)),2);

            if($last > $now){
                $variaton = round(-1 * abs(100 - (($now / $last) * 100)),2);
            }
        }

       return $variaton;
    }

    public static function variationDeployed($date)
    {   
        $last = self::whereMonth('created_at', $date->copy()->subMonth()->month)->count() ;
        $now =  self::whereMonth('created_at', $date->format('Y'))->deployed()->count();
     
        if($last == 0){
            $variaton = 100;
        }else{
            $variaton = round(1 * abs(100 - (($now / $last) * 100)),2);

            if($last > $now){
                $variaton = round(-1 * abs(100 - (($now / $last) * 100)),2);
            }
        }

       return $variaton;
    }

    public function hiringTimeSpan()
    {
        $diff = Carbon::parse($this->deployed_at)->diffInDays($this->created_at);
        $days = 'day';
        if($diff > 1){
            $days = 'days';
        }
        return  "$diff $days Time to Hire";
    }

    public function getInterviewDateFriendlyAttribute()
    {
        if(is_null($this->interview_date)){
            return '-';
        }
        return Carbon::parse($this->interview_date);
    }

    public function getJobOfferedAtFriendlyAttribute()
    {
        if(is_null($this->job_offered_at)){
            return '-';
        }
        return Carbon::parse($this->job_offered_at);
    }

    public function getJobOfferAcceptedAtFriendlyAttribute()
    {
        if(is_null($this->job_offer_accepted_at)){
            return '-';
        }
        return Carbon::parse($this->job_offer_accepted_at);
    }

    public function getDeployedAtFriendlyAttribute()
    {
        if(is_null($this->deployed_at)){
            return '-';
        }
        return Carbon::parse($this->deployed_at);
    }


}
