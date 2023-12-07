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
                    $answer = null;
                    $item['is_correct'] = null;

                }
                if($item['question_type'] == 'essay'){
                    // dd($item['question_data']);
                    $user_answer = $item['question_data']['user_answer'];
                    $answer = null;
                    $item['is_correct'] = null;
                }
                return $item;

            });


            
            // $score = count($answers->filter(function($answer){
            //     return $answer['is_correct'] == true;
            // }));
            $score = null;
            $max_score = $answers->count();

            // $score_percentage = ($score / $max_score) * 100;
            $score_percentage = null;
            $required_percentage = $application->job->quiz->has_passing_rate ? $application->job->quiz->passing_rate : 0 ;
            // $passed = $score_percentage >= $required_percentage;
            $passed = null;
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
                // dd($answer);
                $data = [
                    'user_quiz_id'=>$user_quiz->id,
                    'question_data'=>json_encode($answer['question_data']),
                    'question'=>$answer['question'],
                    'answer'=> $answer['question_data']['user_answer'],
                    'is_correct'=>$answer['is_correct'],
                    'created_at'=>$now,
                    'updated_at'=>$now,
                    'quiz_questions_v2_id'=>$answer['id'],
                ];
                return $data;
            })->toArray();

            
            // SAve on DB - User Quiz Answers1
            UserQuizAnswersV2::insert($answer_insert);



            // $status = $passed ? UserJobApplication::EXAM_PASSED : UserJobApplication::EXAM_FAILED ;
            $status = UserJobApplication::EXAM_REVIEWING ;
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
}
