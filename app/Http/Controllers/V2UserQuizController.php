<?php

namespace App\Http\Controllers;

use PDO;
use App\Models\ManPower;
use App\Models\UserQuiz;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Models\UserQuizAnswersV2;
use App\Models\UserJobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class V2UserQuizController extends Controller
{
    public function create(Request $request, $application_id)
    {
        $application = UserJobApplication::with('job.quiz.questionsv2','user')
                                ->findOrFail($application_id);

        if($application->user_id != auth()->user()->id)
        {
            return abort(403);
        }
        $job_group = ManPower::JOB_GROUP;
        $quiz = $application->job->quiz;
        $taken = $application->userQuiz != null ? true : false; 
        return view('user-quiz.v2.create', compact('application','job_group', 'quiz', 'taken'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use($request) {
            $now = now();
            $user_id = auth()->user()->id;

            $application = UserJobApplication::with('job.quiz')
                ->find($request->application_id);

            $answers = collect($request->answers)->map(function($item){
                if($item['question_type'] == 'choice'){
                    $user_answer = $item['question_data']['user_answer'];
                    $answer = $item['question_data']['answer'];
                    $item['is_correct'] = false;
                    if(!is_null($user_answer) && $user_answer == $answer){
                        $item['is_correct'] = true;
                    }
                }
                if($item['question_type'] == 'boolean'){
                    $user_answer = $item['question_data']['user_answer'];
                    $answer = $item['question_data']['answer'];
                    $item['is_correct'] = false;
                    if(!is_null($user_answer) && $user_answer == $answer){
                        $item['is_correct'] = true;
                    }
                }
                if($item['question_type'] == 'identification'){
                    $user_answer = $item['question_data']['user_answer'];
                    $answer = $item['question_data']['answer'];
                    $item['is_correct'] = false;
                    if(!is_null($user_answer) && $user_answer == $answer){
                        $item['is_correct'] = true;
                    }
                }
                return $item;

            });


            
            $score = count($answers->filter(function($answer){
                return $answer['is_correct'] == true;
            }));
            $max_score = $answers->count();

            $score_percentage = ($score / $max_score) * 100;
            $required_percentage = $application->job->quiz->has_passing_rate ? $application->job->quiz->passing_rate : 0 ;
            $passed = $score_percentage >= $required_percentage;

            $end_datetime = now();
            $start_datetime = $end_datetime->copy()->subSeconds($request->time_elapsed);


            // Save on DB - User Quiz Summary
            $user_quiz = UserQuiz::create([
                'application_id'=>$request->application_id,
                'score'=>$score,
                'percentage'=> ($score / $max_score) * 100,
                'is_passed'=> $passed,
                'start_datetime'=>$start_datetime,
                'end_datetime'=>$end_datetime,
            ]); 
            $answer_insert = $answers->map(function($answer) use ($user_quiz, $now){
                $data = [
                    'user_quiz_id'=>$user_quiz->id,
                    'question_data'=>json_encode($answer['question_data']),
                    'question'=> $answer['question_data']['answer'],
                    'answer'=> $answer['question'],
                    'is_correct'=>$answer['is_correct'],
                    'created_at'=>$now,
                    'updated_at'=>$now,
                    'quiz_questions_v2_id'=>$answer['id']
                ];
                return $data;
            })->toArray();

            
            // SAve on DB - User Quiz Answers1
            UserQuizAnswersV2::insert($answer_insert);


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

    public function view($application_id)
    {
        $application =  UserJobApplication::with('userQuiz.answersv2','job.quiz.questions')->findOrFail($application_id);
        if(!$application->userQuiz){
            return abort(404);
        }
        $quiz = $application->job->quiz;
        $questions = $application->userQuiz->answersv2->load('quizQuestion');
        return view('user-quiz.v2.view-result', compact('application','questions'));

    }
}