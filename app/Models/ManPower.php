<?php

namespace App\Models;

use stdClass;
use App\Models\Location;
use Carbon\CarbonPeriod;
use App\Models\JobExperience;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManPower extends Model
{
    use HasFactory, SoftDeletes;

    const JOB_GROUP = [
        [
            'value'=>'IT',
            'label'=>'Information Technology'
        ],
        [
            'value'=>'HR',
            'label'=>'Human Resources'
        ],
        [
            'value'=>'MECH',
            'label'=>'Mechanical'
        ],
        [
            'value'=>'OPS',
            'label'=>'Operations'
        ],
    ];

    const DEPARTMENT = [
        [
            'value'=>'IT_DEPT',
            'label'=>'Information Technology Department'
        ],
        [
            'value'=>'HR_DEPT',
            'label'=>'Human Resources Department'
        ],
        [
            'value'=>'FAD_DEPT',
            'label'=>'Finance and Accounting Department'
        ],
        [
            'value'=>'OPS_DEPT',
            'label'=>'Operations Department'
        ],
    ];

    const EXPERIENCES = [
        [
            'value'=>'FRESH',
            'label'=>'< 1 Year'
        ],
        [
            'value'=>'JUNIOR',
            'label'=>'1 - 3 Years'
        ],
        [
            'value'=>'MID',
            'label'=>'3 - 5 Years'
        ],
        [
            'value'=>'SENIOR',
            'label'=>'> 5 Years'
        ],
    ];

    const VACANCIES = [
        [
            'value'=>'1',
            'label'=>'1 Position'
        ],
        [
            'value'=>'2',
            'label'=>'2 Positions'
        ],
        [
            'value'=>'2',
            'label'=>'2 Positions'
        ],
        [
            'value'=>'3',
            'label'=>'3 Positions'
        ],
        [
            'value'=>'4',
            'label'=>'4 Positions'
        ],
        [
            'value'=>'5',
            'label'=>'5 Positions'
        ],
    ];
    
    protected $guarded = [];

    protected $dates = ['expires_at'];

    public function getActiveFriendlyAttribute()
    {
        return $this->active == 'Active' ? 'Active' : 'Inactive';
    }
    public function getJobGroupNameAttribute()
    {   
        return collect(self::JOB_GROUP)->firstWhere('value', $this->job_group)['label'];
    }
    
    public function getJobNatureNameAttribute()
    {   
        return str_replace("_"," ", $this->job_nature);
    }

    public function getDepartmentNameAttribute()
    {   
        $dept_name =collect(self::DEPARTMENT)->firstWhere('value', $this->department);
        if(is_null($dept_name)){
           return $this->belongsTo(Department::class,'department','key')->first()->value;
        }
        return $dept_name['label'];
    }

    public function scopeActive()
    {
        return self::where('active', true);
    }

    public function getRequiredExperienceNameAttribute()
    {
        return $this->jobExperienceLink?->key;
    }

    public function getExpiresAtNameAttribute()
    {
        return Carbon::parse($this->expires_at)->format('F d, Y');
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class,'id','quiz_id');
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

    public static function overview($id = null)
    {
        // $last = self::whereMonth('created_at', $date->copy()->subMonth()->month)->count() ;
        // $now = self::whereMonth('created_at', $date->month)->count();
        
        // get man_powers
        if(is_null($id)){
            return DB::table('man_powers')
            ->leftJoin('user_job_applications','man_powers.id','=','user_job_applications.man_power_id')
            ->select(DB::raw("
                    man_powers.job_title as job_title,
                    SUM(IF(user_job_applications.status ='REJECTED', 1, 0)) AS rejected,
                    SUM(IF(user_job_applications.status ='APPROVED', 1, 0)) AS approved,
                    SUM(IF(user_job_applications.status ='DEPLOYED', 1, 0)) AS deployed,
                    COUNT(user_job_applications.id) AS total 
                "))
            ->groupBy('man_powers.id')
            ->get();
        }

        return DB::table('man_powers')
            ->leftJoin('user_job_applications','man_powers.id','=','user_job_applications.man_power_id')
            ->select(DB::raw("
                    man_powers.job_title as job_title,
                    SUM(IF(user_job_applications.status ='REJECTED', 1, 0)) AS rejected,
                    SUM(IF(user_job_applications.status ='APPROVED', 1, 0)) AS approved,
                    SUM(IF(user_job_applications.status ='DEPLOYED', 1, 0)) AS deployed,
                    COUNT(user_job_applications.id) AS total 
                "))
            ->where('man_powers.requested_by', $id)
            ->groupBy('man_powers.id')
            ->get();

        
    }
    

    public function applications()
    {
        return $this->hasMany(UserJobApplication::class);
    }

    public function deployed()
    {
        return $this->applications()->where('status', UserJobApplication::DEPLOYED)->count();
    }

    public static function totalManPower()
    {
        $total = 0;
        $deployed = 0;
        self::withCount(['applications'=>function($q){ 
            return $q->where('status', UserJobApplication::DEPLOYED);
        }])->each(function($manpower) use (&$total, &$deployed){
            // $deployed = $deployed + $manpower->job->deployed();
            $total = $total + (int) $manpower->vacancies;
            $deployed = $deployed + (int) $manpower->applications_count;
        });

        return [
            'total'=>$total, 
            'deployed'=>$deployed
        ];
   
    }

    public function getVacantAvailableAttribute()
    {
        $deployed = UserJobApplication::where('man_power_id', $this->id)->where('status', UserJobApplication::DEPLOYED)->count();
        $total = $this->vacancies;
        
        return (int) $total - (int) $deployed; 
    }

    public function requestor()
    {
        return $this->belongsTo(User::class, 'requested_by' ,'id');
    }


    public function departmentLink()
    {
        return $this->belongsTo(Department::class, 'department','key');
    }

    public function locationLink()
    {
        return $this->belongsTo(Location::class, 'location','key');
    }
  
    public function notes()
    {
        return $this->hasMany(ManPowerNotes::class);
    }


    public function jobNatureLink()
    {
        return $this->belongsTo(JobNature::class ,'job_nature','key');
    }

    public function jobLevelLink()
    {
        return $this->belongsTo(JobLevel::class ,'job_level','key');
    }

    public function experienceLink()
    {
        return $this->belongsTo(JobExperience::class ,'required_experience','key');
    }
    

    public static function graphDetails($start, $end)
    {

        // $deployed = UserJobApplication::whereBetween('created_at', [$start, $end])
        //         ->where('status', UserJobApplication::DEPLOYED)
        //         ->count();
        //         // ->get();


        // $requested = ManPower::whereBetween('created_at', [$start, $end])
        // ->where('active', true)
        // ->sum('vacancies');
        // // ->get();

        $period =  CarbonPeriod::create(now()->subMonths(11),'1 month', now());

        $dates = [];
        $request_stmt = "";
        $deployed_stmt = "";
        foreach($period as $date){
            $month_name = strtoupper($date->format("M"));
            $month = $date->month;
            $dates[] = $month_name;
            $request_stmt.= "CASE WHEN TRUE THEN (SELECT IFNULL(SUM(vacancies), 0 ) FROM man_powers WHERE MONTH(created_at) = $month) ELSE 0 END AS  '$month_name',";
            $deployed_stmt.= "CASE WHEN TRUE THEN (SELECT IFNULL(COUNT(*), 0 ) FROM user_job_applications WHERE MONTH(created_at) = $month and status = 'DEPLOYED' and deployed_at IS NOT NULL) ELSE 0 END AS  '$month_name',";
        }

        $request_stmt = rtrim($request_stmt, ",");
        $deployed_stmt = rtrim($deployed_stmt, ",");

        $requested_data = DB::table('man_powers')
            ->selectRaw(
                $request_stmt
            )->first();
        
        $deployed_data = DB::table('user_job_applications')
            ->selectRaw(
                $deployed_stmt
            )->first();
        
        $data = new stdClass;
        $data->labels = $dates;
        $data->requested = collect($requested_data)->values()->toArray();
        $data->deployed = collect($deployed_data)->values()->map(function($item){ return (string) $item;})->values()->ToArray();
        return $data;
    } 
}
