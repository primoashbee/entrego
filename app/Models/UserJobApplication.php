<?php

namespace App\Models;

use App\Models\User;
use App\Models\ManPower;
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
            "value"=> self::HIRED,
            "label"=> "HIRED"
        ],
        [
            "value"=> self::DEPLOYED,
            "label"=> "DEPLOYED"
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
        return $this->whereNotIn('status', [self::APPLIED, self::REJECTED, self::DEPLOYED]);
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

}
