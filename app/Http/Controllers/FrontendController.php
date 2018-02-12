<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worklog;
use App\Job;
use Carbon\Carbon;

class FrontendController extends Controller
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

    public function index(Request $request)
    {
        /* Fetch and sanitize parameters */

        $input = $request->all();

        $date = (isset($input['date']) && !empty($input['date']) ? $input['date'] : date('Y-m-d'));
        $timeBegin = (isset($input['time-begin']) && !empty($input['time-begin']) ? $input['time-begin'] : '');
        $timeEnd = (isset($input['time-end']) && !empty($input['time-end']) ? $input['time-end'] : '');

        /* Set Carbon locale */

        Carbon::setLocale('de');

        /* Fetch currently active worklog */

        $activeWorklog = Worklog::active()->first();

        /* Fetch finished worklogs */

        $worklogs = Worklog::finished()->today()->get();

        /* Fetch available jobs */

        $jobs = Job::open()->ordered()->get();

        /* Order jobs alphabetically while pretending month names correspond to their numeric index */

        $monthNameIndices = [
            'Januar' => '01',
            'Februar' => '02',
            'März' => '03',
            'April' => '04',
            'Mai' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'August' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Dezember' => '12',

        ];

        $jobs = $jobs
            ->sortBy(function ($job) use ($monthNameIndices) {
                $subprojectName = $job->subproject->name;

                foreach ($monthNameIndices as $monthName => $monthIndex) {
                    $subprojectName = str_replace(' ' . $monthName . ' ', ' month' . $monthIndex . ' ', $subprojectName);
                }

                $sortKey = $job->project->name . ' - ' . $subprojectName . ' - ' . $job->activity->name;

                return $sortKey;
            });

        /* Show view */

        return view('pages.index')->with(compact('activeWorklog', 'worklogs', 'jobs', 'date', 'timeBegin', 'timeEnd'));
    }
}
