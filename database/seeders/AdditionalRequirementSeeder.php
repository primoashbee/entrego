<?php

namespace Database\Seeders;

use App\Models\Requirement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdditionalRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $requirements = [
            [
                'name'=>'Medical Clearance',
                'created_at'=>$now,
                'updated_at'=>$now,
                'required'=>true          
            ],
            [
                'name'=>'Transcript of Records (TOR)',
                'created_at'=>$now,
                'updated_at'=>$now,                
                'required'=>false,           
            
            ],
        ];

        Requirement::insert($requirements);
    }
}
