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
use App\Models\JobApplication;
use App\Models\UserQuizAnswers;
use App\Models\UserQuizAnswersV2;
use Illuminate\Support\Facades\Session;

class UserQuizController extends Controller
{
    public function index()
    {
        
    }


    public function patch(Request $request, $application_id)
    {
        $user = auth()->user();

        $application = UserJobApplication::with('job.quiz','user')
            ->find($request->application_id);

        DB::transaction(function () use($request, $application_id, $user, $application) {
            $types = ['essay','identification'];
            $updates = collect($request->questions)->map(function($answer) use($types){
                if(in_array($answer['quiz_question']['question_type'], $types)){
                    $data['user_quiz_v2_id'] = $answer['id'];
                    $data['is_correct'] = $answer['is_correct'];
                    return $data;
                }
            })->filter(function($answer){
                return !is_null($answer);
            });
            $updates->each(function($data){
                UserQuizAnswersV2::find($data['user_quiz_v2_id'])->update(['is_correct'=>$data['is_correct']]);
            });

            UserQuiz::where('application_id',$application_id)->first()->quizReviewed($user->id);
            $name = $user->full_name;
            $applicant_name = $application->user->full_name;
            $job_name = $application->job->job_title;
            $log = "$name reviewed the SJT/CSA of $applicant_name for job $job_name";
            auditLog($user->id, $log);
            DB::commit();
        }); 
    }

    public function store(StoreUserQuizRequest $request)
    {

        DB::transaction(function () use($request) {

            $user_id = auth()->user()->id;

            $application = UserJobApplication::with('job.quiz')
                ->find($request->application_id);

            $max_score = $application->job->quiz->questions->count();
            $inserts = [];

            //ready the inserts for quiz answers table
            $score = collect($request->answers)->filter(function($answer) use (&$inserts){
                $inserts[] = [
                    'quiz_question_id'=>$answer['id'],
                    'answer'=>isset($answer['answer']) ? $answer['answer'] : 'NONE',
                    'is_correct'=>$answer['correct']
                ];
                return $answer['correct'];
            })->count();

            $score_percentage = ($score / $max_score) * 100;
            $required_percentage = $application->job->quiz->has_passing_rate ? $application->job->quiz->passing_rate : 0 ;
            $passed = $score_percentage >= $required_percentage;

            // create quiz
            $end_datetime = now();
            $start_datetime = $end_datetime->copy()->subSeconds($request->time_elapsed);
            $quiz = UserQuiz::create([
                'application_id'=>$request->application_id,
                'score'=>$score,
                'percentage'=> ($score / $max_score) * 100,
                'is_passed'=> $passed,
                'start_datetime'=>$start_datetime,
                'end_datetime'=>$end_datetime,
            ]);

            //add user_quiz id for each answers
            $inserts = collect($inserts)->map(function($insert) use ($quiz){
                $insert['user_quiz_id'] = $quiz->id;
                return $insert;
            })->toArray();

            //create UserQuizAnswers, not insert because it does not respect the DB::transaction
            foreach($inserts as $insert){
                UserQuizAnswers::create($insert);
            }

            $status = $passed ? UserJobApplication::EXAM_PASSED : UserJobApplication::EXAM_FAILED ;
            $application->update([
                'status' => $status 
            ]);
            $job_name = $application->job->job_title;
            auditLog($user_id, "Exam taken for job $job_name - result $status");


            DB::commit();

            Session::flash('redirect', route('user-quiz.view-result', $request->application_id));

        }); 

    }

    public function create(Request $request, $application_id)
    {
        return redirect()->route('v2.user-quiz.take', ['application_id'=>$application_id]);
        $application = UserJobApplication::with('job.quiz','user')
                                ->findOrFail($application_id);

        if($application->user_id != auth()->user()->id)
        {
            return abort(403);
        }
        $job_group = ManPower::JOB_GROUP;
        $quiz = $application->job->quiz;
        $taken = $application->userQuiz != null ? true : false; 
        
        return view('user-quiz.create', compact('application','job_group', 'quiz', 'taken'));
    }


    public function view($application_id){
        return redirect()->route('v2.user-quiz.view-result', ['application_id'=>$application_id]);

        $application =  UserJobApplication::with('userQuiz.answers','job.quiz.questions')->findOrFail($application_id);
        if(!$application->userQuiz){
            return abort(404);
        }
        $quiz = $application->job->quiz;
        $questions = $quiz->questions;
                    

        $questions = $application->userQuiz->answers->map(function($answer) use (&$questions){
            $current_question = $questions->where('id', $answer->quiz_question_id)->first();
            $user_answer = ""; 
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
