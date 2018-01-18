<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Worklog;
use App\Mail\SuspiciousWorklogs;
use Illuminate\Support\Facades\Mail;

class FindSuspiciousWorklogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:find-suspicious-worklogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds and reports suspicious and blocking worklogs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $suspiciousWorklogs = Worklog::finished()->isNotExported()->suspicious()->get();
        $blockingWorklogs = Worklog::finished()->isNotExported()->blocking()->get();

        if (!$suspiciousWorklogs->isEmpty() || !$blockingWorklogs->isEmpty()) {
            Mail::to('j.maske@otterbach.de')->send(new SuspiciousWorklogs($suspiciousWorklogs, $blockingWorklogs));
        }
    }
}
