<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\PersonalAssessment;
use App\Models\Requirement;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [];
        if(!User::hasAdminUser())
        {
            User::create([
                'email'=>config('app.admin_email'),
                'password'=>Hash::make(config('app.admin_password')),
                'role'=>User::ADMINSTRATOR,
                'uuid'=>strtoupper(Str::uuid())

            ]);
        }
        if(PersonalAssessment::count() == 0){
            $seeders[] = PersonalAssessmentSeeder::class;
        };

        if(Requirement::count() == 0){
            $seeders[] = RequirementSeeder::class;

        }
        $this->call($seeders);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
