<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Worklog extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'notes',
        'begin_at',
        'end_at',
        'created',
        'is_exported',
        'exported_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'begin_at', 'end_at', 'exported_at'];

    /* Relationships */

    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    /* Scopes */

    public function scopeForUser($query)
    {
        return $query->where('worklogs.user_id', Auth::id());
    }

    public function scopeActive($query)
    {
        return $query->whereNull('end_at');
    }

    public function scopeFinished($query)
    {
        return $query->whereNotNull('end_at');
    }

    public function scopeLongRunning($query)
    {
        return $query;
    }

    public function scopeToday($query)
    {
        return $query->where('begin_at', '>=', Carbon::today());
    }

    public function scopeYesterday($query)
    {
        return $query->where('begin_at', '>=', Carbon::yesterday())->where('begin_at', '<', Carbon::today());
    }

    public function scopeIsExported($query)
    {
        return $query->where('is_exported', true);
    }

    public function scopeIsNotExported($query)
    {
        return $query->where('is_exported', false);
    }

    public function scopeSuspicious($query)
    {
        return $query
            ->whereRaw('(end_at - begin_at) >= \'6:00:00\'')
            ->whereRaw('(end_at - begin_at) < \'12:00:00\'');
    }

    public function scopeBlocking($query)
    {
        return $query->whereRaw('(end_at - begin_at) >= \'12:00:00\'');
    }

    public function scopeIncomplete($query)
    {
        return $query->whereHas('job', function ($query) {
            return $query
                ->whereHas('project', function ($query) {
                    return $query->whereNull('np_id');
                })
                ->orWhereHas('subproject', function ($query) {
                    return $query->whereNull('np_id');
                });
        });
    }

    /* Accessors */

    public function getHoursAttribute()
    {
        return $this->hours();
    }

    /* Methods */

    public function finish()
    {
        /* Round up to the next 15-minute slot */

        $this->end_at = $this->begin_at->addMinutes(ceil(Carbon::now()->diffInMinutes($this->begin_at) / 15) * 15);
        $this->save();
    }

    public function start($jobId, $date, $timeBegin, $timeEnd, $notes)
    {
        /* Sanitize timestamp */

        $datetime = (empty($date) ? date('Y-m-d') : $date) . ' ' . (empty($timeBegin) ? date('H:i') : $timeBegin);

        /* Set user id */

        $this->user_id = Auth::id();

        /* Start this worklog */

        $this->job_id = $jobId;
        $this->notes = $notes;
        $this->begin_at = Carbon::createFromFormat('Y-m-d H:i', $datetime);

        /* End this worklog if necessary */

        if (!empty($timeEnd)) {
            $datetime = (empty($date) ? date('Y-m-d') : $date) . ' ' . (empty($timeEnd) ? date('H:i') : $timeEnd);
            $this->end_at = Carbon::createFromFormat('Y-m-d H:i', $datetime);
        }

        /* Save this worklog */

        $this->save();
    }

    public function toNpSql()
    {
        if (empty($this->end_at)) {
            return;
        }

        $employeeId = 12;
        $employeeFunctionId = 5;
        $costPerQuarterHour = 20;

        $seconds = $this->end_at->diffInSeconds($this->begin_at);
        $quarterHours = $seconds / 60 / 15;
        $cost = $quarterHours * $costPerQuarterHour;

        $sql = 'INSERT INTO `projektarbeit` 
				(`id`, `mitarbeiterId`, `mitarbeiterFunktionId`, `projektId`, `projektteil_id`, `taetigkeitId`, `datum`, `start`, `ende`, `dauer`, `pausen`, `kostenId`, `kosten`, `ertragId`, `ertrag`, `bemerkungen`, `jobId`, `stunden`, `minuten`, `berechnungsfaktor`)
			VALUES
				(NULL, ' . $employeeId . ', ' . $employeeFunctionId . ', ' . $this->job->project->np_id . ', ' . $this->job->subproject->np_id . ', ' . $this->job->activity->np_id . ', "' . $this->begin_at->format('Y-m-d') . '", "09:00:00", "10:00:00", ' . $seconds . ', 0, 0, ' . $cost . ', 0, 0, "' . addslashes($this->notes) . '", 0, 0, 0, 100)
		;';

        return $sql;
    }

    public function duration()
    {
        return $this->begin_at->diffInMinutes($this->end_at);
    }

    public function hours()
    {
        return ceil($this->begin_at->diffInSeconds($this->end_at) / Carbon::SECONDS_PER_MINUTE / CARBON::MINUTES_PER_HOUR);
    }

    public function isSuspicious()
    {
        return $this->hours() >= 6;
    }

    public function isBlocker()
    {
        return $this->hours() >= 12;
    }

    public function isIncomplete()
    {
        return (empty($this->job->project->np_id) || empty($this->job->subproject->np_id));
    }

    public function markAsExported()
    {
        $this->is_exported = true;
        $this->exported_at = Carbon::now();
        $this->save();
    }
}
