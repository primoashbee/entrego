<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpParser\Node\Expr\Cast\Array_;

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


    public function stats()
    {
        $attr = array_keys($this->getAttributes());
        $criterias = array_filter($attr, function($value){
            return str_contains($value, '_percentage');
        });

        $max= 10000;
        $min= 0;

        $scores = [];
        $colors = [
            'extraversion' => '#747b8a',
            'agreeableness' => '#66BB6A',
            'conscientiousness'=> '#FFA726',
            'neuroticism' => '#EC407A',
            'openness'=> '#49a3f1'
        ];
        foreach($criterias as $criteria)
        {
            $scores[] = ['criteria'=> $criteria, 'score'=>$this[$criteria]];
        }

        foreach($scores as $score)
        {
            if($score['score'] > $min){
                $max = $score;
            }

            if($score['score'] < $max){
                $min = $score;
            }
        }
        $min_array  = explode('_',$min['criteria']);
        $max_array  = explode('_',$max['criteria']);
        $min_label = ucfirst($min_array[0]);
        $max_label = ucfirst($max_array[0]);
        $min['label'] = $min_label;
        $max['label'] = $max_label;
        $max['color'] = $colors[$min_array[0]];
        $min['color'] = $colors[$max_array[0]];



        $min_statement ="";
        $max_statement ="";

        if($min_label =='Extraversion'){
            $min_statement = "Low scorers prefer solitude and quiet environments. They may find social interactions draining rather than stimulating and may feel more comfortable following others' leads rather than taking initiative. Their smaller circle of close friends reflects their preference for deeper, more intimate connections. They may struggle with social anxiety and find it challenging to meet new people.";
        }
        if($max_label =='Extraversion'){
            $max_label = "High scorers are typically outgoing and sociable, enjoying being the center of attention and initiating conversations. They are energized by social interaction and thrive in settings where they can connect with others. Their wide social circle reflects their ability to easily form meaningful connections. However, their tendency to speak without fully considering the consequences can sometimes lead to misunderstandings.";
        }
        
        if($min_label =='Agreeableness'){
            $min_statement = "Low scorers tend to be more focused on their own interests and goals. They may prioritize self-interest over the needs of others and may be less inclined to offer help or support. They may express indifference or even hostility towards those they perceive as obstacles to their objectives. Their focus on self-interest can sometimes lead to conflict and a lack of empathy for others' perspectives.";
        }
        if($max_label =='Agreeableness'){
            $max_label = "High scorers are typically polite, compassionate, and helpful. They have a great deal of interest in other people, care about others' well-being, and feel empathy and concern for others. They enjoy helping and contributing to the happiness of others and readily extend support to those in need. However, their focus on others' needs may sometimes lead them to neglect their own needs or prioritize others' interests over their own.";
        }
        

        if($min_label =='Conscientiousness'){
            $min_statement = "Low scorers may be more spontaneous and flexible. They may struggle with organization and prioritization, leading to disarray and missed deadlines. Their lack of attention to detail may result in errors and a lack of polish in their work. They may prefer to complete tasks quickly rather than meticulously, leading to subpar results.";
        }
        if($max_label =='Conscientiousness'){
            $max_label = "High scorers are typically organized, detail-oriented, and reliable. They value planning, preparation, and attention to detail, ensuring that important tasks are completed promptly and efficiently. Their preference for structure and routine brings order and tidiness to their daily lives. They prioritize completing tasks to a high standard, ensuring that all aspects are thoroughly considered and executed. However, their focus on perfection may sometimes lead to procrastination or an inability to let go of minor flaws.";
        }

        if($min_label =='Neuroticism'){
            $min_statement = "Low scorers exhibit emotional stability and resilience in the face of challenges. They remain calm and composed under pressure, able to manage their emotions effectively. Negative emotions are less frequent and intense, allowing them to maintain a positive outlook. They adapt well to changes and unexpected events, demonstrating flexibility and a willingness to embrace new experiences. Stressful situations are viewed as opportunities for growth rather than insurmountable obstacles, enabling them to recover quickly and move forward.";
        }
        if($max_label =='Neuroticism'){
            $max_label = "High scorers are typically prone to negative emotions such as anxiety, worry, and sadness. They may overthink potential problems or negative outcomes, leading to rumination and emotional distress. Stressful situations can easily overwhelm them, causing intense reactions and emotional turmoil. Their mood swings and fluctuations in emotional well-being can significantly impact their daily lives. The impact of stressful events can be prolonged and debilitating, making it difficult for them to bounce back quickly.";
        }

        if($min_label =='Openness'){
            $min_statement = "Low scorers prefer familiarity and routine over novelty and change. They tend to think in concrete terms, focusing on practical applications rather than theoretical explorations. Their preference for tradition and conformity may lead them to resist new ideas or unconventional approaches. They may view abstract concepts with skepticism, seeking clear and tangible evidence before accepting new perspectives..";
        }
        if($max_label =='Openness'){
            $max_label = "High scorers are typically curious, adventurous, and creative. They embrace new experiences, ideas, and perspectives. Their strong imagination and creative mindset fuel their interest in intellectual pursuits and abstract thinking. They value exploration and the pursuit of new possibilities, seeking to expand their horizons and broaden their understanding of the world. Their appreciation for diversity and open-mindedness fosters a willingness to consider alternative viewpoints and engage in meaningful dialogue.";
        }


        $min['statement'] = $min_statement;
        $max['statement'] = $max_label;
        
        return [
            'min'=>$min, 'max'=>$max
        ];
    }
}
