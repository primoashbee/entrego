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
                'reversed'=> false,
                'trait'=>'E'
            ],
            [
                'position'=> 2,
                'question'=>'Tends to find fault with others',
                'reversed'=> true,
                'trait'=>'A'
            ],
            [
                'position'=> 3,
                'question'=>' Does a thorough job',
                'reversed'=> false,
                'trait'=>'C'
            ],
            [
                'position'=> 4,
                'question'=>'Is depressed, blue',
                'reversed'=> false,
                'trait'=>'N'

            ],
            [
                'position'=> 5,
                'question'=>'Is original, comes up with new ideas',
                'reversed'=> false,
                'trait'=>'O'

            ],
            [
                'position'=> 6,
                'question'=>'Is reserved ',
                'reversed'=> true,
                'trait'=>'E'

            ],
            [
                'position'=> 7,
                'question'=>'Is helpful and unselfish with others',
                'reversed'=> false,
                'trait'=>'A'

            ],
            [
                'position'=> 8,
                'question'=>'Can be somewhat careless',
                'reversed'=> true,
                'trait'=>'C'
            ],
            [
                'position'=> 9,
                'question'=>'Is relaxed, handles stress well',
                'reversed'=> true,
                'trait'=>'N'
            ],
            [
                'position'=> 10,
                'question'=>'Is curious about many different things',
                'reversed'=> false,
                'trait'=>'O'
            ],
            [
                'position'=> 11,
                'question'=>'Is full of energy',
                'reversed'=> false,
                'trait'=>'F'
            ],
            [
                'position'=> 12,
                'question'=>'Starts quarrels with others',
                'reversed'=> true,
                'trait'=>'A'
            ],
            [
                'position'=> 13,
                'question'=>'Is a reliable worker',
                'reversed'=> false,
                'trait'=>'C'
            ],
            [
                'position'=> 14,
                'question'=>'Can be tense',
                'reversed'=> false,
                'trait'=>'N'
            ],
            [
                'position'=> 15,
                'question'=>'Is ingenious, a deep thinker',
                'reversed'=> false,
                'trait'=>'O'
            ],
            [
                'position'=> 16,
                'question'=>'Generates a lot of enthusiasm',
                'reversed'=> false,
                'trait'=>'E'
            ],
            [
                'position'=> 17,
                'question'=>'Has a forgiving nature',
                'reversed'=> false,
                'trait'=>'A'
            ],
            [
                'position'=> 18,
                'question'=>'Tends to be disorganized',
                'reversed'=> true,
                'trait'=>'C'
            ],
            [
                'position'=> 19,
                'question'=>'Worries a lot',
                'reversed'=> false,
                'trait'=>'N'
            ],
            [
                'position'=> 20,
                'question'=>'Has an active imagination',
                'reversed'=> false,
                'trait'=>'O'
            ],
            [
                'position'=> 21,
                'question'=>'Tends to be quiet',
                'reversed'=> true,
                'trait'=>'E'
            ],
            [
                'position'=> 22,
                'question'=>'Is generally trusting',
                'reversed'=> false,
                'trait'=>'A'
            ],
            [
                'position'=> 23,
                'question'=>'Tends to be lazy',
                'reversed'=> true,
                'trait'=>'C'
            ],
            [
                'position'=> 24,
                'question'=>'Is emotionally stable, not easily upset',
                'reversed'=> true,
                'trait'=>'N'
            ],
            [
                'position'=> 25,
                'question'=>'Is inventive',
                'reversed'=> false,
                'trait'=>'O'
            ],
            [
                'position'=> 26,
                'question'=>'Has an assertive personality',
                'reversed'=> false,
                'trait'=>'E'
            ],
            [
                'position'=> 27,
                'question'=>'Can be cold and aloof',
                'reversed'=> true,
                'trait'=>'A'
            ],
            [
                'position'=> 28,
                'question'=>'Perseveres until the task is finished',
                'reversed'=> false,
                'trait'=>'C'
            ],
            [
                'position'=> 29,
                'question'=>'Can be moody',
                'reversed'=> false,
                'trait'=>'C'
            ],
            [
                'position'=> 30,
                'question'=>'Values artistic, aesthetic experiences',
                'reversed'=> false,
                'trait'=>'O'
            ],
            [
                'position'=> 31,
                'question'=>'Is sometimes shy, inhibited',
                'reversed'=> true,
                'trait'=>'E'
            ],
            [
                'position'=> 32,
                'question'=>'Is considerate and kind to almost everyone',
                'reversed'=> false,
                'trait'=>'A'
            ],
            [
                'position'=> 33,
                'question'=>'Does things efficiently',
                'reversed'=> false,
                'trait'=>'C'
            ],
            [
                'position'=> 34,
                'question'=>'Remains calm in tense situations',
                'reversed'=> true,
                'trait'=>'N'
            ],
            [
                'position'=> 35,
                'question'=>'Prefers work that is routine',
                'reversed'=> true,
                'trait'=>'O'
            ],
            [
                'position'=> 36,
                'question'=>'Is outgoing, sociable',
                'reversed'=> false,
                'trait'=>'E'
            ],
            [
                'position'=> 37,
                'question'=>'Is sometimes rude to others',
                'reversed'=> true,
                'trait'=>'A'
            ],
            [
                'position'=> 38,
                'question'=>'Makes plans and follows through with them',
                'reversed'=> false,
                'trait'=>'C'
            ],
            [
                'position'=> 39,
                'question'=>'Gets nervous easily',
                'reversed'=> false,
                'trait'=>'N'
            ],
            [
                'position'=> 40,
                'question'=>'Likes to reflect, play with ideas',
                'reversed'=> false,
                'trait'=>'O'
            ],
            [
                'position'=> 41,
                'question'=>'Has few artistic interests',
                'reversed'=> true,
                'trait'=>'O'
            ],
            [
                'position'=> 42,
                'question'=>'Likes to cooperate with others',
                'reversed'=> false,
                'trait'=>'A'
            ],
            [
                'position'=> 43,
                'question'=>'Is easily distracted',
                'reversed'=> true,
                'trait'=>'C'
            ],
            [
                'position'=> 44,
                'question'=>'Is sophisticated in art, music, or literature',
                'reversed'=> false,
                'trait'=>'O'
            ],
        ];

        PersonalAssessment::insert($questions);
        
    }
}
