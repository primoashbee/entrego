<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\ManPower;
use App\Models\UserQuiz;
use Illuminate\Http\Request;
use App\Models\UserJobApplication;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreUserQuizRequest;
use App\Models\UserQuizAnswers;
use Illuminate\Support\Facades\Session;

class UserQuizController extends Controller
{
    public function index()
    {
        
    }

    public function store(StoreUserQuizRequest $request)
    {

        DB::transaction(function () use($request) {

            $user_id = auth()->user()->id;

            $application = UserJobApplication::with('job.quiz')
                ->find($request->application_id);
            $max_score = $application->job->quiz->questions->count();
            $inserts = [];

            $score = collect($request->answers)->filter(function($answer) use (&$inserts){
                $inserts[] = [
                    'quiz_question_id'=>$answer['id'],
                    'answer'=>$answer['answer'],
                    'is_correct'=>$answer['correct']
                ];
                return $answer['correct'];
            })->count();
            
            $quiz = UserQuiz::create([
                'application_id'=>$request->application_id,
                'score'=>$score,
                'percentage'=> ($score / $max_score) * 100
            ]);
            $inserts = collect($inserts)->map(function($insert) use ($quiz){
                $insert['user_quiz_id'] = $quiz->id;
                return $insert;
            })->toArray();

            UserQuizAnswers::insert($inserts);
            DB::commit();

            Session::flash('redirect', route('user-quiz.view-result', $request->application_id));

        }); 

    }

    public function create(Request $request, $application_id)
    {
        $application = UserJobApplication::with('job.quiz','user')
                                ->findOrFail($application_id);
        $job_group = ManPower::JOB_GROUP;
        $quiz = $application->job->quiz;
        return view('user-quiz.create', compact('application','job_group', 'quiz'));
    }


    public function view($application_id){
        $application =  UserJobApplication::with('userQuiz.answers','job.quiz.questions')->findOrFail($application_id);
        $quiz = $application->job->quiz;
        $questions = $quiz->questions;
        $questions = $application->userQuiz->answers->map(function($answer) use (&$questions){
            $current_question = $questions->where('id', $answer->quiz_question_id)->first();
            return [
                'id'=>$current_question->id,
                'question'=>$current_question->question,
                'is_user_correct' => $answer->is_correct,
                'choices'=> [
                    [
                        'choice' => 'choice_b',
                        'answer' => $current_question->choice_a,
                        'is_answer' => $current_question->answer =='choice_a' ? true : false,
                        'user_answer'=> $answer->answer == 'choice_a' ? 'on' : 'off'
                    ],
                    [
                        'choice' => 'choice_b',
                        'answer' => $current_question->choice_b,
                        'is_answer' => $current_question->answer =='choice_b' ? true : false,
                        'user_answer'=> $answer->answer == 'choice_b' ? 'on' : 'off'
                    ],
                    [
                        'choice' => 'choice_c',
                        'answer' => $current_question->choice_c,
                        'is_answer' => $current_question->answer =='choice_c' ? true : false,
                        'user_answer'=> $answer->answer == 'choice_c' ? 'on' : 'off'
                    ],
                    [
                        'choice' => 'choice_d',
                        'answer' => $current_question->choice_d,
                        'is_answer' => $current_question->answer =='choice_d' ? true : false,
                        'user_answer'=> $answer->answer == 'choice_d' ? 'on' : 'off'
                    ],
                ]
            ];
        });
        return view('user-quiz.view-result', compact('application','questions'));
    }

  
}
