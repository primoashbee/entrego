<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Quiz;
use App\Models\ManPower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\QuizQuestionsV2;

class V2QuizController extends Controller
{
    public function create()
    {
        $job_group = ManPower::JOB_GROUP;
        return view('quiz.v2.create', compact('job_group'));
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request)
            {
                $quiz = Quiz::create([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'has_passing_rate'=>$request->has_passing == 'true' ? true : false,
                    'passing_rate'=>$request->passing_rate,
                    'created_by'=>auth()->user()->id,
                    'has_timer' => $request->has_timer == 'true' ? true : false,
                    'time_in_seconds' => $request->time_in_seconds,
                ]);

                $inserts = [];
                foreach($request->questions as $question)
                {
                    $inserts[] = [
                        'quiz_id' => $quiz->id,
                        'question'=> $question['question'],
                        'question_type'=>$question['question_type'],
                        'question_data'=>json_encode($question['question_data'])
                    ];


                }
                QuizQuestionsV2::insert($inserts);
                DB::commit();
                return response()->json([], 200);

            });
        }catch(\Exception $e) {
            return response()->json(['error'=> $e->getMessage()], 200);

        }
    }

    public function edit( $id)
    {
        $quiz = Quiz::with('questionsv2')->findOrFail($id);
        $job_group = ManPower::JOB_GROUP;
        return view('quiz.v2.edit',compact('quiz','job_group'));
    }

    public function update(Request $request, $id)
    {
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
            });

            $inserts = [];
            $deletes = [];
            $current_question_ids = $quiz->questionsv2->pluck('id')->toArray();
            $updated_ids = [];

            foreach($request->questions as $question)
            {
                if(array_key_exists('id', $question)){
                    //this has already id, its for update
                    QuizQuestionsV2::find($question['id'])
                    ->update([
                        'quiz_id' => $quiz->id,
                        'question'=> $question['question'],
                        'question_type'=>$question['question_type'],
                        'question_data'=>json_encode($question['question_data'])                        
                    ]);
                    $updated_ids[] = $question['id'];
                }else{
                    $inserts[] = [
                        'quiz_id' => $quiz->id,
                        'question'=> $question['question'],
                        'question_type'=>$question['question_type'],
                        'question_data'=>json_encode($question['question_data'])                        
                    ];
                }
            }

            $deletes = array_diff($current_question_ids, $updated_ids);
            QuizQuestionsV2::insert($inserts);
            QuizQuestionsV2::whereIn('id', $deletes)->delete();
            auditLog(auth()->user()->id, "Updated SJT/CSA - $quiz->name", []);
            DB::commit();

            return response()->json([], 200);

        }catch(\Exception $e){
            return response()->json(['data'=>$e->getMessage()], 500);
        }
    }
}
