<?php

namespace App\Http\Controllers;

use App\Mail\SuspiciousWorklogs;
use App\Mail\UnassignedProjects;
use App\Mail\UnexportedWorklogs;
use App\Mail\UnfinishedWorklogs;
use App\Project;
use App\Subproject;
use App\Worklog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MaintenanceController extends Controller
{
    public function reportSuspiciousWorklogs()
    {
        $suspiciousWorklogs = Worklog::finished()->isNotExported()->suspicious()->get();
        $blockingWorklogs = Worklog::finished()->isNotExported()->blocking()->get();

        if (!$suspiciousWorklogs->isEmpty() || !$blockingWorklogs->isEmpty()) {
            Mail::to('j.maske@otterbach.de')->send(new SuspiciousWorklogs($suspiciousWorklogs, $blockingWorklogs));
        }
    }

    public function reportUnassignedProjects()
    {
        $projects = Project::unassigned()->get();
        $subprojects = Subproject::unassigned()->get();

        if (!$projects->isEmpty() || !$subprojects->isEmpty()) {
            Mail::to('j.maske@otterbach.de')->send(new UnassignedProjects($projects, $subprojects));
        }
    }

    public function reportUnexportedWorklogs()
    {
        $worklogs = Worklog::finished()->isNotExported()->get();

        if (!$worklogs->isEmpty()) {
            Mail::to('j.maske@otterbach.de')->send(new UnexportedWorklogs($worklogs));
        }
    }

    public function reportUnfinishedWorklogs()
    {
        $worklogs = Worklog::active()->get();

        if (!$worklogs->isEmpty()) {
            Mail::to('j.maske@otterbach.de')->send(new UnfinishedWorklogs($worklogs));
        }
    }
}
