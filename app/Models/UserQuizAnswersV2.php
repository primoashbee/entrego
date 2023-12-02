<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizAnswersV2 extends Model
{
    use HasFactory;
    protected $table ='user_quiz_answers_v2';
    protected $guarded =[];
    public function getQuestionDataAttribute()
    {
        return json_decode($this->getRawOriginal('question_data'));
    }

    public function quizQuestion()
    {  
        return $this->belongsTo(QuizQuestionsV2::class, 'quiz_questions_v2_id','id');
    }

}
