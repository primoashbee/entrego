<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPersonalAssessment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(PersonalAssessment::class,'personal_question_id','id');
    }
    

    public function recompute()
    {
        $items = self::with('question')->where('batch_id', $this->batch_id)->get();


        $maxE = 8 * 5;
        $maxA = 9 * 5;
        $maxC = 10 * 5;
        $maxN = 7 * 5;
        $maxO = 10 * 5;

        $extraversion = $items->reduce(function($acc, $item){
            if($item->question->trait == 'E'){
                return $acc + intval($item->answer);
            }
            return $acc;
        }, 0);

        $agreeableness = $items->reduce(function($acc, $item){
            if($item->question->trait == 'A'){
                return $acc + intval($item->answer);
            }
            return $acc;
        }, 0);

        $conscientiousness = $items->reduce(function($acc, $item){
            if($item->question->trait == 'C'){
                return $acc + intval($item->answer);
            }
            return $acc;
        }, 0);

        $neuroticism = $items->reduce(function($acc, $item){
            if($item->question->trait == 'N'){
                return $acc + intval($item->answer);
            }
            return $acc;
        }, 0);

        $openness = $items->reduce(function($acc, $item){
            if($item->question->trait == 'O'){
                return $acc + intval($item->answer);
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
        
        return $items = self::with('question')->where('batch_id', $this->batch_id)
            ->update([
                'extraversion_score'=> $result['extraversion']['score'],
                'extraversion_total'=> $result['extraversion']['total'],
                'extraversion_percentage'=> $result['extraversion']['percentage'],
                'agreeableness_score'=> $result['agreeableness']['score'],
                'agreeableness_total'=> $result['agreeableness']['total'],
                'agreeableness_percentage'=> $result['agreeableness']['percentage'],
                'conscientiousness_score'=> $result['conscientiousness']['score'],
                'conscientiousness_total'=> $result['conscientiousness']['total'],
                'conscientiousness_percentage'=> $result['conscientiousness']['percentage'],
                'neuroticism_score'=> $result['neuroticism']['score'],
                'neuroticism_total'=> $result['neuroticism']['total'],
                'neuroticism_percentage'=> $result['neuroticism']['percentage'],
                'openness_score'=> $result['openness']['score'],
                'openness_total'=> $result['openness']['total'],
                'openness_percentage'=> $result['openness']['percentage'],
            ]);
    }
}
