<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Log fopr command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        Log::warning("The date now is $now");
    }
}
