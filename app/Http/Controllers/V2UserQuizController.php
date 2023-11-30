<?php

namespace App\Http\Controllers;

use App\Models\ManPower;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Models\UserJobApplication;
use Illuminate\Support\Facades\DB;
use PDO;

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

            dd($score, $max_score);
            // Save on DB

        });
            // $max_score = $application->job->quiz->questions->count();
            // $inserts = [];

            //ready the inserts for quiz answers table
            // $score = collect($request->answers)->filter(function($answer) use (&$inserts){
            //     $inserts[] = [
            //         'quiz_question_id'=>$answer['id'],
            //         'answer'=>isset($answer['answer']) ? $answer['answer'] : 'NONE',
            //         'is_correct'=>$answer['correct']
            //     ];
            //     return $answer['correct'];
            // })->count();

            // $score_percentage = ($score / $max_score) * 100;
            // $required_percentage = $application->job->quiz->has_passing_rate ? $application->job->quiz->passing_rate : 0 ;
            // $passed = $score_percentage >= $required_percentage;

            // // create quiz
            // $end_datetime = now();
            // $start_datetime = $end_datetime->copy()->subSeconds($request->time_elapsed);
            // $quiz = UserQuiz::create([
            //     'application_id'=>$request->application_id,
            //     'score'=>$score,
            //     'percentage'=> ($score / $max_score) * 100,
            //     'is_passed'=> $passed,
            //     'start_datetime'=>$start_datetime,
            //     'end_datetime'=>$end_datetime,
            // ]);

            // //add user_quiz id for each answers
            // $inserts = collect($inserts)->map(function($insert) use ($quiz){
            //     $insert['user_quiz_id'] = $quiz->id;
            //     return $insert;
            // })->toArray();

            // //create UserQuizAnswers, not insert because it does not respect the DB::transaction
            // foreach($inserts as $insert){
            //     UserQuizAnswers::create($insert);
            // }

            // $status = $passed ? UserJobApplication::EXAM_PASSED : UserJobApplication::EXAM_FAILED ;
            // $application->update([
            //     'status' => $status 
            // ]);
            // $job_name = $application->job->job_title;
            // auditLog($user_id, "Exam taken for job $job_name - result $status");


            // DB::commit();

            // Session::flash('redirect', route('user-quiz.view-result', $request->application_id));
        // })
    }
}
