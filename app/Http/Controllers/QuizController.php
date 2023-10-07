<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Models\ManPower;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $list = Quiz::all();
        
        return view('quiz.index', compact('list'));
    }

    public function create()
    {
        $job_group = ManPower::JOB_GROUP;
        return view('quiz.create', compact('job_group'));
    }

    public function store(StoreQuizRequest $request)
    {
        dd($request->all());
    }
}
