<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    
    protected $guarded = [];

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
        return collect(self::DEPARTMENT)->firstWhere('value', $this->department)['label'];
    }
}
