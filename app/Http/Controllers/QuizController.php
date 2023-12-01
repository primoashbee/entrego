<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\ManPower;
use Illuminate\Http\Request;
use App\Models\QuizQuestions;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;

class QuizController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if($user->role ==  User::APPLICANT){
            return abort(403);
        }
        if($user->role ==  User::ADMINSTRATOR){
            $list = Quiz::with('createdBy')->withCount('questions')->get();
        }else{
            $list = Quiz::with('createdBy')->withCount('questions')->where('created_by', $user->id)->get();

        }


        return view('quiz.index', compact('list'));
    }

    public function create()
    {
        return redirect()->route('v2.quiz.create');

        $job_group = ManPower::JOB_GROUP;
        return view('quiz.create', compact('job_group'));
    }

    public function store(StoreQuizRequest $request)
    {   
        try{
            DB::transaction(function () use ($request) {
                $quiz = Quiz::create([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'job_group'=>$request->job_group,
                    'has_passing_rate'=>$request->has_passing == 'true' ? true : false,
                    'passing_rate'=>$request->passing_rate,
                    'created_by'=>auth()->user()->id,
                    'has_timer' => $request->has_timer == 'true' ? true : false,
                    'time_in_seconds' => $request->time_in_seconds,
                ]);
                $inserts = [];
                foreach($request->questions as $question)
                {  
                    $answer = collect($question['choices'])->filter(function($choice){
                        return $choice['is_answer'] == 'on';
                    })->first()['choice'];
                                  
                    $inserts[] = [
                        'quiz_id'=> $quiz->id,
                        'question'=> $question['question'],
                        'choice_a'=> $question['choices'][0]['answer'],
                        'choice_b'=> $question['choices'][1]['answer'],
                        'choice_c'=> $question['choices'][2]['answer'],
                        'choice_d'=> $question['choices'][3]['answer'],
                        'answer'=> $answer
                    ];

                }
                QuizQuestions::insert($inserts);
                DB::commit();   
                auditLog(auth()->user()->id, "Created a new SJT/CSA - $request->name", []);

                return response()->json([], 200);

            });

        }catch(\Exception $e){
            dd($e);
        }

    }
    public function edit($id)
    {
        
        return redirect()->route('v2.quiz.edit', ['id'=>$id]);

        $quiz = Quiz::with('questions')->findOrFail($id);
        $job_group = ManPower::JOB_GROUP;
        return view('quiz.edit',compact('quiz','job_group'));
    }

    public function update(UpdateQuizRequest $request, $id)
    {
        //Cannot update if the quiz has already taken
        $quiz = Quiz::with('questions')->findOrFail($id);
        $request->request->add(['has_passing_rate', $request->has_passing]);
        try{
            DB::transaction(function () use ($request, &$quiz) {
                $quiz->update([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'job_group'=>$request->job_group,
                    'has_passing_rate'=>$request->has_passing == 'true' ? true : false,
                    'passing_rate'=>$request->passing_rate,
                    'created_by'=>auth()->user()->id,
                    'has_timer' => $request->has_timer == 'true' ? true : false,
                    'time_in_seconds' => $request->time_in_seconds,
                ]);

                $inserts = [];
                $deletes = [];
                $current_question_ids = $quiz->questions->pluck('id')->toArray();
                $updated_ids = [];
                foreach($request->questions as $question)
                {  
                    $answer = collect($question['choices'])->filter(function($choice, $index){
                        return $choice['is_answer'] == 'on';
                    })->first()['choice'];
                                  
                    if(array_key_exists('id', $question)){
                        
                        //this has already id, its for update
                        QuizQuestions::find($question['id'])
                            ->update([
                                'question'=> $question['question'],
                                'choice_a'=> $question['choices'][0]['answer'],
                                'choice_b'=> $question['choices'][1]['answer'],
                                'choice_c'=> $question['choices'][2]['answer'],
                                'choice_d'=> $question['choices'][3]['answer'],
                                'answer'=> $answer                            
                            ]);
                        $updated_ids[] = $question['id'];
                    }else{

                        //for insert
                        $inserts[] = [
                            'quiz_id'=> $quiz->id,
                            'question'=> $question['question'],
                            'choice_a'=> $question['choices'][0]['answer'],
                            'choice_b'=> $question['choices'][1]['answer'],
                            'choice_c'=> $question['choices'][2]['answer'],
                            'choice_d'=> $question['choices'][3]['answer'],
                            'answer'=> $answer
                        ];
                    }
                }

                $deletes = array_diff($current_question_ids, $updated_ids);
                QuizQuestions::insert($inserts);
                QuizQuestions::whereIn('id', $deletes)->delete();
                auditLog(auth()->user()->id, "Updated SJT/CSA - $quiz->name", []);

                DB::commit();

                return response()->json([], 200);

            });
        }catch(\Exception $e)
        {
            return $e;
        }
        // $job_group = ManPower::JOB_GROUP;
        // return view('quiz.edit',compact('quiz','job_group'));
    }
}
