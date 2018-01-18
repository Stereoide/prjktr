<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;
use App\Subproject;
use App\Mail\UnassignedProjects;
use Illuminate\Support\Facades\Mail;

class FindUnassignedProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:find-unassigned-projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds and reports projects and subprojects that have no NetProject id assigned';

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
        $projects = Project::unassigned()->get();
        $subprojects = Subproject::unassigned()->get();

        if (!$projects->isEmpty() || !$subprojects->isEmpty()) {
            Mail::to('j.maske@otterbach.de')->send(new UnassignedProjects($projects, $subprojects));
        }
    }
}
