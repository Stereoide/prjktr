<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Worklog;
use App\Mail\UnexportedWorklogs;
use Illuminate\Support\Facades\Mail;

class FindUnexportedWorklogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:find-unexported-worklogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds and reports unexported worklogs';

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
        $worklogs = Worklog::finished()->isNotExported()->get();

        if (!$worklogs->isEmpty()) {
            Mail::to('j.maske@otterbach.de')->send(new UnexportedWorklogs($worklogs));
        }
    }
}
