<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\ManPower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\QuizQuestions;

class QuizController extends Controller
{
    public function index()
    {
        $list = Quiz::with('createdBy')->withCount('questions')->get();
        return view('quiz.index', compact('list'));
    }

    public function create()
    {
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
                    'has_passing_rate'=>$request->passing_rate == 'true' ? true : false,
                    'passing_rate'=>$request->passing_rate,
                    'created_by'=>auth()->user()->id
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

                return response()->json([], 200);

            });

        }catch(\Exception $e){
            dd($e);
        }

    }
    public function edit($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $job_group = ManPower::JOB_GROUP;
        return view('quiz.edit',compact('quiz','job_group'));
    }

    public function update(UpdateQuizRequest $request, $id)
    {
        //Cannot update if the quiz has already taken
        $quiz = Quiz::with('questions')->findOrFail($id);
        try{
            DB::transaction(function () use ($request, &$quiz) {
                $quiz->update([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'job_group'=>$request->job_group,
                    'has_passing_rate'=>$request->passing_rate == 'true' ? true : false,
                    'passing_rate'=>$request->passing_rate,
                    'created_by'=>auth()->user()->id
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
