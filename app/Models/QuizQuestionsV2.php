<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionsV2 extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table='quiz_questions_v2';

    // protected $casts = [
    //     'question_data'=>'array'
    // ];

    public function getQuestionDataAttribute()
    {
        return json_decode($this->getRawOriginal('question_data'));
    }
}
