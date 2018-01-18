<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Worklog;
use App\Mail\UnfinishedWorklogs;
use Illuminate\Support\Facades\Mail;

class FindUnfinishedWorklogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:find-unfinished-worklogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds and reports unfinished worklogs';

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
        $worklogs = Worklog::active()->get();

        if (!$worklogs->isEmpty()) {
            Mail::to('j.maske@otterbach.de')->send(new UnfinishedWorklogs($worklogs));
        }
    }
}
