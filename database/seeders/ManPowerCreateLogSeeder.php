<?php

namespace Database\Seeders;

use App\Models\ManPower;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManPowerCreateLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ManPower::with('requestor')->get()->each(function($manpower){
            $name = $manpower->requestor->full_name;
            $manpower->notes()->create([
                'done_by' => $manpower->requested_by,
                'notes'=> "Manpower request created by $name",
                'created_at'=>$manpower->created_at
            ]);
        });
    }
}
