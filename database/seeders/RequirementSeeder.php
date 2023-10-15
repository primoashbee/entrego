<?php

namespace Database\Seeders;

use App\Models\Requirement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $requirements = [
            [
                'name'=>'NBI Clearance',
                'created_at'=>$now,
                'updated_at'=>$now                
            ],
            [
                'name'=>'SSS',
                'created_at'=>$now,
                'updated_at'=>$now                
            ],
            [
                'name'=>'Philhealth',
                'created_at'=>$now,
                'updated_at'=>$now                
            ],
            [
                'name'=>'TIN',
                'created_at'=>$now,
                'updated_at'=>$now                
            ],
            [
                'name'=>'VALID ID',
                'created_at'=>$now,
                'updated_at'=>$now                
            ],
        ];

        Requirement::insert($requirements);
    }
}
