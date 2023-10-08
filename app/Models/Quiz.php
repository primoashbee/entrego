<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getHasPassingRateNameAttribute()
    {
        return $this->has_passing_rate === 0 ? 'Yes' : 'No';
    }
    
    public function getPassingRateNameAttribute()
    {
        return $this->has_passing_rate === 0 ? 'N/A' : $this->passing_rate;
    }   

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestions::class);
    }
}
