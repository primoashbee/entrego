<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PersonalAssessmentDueMail;

class RecheckPersonalityAssessment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recheck-personality-assessment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = now()->copy()->subYears(2);
        $end = now()->copy()->subYear(); 
        $batch_ids = DB::table('user_personal_assessments')
            ->distinct('batch_id')
            ->whereBetween('created_at', 
            [
                $start,
                $end
            ])
            ->pluck('batch_id')
            ->toArray();
        $user_ids = DB::table('user_personal_assessments')
            ->distinct('user_id')
            ->whereIn('batch_id', $batch_ids)
            ->pluck('user_id')
            ->toArray();
        foreach($user_ids as $user_id)
        {
            $user =  User::find($user_id);
            Mail::to(
                $user->email
            )
            ->send(
                new PersonalAssessmentDueMail($user)
            );
        }
    }
}
