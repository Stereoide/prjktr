<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worklog;
use Carbon\Carbon;

class WorklogController extends Controller
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
    public function index(Request $request)
    {
        /* Set Carbon locale */

        Carbon::setLocale('de');

        /* Fetch input parameters */

        $input = $request->all();

        $dateFrom = (isset($input['date-from']) && !empty($input['date-from']) ? $input['date-from'] : date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))));
        $dateTo = (isset($input['date-to']) && !empty($input['date-to']) ? $input['date-to'] : date('Y-m-d'));
        $highlightMissingDays = (isset($input['highlight-missing-days']) && !empty($input['highlight-missing-days']));
        $exportStatus = (isset($input['export-status']) && !empty($input['export-status']) ? $input['export-status'] : 'all');
        $worklogValidity = (isset($input['worklog-validity']) && !empty($input['worklog-validity']) ? $input['worklog-validity'] : 'all');
        $worklogSuspiciousness = (isset($input['worklog-suspiciousness']) && !empty($input['worklog-suspiciousness']) ? $input['worklog-suspiciousness'] : 'all');

        /* Fetch finished worklogs */

        $worklogs = Worklog::with('job.project', 'job.subproject')->forUser()->finished()->where('begin_at', '>=', $dateFrom . ' 00:00:00')->where('end_at', '<=', $dateTo . ' 23:59:59');

        /* Respect desired export status */

        if ('exported' == $exportStatus) {
            $worklogs->isExported();
        } else if ('unexported' == $exportStatus) {
            $worklogs->isNotExported();
        }

        $worklogs = $worklogs->get();

        /* Respect worklog validity */

        if ('all' != $worklogValidity) {
            $worklogs = $worklogs->reject(function ($worklog) use ($worklogValidity) {
                $isValid = !empty($worklog->user->np_id) && !empty($worklog->job->project->np_id) && !empty($worklog->job->subproject->np_id);
                $needsRejection = (('valid' == $worklogValidity && !$isValid) || ('invalid' == $worklogValidity && $isValid));
                return $needsRejection;
            });
        }

        /* Respect worklog suspiciousness */

        if ('all' != $worklogSuspiciousness) {
            $worklogs = $worklogs->reject(function ($worklog) use ($worklogSuspiciousness) {
                $hours = $worklog->hours();

                $isOk = (6 > $hours);
                $isSuspicious = (6 <= $hours && 12 > $hours);
                $isBlocker = (12 <= $hours);

                $needsRejection = (('ok' == $worklogSuspiciousness && !$isOk) || ('suspicious' == $worklogSuspiciousness && !$isSuspicious) || ('blocker' == $worklogSuspiciousness && !$isBlocker));
                return $needsRejection;
            });
        }

        /* Sort worklogs into days */

        $days = [];
        foreach ($worklogs as $worklog) {
            $dateString = $worklog->begin_at->toDateString();

            if (!isset($days[$dateString])) {
                $days[$dateString] = [
                    'worklogs' => [],
                    'duration' => 0,
                    'timestamp' => $worklog->begin_at->timestamp,
                ];
            }

            $days[$dateString]['worklogs'][] = $worklog;
            // $durationSeconds = $worklog->begin_at->diffForHumans($worklog->end_at, true)
            $days[$dateString]['duration'] += $worklog->begin_at->diffInSeconds($worklog->end_at);
        }

        /* Fill missing days if necessary */


        if ($highlightMissingDays) {
            $carbon = Carbon::createFromFormat('Y-m-d', $dateFrom);
            $timestamp = $carbon->timestamp;

            $carbon = Carbon::createFromFormat('Y-m-d', $dateTo);
            $timestampTo = $carbon->timestamp;

            while ($timestamp <= $timestampTo) {
                $carbon = Carbon::createFromTimestamp($timestamp);
                $dateString = $carbon->toDateString();

                /* Check whether this day was on a weekend */

                if (!$carbon->isWeekend()) {
                    /* Insert empty day if necessary */

                    if (!isset($days[$dateString])) {
                        $days[$dateString] = [
                            'worklogs' => [],
                            'duration' => 0,
                            'timestamp' => $carbon->timestamp,
                        ];
                    }
                }

                /* Increment day */

                $carbon->addDay();
                $timestamp = $carbon->timestamp;
            }

            /* Sort days array */

            ksort($days);
        }

        /* Show view */

        return view('pages.worklogs.index')->with(compact('days', 'dateFrom', 'dateTo', 'highlightMissingDays', 'exportStatus', 'worklogValidity', 'worklogSuspiciousness'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        /* Set Carbon locale */

        $locale = setlocale(LC_TIME, 'German');
        Carbon::setLocale('de');

        /* Fetch finished worklogs */

        $worklogs = Worklog::with('job.project', 'job.subproject')->forUser()->finished()->isNotExported()->get();

        /* Remove invalid worklogs */

        $worklogs = $worklogs->reject(function ($worklog, $key) {
            return (empty($worklog->user->np_id) || empty($worklog->job->project->np_id) || empty($worklog->job->subproject->np_id));
        });

        /* Mark worklogs as exported */

        foreach ($worklogs as $worklog) {
            $worklog->markAsExported();
        }

        /* Show view */

        return view('pages.worklogs.export')->with(compact('worklogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* Fetch worklog */

        $worklog = Worklog::forUser()->findOrFail($id);

        /* Fetch previous and next worklog if possible */

        $previousWorklog = Worklog::forUser()->find($id - 1);

        $nextWorklog = Worklog::forUser()->find($id + 1);

        /* Show view */

        return view('pages.worklogs.edit')->with(compact('worklog', 'previousWorklog', 'nextWorklog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* Sanitize inputs */

        $input = $request->all();

        $beginAt = Carbon::createFromFormat('Y-m-d H:i', $input['begin_at_date'] . ' ' . $input['begin_at_time']);
        $endAt = Carbon::createFromFormat('Y-m-d H:i', $input['end_at_date'] . ' ' . $input['end_at_time']);

        /* Fetch and update model */

        $worklog = Worklog::forUser()->findOrFail($id);
        $worklog->begin_at = $beginAt;
        $worklog->end_at = $endAt;
        $worklog->notes = $input['notes'];
        $worklog->save();

        /* Redirect back to overview */

        return redirect(route('worklogs.index') . '#' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function finish(Request $request)
    {
        /* Fetch and finish a currently unfinished worklog first */

        $worklog = Worklog::forUser()->active()->first();

        if (!is_null($worklog)) {
            $worklog->finish();
        }

        /* Redirect to index page */

        return redirect(route('index'));
    }

    public function start(Request $request)
    {
        $jobId = $request->jobId;
        $date = $request->date;
        $timeBegin = $request->timeBegin;
        $timeEnd = $request->timeEnd;
        $notes = $request->notes;

        /* Fetch and finish a currently unfinished worklog first */

        $worklog = Worklog::forUser()->active()->first();

        if (!is_null($worklog)) {
            $worklog->finish();
        }

        /* Start a new worklog with the given job */

        $worklog = new Worklog;
        $worklog->start($jobId, $date, $timeBegin, $timeEnd, $notes);

        /* Redirect to index page */

        return redirect(route('index'));
    }

    public function restart(Worklog $worklog)
    {
        /* Get parameters used last time */

        $jobId = $worklog->job_id;
        $notes = $worklog->notes;

        /* Start new worklog */

        $worklog = new Worklog;
        $worklog->start($jobId, null, null, null, $notes);

        /* Redirect to index page */

        return redirect(route('index'));
    }
}
