<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Mockery\Matcher\Any;
use App\Models\Requirement;
use App\Models\WorkHistory;
use Illuminate\Support\Carbon;
use App\Models\UserArchiveLogs;
use App\Models\UserRequirement;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserJobApplication;
use Illuminate\Support\Facades\Storage;
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
    const HR = 'HR';



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

    const ROLES = [
        [
            'value'=>self::ADMINSTRATOR,
            'label'=>'ADMINISTRATOR',
        ],
        [
            'value'=>self::SUB_HR,
            'label'=>'DEPARTMENT HEAD',
        ],
        [
            'value'=>self::HR,
            'label'=>self::HR,
        ]
        
    ];
    public static function admin()
    {
        return self::where('role', self::ADMINSTRATOR)->first();
    }
    public function getFullNameAttribute() :string 
    {
        if($this->role == User::ADMINSTRATOR){
            return "ADMINISTRATOR";
        }
        
        if(in_array($this->role, [self::HR, self::SUB_HR])){
            return "{$this->first_name} {$this->last_name}";
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
        $total_requirements = Requirement::where('required',true)->count();
        return $this->requirements()
                ->whereHas("requirement", function($q){
                    return $q->where('required', true);
                })
                ->where('status', UserRequirement::APPROVED)
                ->count() 
                . "/" . 
                $total_requirements;
    }

    public function getRoleNameAttribute()
    {
        if($this->role === self::SUB_HR){
            return self::SUB_HR;
        }

        return $this->role;
    }

    public function requirementsFullfilled()
    {
        $requirements = Requirement::where('required', true)->get();
        $requirement_ids = $requirements->pluck('id')->toArray();

        $my_requirements = $this->requirements()->where('status', UserRequirement::APPROVED)->get();
        $my_requirements_ids = $my_requirements->pluck('requirement_id')->toArray();

        $passing_score = count($requirement_ids);
        $score = 0;

        foreach($my_requirements_ids as $id){
            if(in_array($id, $requirement_ids)){
                $score ++;
            }
        }
        return $score == $passing_score;
        // return $this->requirements()->where('status', UserRequirement::APPROVED)->count() == $max_count;
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

    public function downloadablesPath()
    {
       

        $paths = [];
        $requirements = $this->requirements->load('requirement');
        foreach($requirements as $requirement){

            $saved_filename = $requirement->storedFileName();
            if(Storage::disk('requirements')->exists("requirements/$saved_filename")){
                $ext = explode(".", $saved_filename);
                $ext = $ext[count($ext)-1];
                $paths[] = 
                [
                    'name'=>$requirement->requirement->name. ' - ' . $this->fullname .'.'. $ext,
                    'path'=>Storage::disk('requirements')->path("requirements/$saved_filename")
                ];
            }
        }

        $cv_name = $this->cv_name;

        if(Storage::disk('resumes')->exists("resumes/$cv_name")){
            $ext = explode(".", $cv_name);
            $ext = $ext[count($ext)-1];
            $paths[] = 
            [
                'name'=>'CV'. ' - ' . $this->fullname .'.'. $ext,
                'path'=> Storage::disk('resumes')->path("resumes/$cv_name")
            ];
        }


        return $paths;
    }

    public function getFullAddressAttribute()
    {
        return "$this->landmark, $this->street, $this->barangay, $this->city, $this->zip_code, PH";
    }

    public function canBeZipped()
    {
        return $this->hasFinishedAssessment() && $this->has_finished_profile && $this->cv_name != '';
    }

    public function lastUserActivity()
    {
        $activity = 'Profile Created';
        if($this->has_finished_profile){
            $activity = 'Profile Updated';
        }
        if($this->hasFinishedAssessment()){
            $activity = 'Assessment Taken';
        }
        if($this->jobApplications()->count() > 0){
            $activity = 'Job Applied';
        }

        return $activity;
    }

    public function cancelJobApplications($except_application_id)
    {
        $this->jobApplications()->whereNot('id', $except_application_id)->each(function($application){
            $application->update([
                'status'=> UserJobApplication::CANCELLED,
                'cancelled_notes'=> 'Cancelled because another application is deployed.',
                'cancelled_by'=>1,
                'cancelled_at'=> now()
            ]);
        });

        return true;
    }
    
    public function archiveLogs()
    {
        return $this->hasMany(UserArchiveLogs::class);
    }

    public function archiveStatus()
    {
        return $this->is_archived ? 'ARCHIVED' : 'ACTIVE';
    }

    public function userLogs()
    {
        return $this->hasMany(UserLog::class);
    }
}
