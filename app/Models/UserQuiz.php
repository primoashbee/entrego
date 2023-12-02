<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Support\Carbon;
use App\Models\UserQuizAnswersV2;
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
    public function answersv2()
    {
        return $this->hasMany(UserQuizAnswersV2::class);
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

    public function application()
    {
        return $this->belongsTo(UserJobApplication::class);
    }

    public function quizReviewed($checked_by)
    {
        $q_answers = $this->answersv2();
        $total = $q_answers->count();
        $score = $q_answers->where('is_correct', true)->count();
        $percentage = ($score / $total) * 100;

        $is_passed = true;
        $quiz = $this->application->job->quiz;
        if($quiz->has_passing_rate){
           $is_passed = $percentage >= $quiz->passing_rate; 
        }
        return $this->update([
            'score'=>$score,
            'percentage'=>$percentage,
            'checked_by'=> $checked_by,
            'checked_at'=> now(),
            'is_passed'=> $is_passed
        ]);
    }
    
}
