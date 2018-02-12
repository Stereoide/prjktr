<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Project;
use App\Subproject;
use App\Activity;
use App\Worklog;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function create()
    {
        /* Instantiate empty Job object */

        $job = new Job;
        $job->activity_id = 5;

        /* Fetch projects, subprojects and activities */

        $projects = Project::forUser()->ordered()->get();
        $activities = Activity::ordered()->get();

        /* Show view */

        return view('pages.jobs.create')->with(compact('job', 'projects', 'activities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request)
    {
        $input = $request->all();

        $projectId = $input['project_id'];
        $projectName = trim($input['project_name']);
        $subprojectId = $input['subproject_id'];
        $subprojectName = trim($input['subproject_name']);
        $activityId = $input['activity_id'];
        $description = trim($input['description']);

        if ((empty($projectId) && empty($projectName)) || (empty($subprojectId) && empty($subprojectName)) || empty($activityId)) {
            return redirect(route('jobs.create'));
        }

        /* Try to fetch matching project */

        if (!empty($projectName)) {
            $project = Project::forUser()->where('name', 'LIKE', $projectName)->first();

            if (empty($project)) {
                /* Create project */

                $project = new Project;
                $project->name = $projectName;
                $project->user_id = Auth::id();
                $project->save();
            }

            $projectId = $project->id;
        }

        /* Try to fetch matching subproject */

        if (!empty($subprojectName)) {
            $subproject = Subproject::where('project_id', $projectId)->where('name', 'LIKE', $subprojectName)->first();

            if (empty($subproject)) {
                /* Create subproject */

                $subproject = new subproject;
                $subproject->project_id = $projectId;
                $subproject->name = $subprojectName;
                $subproject->save();
            }

            $subprojectId = $subproject->id;
        }

        /* Try to fetch matching job */

        $job = Job::forUser()->where('project_id', $projectId)->where('subproject_id', $subprojectId)->where('activity_id', $activityId)->where('description', $description)->first();

        if (empty($job)) {
            /* Create job */

            $job = new Job;
            $job->project_id = $projectId;
            $job->subproject_id = $subprojectId;
            $job->activity_id = $activityId;
            $job->description = $description;
            $job->status = 'open';
            $job->user_id = Auth::id();
            $job->save();
        }

        /* Set session message */

        $request->session()->flash('message', 'Job erstellt');

        /* Redirect back to category list */

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id)
    {
        //
    }

    function close($jobId)
    {
        /* Close job */

        $job = Job::forUser()->find($jobId);
        $job->status = 'closed';
        $job->save();

        /* Redirect to homepage */

        return redirect(route('index'));
    }
}
