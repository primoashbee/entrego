<?php

namespace Database\Seeders;

use App\Models\PersonalAssessment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions =[
            [
                'position'=> 1,
                'question'=>'Is talkative',
                'reversed'=> false
            ],
            [
                'position'=> 2,
                'question'=>'Tends to find fault with others',
                'reversed'=> true
            ],
            [
                'position'=> 3,
                'question'=>' Does a thorough job',
                'reversed'=> false
            ],
            [
                'position'=> 4,
                'question'=>'Is depressed, blue',
                'reversed'=> false
            ],
            [
                'position'=> 5,
                'question'=>'Is original, comes up with new ideas',
                'reversed'=> false
            ],
            [
                'position'=> 6,
                'question'=>'Is reserved ',
                'reversed'=> true
            ],
            [
                'position'=> 7,
                'question'=>'Is helpful and unselfish with others',
                'reversed'=> false
            ],
            [
                'position'=> 8,
                'question'=>'Can be somewhat careless',
                'reversed'=> true
            ],
            [
                'position'=> 9,
                'question'=>'Is relaxed, handles stress well',
                'reversed'=> true
            ],
            [
                'position'=> 10,
                'question'=>'Is curious about many different things',
                'reversed'=> false
            ],
            [
                'position'=> 11,
                'question'=>'Is full of energy',
                'reversed'=> false
            ],
            [
                'position'=> 12,
                'question'=>'Starts quarrels with others',
                'reversed'=> true
            ],
            [
                'position'=> 13,
                'question'=>'Is a reliable worker',
                'reversed'=> false
            ],
            [
                'position'=> 14,
                'question'=>'Can be tense',
                'reversed'=> false
            ],
            [
                'position'=> 15,
                'question'=>'Is ingenious, a deep thinker',
                'reversed'=> false
            ],
            [
                'position'=> 16,
                'question'=>'Generates a lot of enthusiasm',
                'reversed'=> false
            ],
            [
                'position'=> 17,
                'question'=>'Has a forgiving nature',
                'reversed'=> false
            ],
            [
                'position'=> 18,
                'question'=>'Tends to be disorganized',
                'reversed'=> true
            ],
            [
                'position'=> 19,
                'question'=>'Worries a lot',
                'reversed'=> false
            ],
            [
                'position'=> 20,
                'question'=>'Has an active imagination',
                'reversed'=> false
            ],
            [
                'position'=> 21,
                'question'=>'Tends to be quiet',
                'reversed'=> true
            ],
            [
                'position'=> 22,
                'question'=>'Is generally trusting',
                'reversed'=> false
            ],
            [
                'position'=> 23,
                'question'=>'Tends to be lazy',
                'reversed'=> true
            ],
            [
                'position'=> 24,
                'question'=>'Is emotionally stable, not easily upset',
                'reversed'=> true
            ],
            [
                'position'=> 25,
                'question'=>'Is inventive',
                'reversed'=> false
            ],
            [
                'position'=> 26,
                'question'=>'Has an assertive personality',
                'reversed'=> false
            ],
            [
                'position'=> 27,
                'question'=>'Can be cold and aloof',
                'reversed'=> true
            ],
            [
                'position'=> 28,
                'question'=>'Perseveres until the task is finished',
                'reversed'=> false
            ],
            [
                'position'=> 29,
                'question'=>'Can be moody',
                'reversed'=> false
            ],
            [
                'position'=> 30,
                'question'=>'Values artistic, aesthetic experiences',
                'reversed'=> false
            ],
            [
                'position'=> 31,
                'question'=>'Is sometimes shy, inhibited',
                'reversed'=> true
            ],
            [
                'position'=> 32,
                'question'=>'Is considerate and kind to almost everyone',
                'reversed'=> false
            ],
            [
                'position'=> 33,
                'question'=>'Does things efficiently',
                'reversed'=> false
            ],
            [
                'position'=> 34,
                'question'=>'Remains calm in tense situations',
                'reversed'=> true
            ],
            [
                'position'=> 35,
                'question'=>'Prefers work that is routine',
                'reversed'=> true
            ],
            [
                'position'=> 36,
                'question'=>'Is outgoing, sociable',
                'reversed'=> false
            ],
            [
                'position'=> 37,
                'question'=>'Is sometimes rude to others',
                'reversed'=> true
            ],
            [
                'position'=> 38,
                'question'=>'Makes plans and follows through with them',
                'reversed'=> false
            ],
            [
                'position'=> 39,
                'question'=>'Gets nervous easily',
                'reversed'=> false
            ],
            [
                'position'=> 40,
                'question'=>'Likes to reflect, play with ideas',
                'reversed'=> false
            ],
            [
                'position'=> 41,
                'question'=>'Has few artistic interests',
                'reversed'=> true
            ],
            [
                'position'=> 42,
                'question'=>'Likes to cooperate with others',
                'reversed'=> false
            ],
            [
                'position'=> 43,
                'question'=>'Is easily distracted',
                'reversed'=> true
            ],
            [
                'position'=> 44,
                'question'=>'Is sophisticated in art, music, or literature',
                'reversed'=> false
            ],
        ];

        PersonalAssessment::insert($questions);
        
    }
}
