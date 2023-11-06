<?php

namespace App\Console\Commands;

use App\Jobs\ArchiveUsersJob;
use Illuminate\Console\Command;

class ArchiveUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archives the users with last activity >= 180 days ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ArchiveUsersJob::dispatch();
    }
}
