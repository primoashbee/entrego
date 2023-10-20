<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\Uid\UuidV4;
use App\Models\PersonalAssessment;
use Illuminate\Support\Collection;
use App\Models\UserPersonalAssessment;

class UserPersonalAssessmentController extends Controller
{
    
    public function store(Request $request)
    {
        $uuid = strtoupper(Str::uuid());
        $user = auth()->user();
        $user_id = $user->id;
        $date = now();
        $answers = collect($request->answers)->map(function($answer) use ($user_id, $date, $uuid){
            $answer['user_id'] = $user_id;
            $answer['personal_question_id'] = $answer['id'];
            $answer['created_at'] = $date;
            $answer['updated_at'] = $date;
            $answer['batch_id'] = $uuid;
            unset($answer['id']);
            unset($answer['question']);
            unset($answer['reversed']);
            return $answer;
        });
        $result = $this->compute($answers);
        
        // Attach the scores
        $answers = $answers->map(function($answer) use ($result){
            $answer['extraversion_score'] = $result['extraversion']['score'];
            $answer['extraversion_total'] = $result['extraversion']['total'];
            $answer['extraversion_percentage'] = $result['extraversion']['percentage'];

            $answer['agreeableness_score'] = $result['agreeableness']['score'];
            $answer['agreeableness_total'] = $result['agreeableness']['total'];
            $answer['agreeableness_percentage'] = $result['agreeableness']['percentage'];

            $answer['conscientiousness_score'] = $result['conscientiousness']['score'];
            $answer['conscientiousness_total'] = $result['conscientiousness']['total'];
            $answer['conscientiousness_percentage'] = $result['conscientiousness']['percentage'];

            $answer['neuroticism_score'] = $result['neuroticism']['score'];
            $answer['neuroticism_total'] = $result['neuroticism']['total'];
            $answer['neuroticism_percentage'] = $result['neuroticism']['percentage'];

            $answer['openness_score'] = $result['openness']['score'];
            $answer['openness_total'] = $result['openness']['total'];
            $answer['openness_percentage'] = $result['openness']['percentage'];
            unset($answer['position']);
            unset($answer['trait']);
            return $answer;
        })->toArray();

        UserPersonalAssessment::insert($answers);
        $user->update([
            'has_finished_asessment'=>true
        ]);
        return response()->json([
            'batch_id'=>$uuid
        ], 200);
    }

    public function compute(Collection $collection)
    {
        $extraversion = 0;
        $agreeableness = 0;
        $conscientiousness = 0;
        $neuroticism = 0;
        $openness = 0;

        $maxE = $collection->where('trait', 'E')->count() * 5;
        $maxA = $collection->where('trait', 'A')->count() * 5;
        $maxC = $collection->where('trait', 'C')->count() * 5;
        $maxN = $collection->where('trait', 'N')->count() * 5;
        $maxO = $collection->where('trait', 'O')->count() * 5;

        $extraversion = $collection->reduce(function($acc, $answer){
            if($answer['trait'] == 'E'){
                return $acc + intval($answer['answer']);
            }
            return $acc;
        }, 0);

        $agreeableness = $collection->reduce(function($acc, $answer){
            if($answer['trait'] == 'A'){
                return $acc + intval($answer['answer']);
            }
            return $acc;
        }, 0);

        $conscientiousness = $collection->reduce(function($acc, $answer){
            if($answer['trait'] == 'C'){
                return $acc + intval($answer['answer']);
            }
            return $acc;
        }, 0);

        $neuroticism = $collection->reduce(function($acc, $answer){
            if($answer['trait'] == 'N'){
                return $acc + intval($answer['answer']);
            }
            return $acc;
        }, 0);

        $openness = $collection->reduce(function($acc, $answer){
            if($answer['trait'] == 'O'){
                return $acc + intval($answer['answer']);
            }
            return $acc;
        }, 0);

        $result = [
            'extraversion' => 
                [ 
                    'score' => $extraversion,
                    'total' => $maxE,
                    'percentage'=> round(($extraversion / $maxE) * 100),
                ],
            'agreeableness' => 
                [ 
                    'score' => $agreeableness,
                    'total' => $maxA,
                    'percentage'=> round(($agreeableness / $maxA) * 100),
                ],
            'conscientiousness' => 
                [ 
                    'score' => $conscientiousness,
                    'total' => $maxC,
                    'percentage'=> round(($conscientiousness / $maxC) * 100),
                ],
            'neuroticism' => 
                [ 
                    'score' => $neuroticism,
                    'total' => $maxN,
                    'percentage'=> round(($neuroticism / $maxN) * 100),
                ],
            'openness' => 
                [ 
                    'score' => $openness,
                    'total' => $maxO,
                    'percentage'=> round(($openness / $maxO) * 100),
                ]
            ];
        return $result;
    }

    public function create()
    {

        $questions = PersonalAssessment::orderBy('position','asc')->get()->toArray();
        return view('assessment.create', compact('questions'));
    }

    public function view($batch_id)
    {
        $data = UserPersonalAssessment::where('batch_id',$batch_id)->first();
       
        return view('assessment.result', compact('data'));
    }
}
