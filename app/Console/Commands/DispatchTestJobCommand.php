<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use App\Console\Commands\TestJob;
use App\Jobs\TestJob;
class DispatchTestJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:test-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a test job';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        dispatch(new TestJob());

        $this->info('Test job dispatched.');
    }
}
