<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\JobLevel;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::query()->truncate();
        Department::query()->truncate();
        JobLevel::query()->truncate();

        $locations = [
            [
                'key'=>'DAVAO',
                'value'=>'Davao',
            ],
            [
                'key'=>'CEBU',
                'value'=>'Cebu',
            ],
            [
                'key'=>'NCR',
                'value'=>'NCR',
            ],
            [
                'key'=>'PAMPANGA',
                'value'=>'Pampanga',
            ],
            [
                'key'=>'LEGAZPI',
                'value'=>'Legazpi',
            ],
        ];

        $departments = [
            [
                'key'=>'IT_DEPT',
                'value'=>'Information Technology Department'
            ],
            [
                'key'=>'HR_DEPT',
                'value'=>'Human Resources Department'
            ],
            [
                'key'=>'FAD_DEPT',
                'value'=>'Finance and Accounting Department'
            ],
            [
                'key'=>'OPS_DEPT',
                'value'=>'Operations Department'
            ],
        ];

        Location::insert($locations);
        Department::insert($departments);
    }
}
