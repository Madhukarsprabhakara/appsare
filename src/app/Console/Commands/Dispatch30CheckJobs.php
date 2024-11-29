<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tracker;
use App\Jobs\WebsiteStatusCheck30;
class Dispatch30CheckJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch30-check-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch all 30 second website check jobs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $trackers = Tracker::where('check_frequency', 'every_30s')->where('is_active', true)->where('is_archived', false)->get(['id','url']);
        foreach ($trackers as $tracker) {
            WebsiteStatusCheck30::dispatch($tracker->id, $tracker->url);
        }
    }
}
