<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserQuizController extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $answers = collect($request->answers)->map(function($answer) use ($user_id){
            $answer['user_id'] = $user_id;
            $answer['personal_question_id'] = $answer['id'];
            unset($answer['id']);
            unset($answer['question']);
            unset($answer['reversed']);
            unset($answer['trait']);
            unset($answer['trait']);
            return $answer;
        });

        dd($answers);

    }
}
