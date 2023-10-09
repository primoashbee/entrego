<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserQuizRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\ManPower;
use App\Models\Quiz;
use App\Models\UserJobApplication;
use App\Models\UserQuiz;
use Illuminate\Http\Request;

class UserQuizController extends Controller
{
    public function index()
    {
        
    }

    public function store(StoreUserQuizRequest $request)
    {
        $user_id = auth()->user()->id;
        $application = UserJobApplication::find($request->application_id);
        
    }

    public function create(Request $request, $application_id)
    {
        $application = UserJobApplication::with('job.quiz','user')
                                ->findOrFail($application_id);
        $job_group = ManPower::JOB_GROUP;
        $quiz = $application->job->quiz;
        return view('user-quiz.create', compact('application','job_group', 'quiz'));
    }

  
}
