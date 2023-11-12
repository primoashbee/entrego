<?php

namespace App\Console\Commands;

use App\Models\Requirement;
use App\Models\UserRequirement;
use Illuminate\Console\Command;
use App\Models\UserJobApplication;

class SyncUserRequirementsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:sync-requirements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs user requirements of job applications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $list = Requirement::select('id')->get();

        UserJobApplication::with('user')
            ->where('status', UserJobApplication::FOR_REQUIREMENTS)
            ->each(function($job) use ($list){
                foreach($list as $item){
                    if($job->user->requirements()->where('requirement_id',$item->id)->count() == 0)
                    {
                        $inserts[] = [
                            'requirement_id' => $item->id,
                            'user_id' => $job->user->id,
                            'status'=> UserRequirement::MISSING
                        ];
                    }
                }
        
                if(count($inserts)){
                    UserRequirement::insert($inserts);
                    return $job->user->requirements->load('requirement');
                }
            });
    }
}
