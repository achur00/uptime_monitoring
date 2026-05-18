<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Monitor;
use App\Jobs\CheckMonitorJob;

class CheckMonitorsCommand extends Command
{
    protected $signature = 'monitor:check';

    protected $description = 'Check all monitors';

    public function handle(): void
    {
        $monitors = Monitor::all();

        foreach ($monitors as $monitor) {
            CheckMonitorJob::dispatch($monitor);
        }
    }
}