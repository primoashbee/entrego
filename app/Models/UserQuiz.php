<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuiz extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function answers()
    {
        return $this->hasMany(UserQuizAnswers::class);
    }

    public function getTimeElapsedAttribute()
    {   
        $start = Carbon::parse($this->start_datetime);
        $end = Carbon::parse($this->end_datetime);
        $total = $start->diffInSeconds($end);
        $mins = str_pad(floor($total / 60), 2, "0", STR_PAD_LEFT);
        $secs = str_pad($total % 60, 2, "0", STR_PAD_LEFT);
        return "$mins minutes and $secs seconds";
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
