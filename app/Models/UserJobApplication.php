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
    const HIRED = "HIRED";

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
    

}
