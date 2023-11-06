<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Mockery\Matcher\Any;
use App\Models\Requirement;
use App\Models\WorkHistory;
use Illuminate\Support\Carbon;
use App\Models\UserRequirement;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserJobApplication;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    const APPLICANT = 'APPLICANT';
    const ADMINSTRATOR = 'ADMINISTRATOR';
    const SUB_HR = 'SUB_HR';



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'archived_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute() :string 
    {
        if($this->role == User::ADMINSTRATOR){
            return "ADMINISTRATOR";
        }
        if(!$this->has_finished_profile){
            return $this->email;
        }
        return "{$this->first_name} {$this->last_name}";
    }

    public static function hasAdminUser() : bool
    {
        return self::where('role', self::ADMINSTRATOR)->count() > 0;
    }

    public function assessments()
    {
        return $this->hasMany(UserPersonalAssessment::class);
    }
    public function hasFinishedAssessment()
    {
        $assessments = UserPersonalAssessment::with('user')
            ->distinct()
            ->select('batch_id','created_at')
            ->where('user_id', $this->id)
            ->get();
;
        if($assessments->count() > 0){
            //meron
            if($assessments->count() == 1){
                return true;
            }

            // meron madami check if 6months passed sa last
            return Carbon::parse($assessments->first()->created_at)->diffInDays(now(), true) >= 90;

        }
        return false;
    }

    public function isApplicant()
    {
        return $this->role == self::APPLICANT;
    }

    public function jobApplications()
    {
        return $this->hasMany(UserJobApplication::class);
    }
    public function isAppliedToJob($id)
    {
        return $this->jobApplications()->where('man_power_id', $id)->count() > 0;
    }

    public function canUploadRequirements()
    {
        return $this->jobApplications()->whereIn('status', [UserJobApplication::FOR_REQUIREMENTS, UserJobApplication::DEPLOYED])->count() > 0;
    }
  
    public function requirements()
    {
        return $this->hasMany(UserRequirement::class);
    }
    public function getRequirementSummaryAttribute()
    {
        $reqs = $this->requirements();
        return $reqs->clone()->where('status', UserRequirement::APPROVED)->count()."/".$reqs->count();
    }

    public function requirementsFullfilled()
    {
        $max_count = Requirement::count();
        return $this->requirements()->where('status', UserRequirement::APPROVED)->count() == $max_count;
    }

    public function scopeActive()
    {
        return $this->where('is_archived', false);
    }

    public function scopeArchived()
    {
        return $this->where('is_archived', true);
    }

    public function scopeApplicant()
    {
        return $this->where('role', self::APPLICANT);
    }

    public function scopeFinishedAssessment()
    {
        return $this->where('has_finished_asessment', true);
    }

    public function scopeFinishedProfile()
    {
        return $this->where('has_finished_profile', true);
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

    public function workHistory()
    {
        return $this->hasMany(WorkHistory::class);
    }

    public function lastActivity()
    {
        $query = $this->jobApplications()->orderBy('id','desc');
        if($query->count() > 0){
            return $query->first()->updated_at;
        }
        return $this->updated_at;
    }

    public function toArchive()
    {
        return Carbon::now()->diffInDays($this->lastActivity(), true) >= 180;
    }

    public function archive()
    {
        return $this->update(['is_archived'=> true, 'archived_at'=> now()]);
    }
}
