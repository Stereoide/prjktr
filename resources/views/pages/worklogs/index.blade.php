@extends('layouts.default')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Filter</div>
		<div class="panel-body">
			<form action="{{ url('worklogs') }}" method="get">

			<div class="row">
				<div class="col-xs-2">Von</div>
				<div class="col-xs-2">Bis</div>
			</div>
			<div class="row">
				<div class="col-xs-2">
					<input type="date" name="date-from" id="date-from" size="10" maxlength="10" value="{{ $dateFrom }}" />
				</div>
				<div class="col-xs-2">
					<input type="date" name="date-to" id="date-to" size="10" maxlength="10" value="{{ $dateTo }}" />
				</div>
				<div class="col-xs-3">
					<input type="checkbox" name="highlight-missing-days" id="highlight-missing-days" value="true" @if ($highlightMissingDays) checked @endif /> <label for="highlight-missing-days">fehlende Tage markieren</label>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-4">
					<input type="radio" name="export-status" id="export-status-all" value="all" @if ('all' == $exportStatus) checked @endif /> <label for="export-status-all">alles</label>
					<input type="radio" name="export-status" id="export-status-exported" value="exported" @if ('exported' == $exportStatus) checked @endif /> <label for="export-status-exported">exportierte</label>
					<input type="radio" name="export-status" id="export-status-not-exported" value="unexported" @if ('unexported' == $exportStatus) checked @endif /> <label for="export-status-not-exported">nicht exportierte</label>
				</div>

				<div class="col-xs-4">
					<input type="radio" name="worklog-validity" id="worklog-validity-all" value="all" @if ('all' == $worklogValidity) checked @endif /> <label for="worklog-validity-all">alles</label>
					<input type="radio" name="worklog-validity" id="worklog-validity-valid" value="valid" @if ('valid' == $worklogValidity) checked @endif /> <label for="worklog-validity-valid">vollständige</label>
					<input type="radio" name="worklog-validity" id="worklog-validity-invalid" value="invalid" @if ('invalid' == $worklogValidity) checked @endif /> <label for="worklog-validity-invalid">unvollständige</label>
				</div>

				<div class="col-xs-4">
					<input type="radio" name="worklog-suspiciousness" id="worklog-suspiciousness-all" value="all" @if ('all' == $worklogSuspiciousness) checked @endif /> <label for="worklog-suspiciousness-all">alles</label>
					<input type="radio" name="worklog-suspiciousness" id="worklog-suspiciousness-ok" value="ok" @if ('ok' == $worklogSuspiciousness) checked @endif /> <label for="worklog-suspiciousness-ok">OK</label>
					<input type="radio" name="worklog-suspiciousness" id="worklog-suspiciousness-suspicious" value="suspicious" @if ('suspicious' == $worklogSuspiciousness) checked @endif /> <label for="worklog-suspiciousness-suspicious">verdächtig</label>
					<input type="radio" name="worklog-suspiciousness" id="worklog-suspiciousness-blocker" value="blocker" @if ('blocker' == $worklogSuspiciousness) checked @endif /> <label for="worklog-suspiciousness-blocker">Blocker</label>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<input type="submit" name="submit" id="submit" value="Aktualisieren" />
				</div>
			</div>

			</form>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">abgeschlossene Jobs</div>
		<div class="panel-body">
			<ul class="list-group">
		@foreach ($days as $dateString => $day)
				<li class="list-group-item worklog-day @if (0 == count($day['worklogs'])) list-group-item-danger @else list-group-item-success @endif ">
					{{ Carbon\Carbon::createFromTimestamp($day['timestamp'])->format('d.m.Y, l') }}
					<span class="badge">{{ ceil($day['duration'] / Carbon\Carbon::SECONDS_PER_MINUTE / Carbon\Carbon::MINUTES_PER_HOUR) }} Stunden</span>
				</li>
			@foreach ($day['worklogs'] as $worklog)
				<li class="list-group-item" id="worklog-{{ $worklog->id }}">
				@if ($worklog->isBlocker())
					<span class="label label-danger">blocker</span>
				@elseif ($worklog->isSuspicious())
					<span class="label label-warning">verdächtig</span>
				@endif
				@if ($worklog->isIncomplete())
					<span class="label label-info">unvollständig</span>
				@endif

					<strong><a name="{{ $worklog->id }}" href="{{ url('projects/' . $worklog->job->project->id . '/edit') }}" class="@if (empty($worklog->job->project->np_id)) text-danger @else text-success @endif">{{ $worklog->job->project->name }}</a> // <a href="{{ url('projects/' . $worklog->job->project->id . '/subprojects/' . $worklog->job->subproject->id . '/edit') }}" class="@if (empty($worklog->job->subproject->np_id)) text-danger @else text-success @endif">{{ $worklog->job->subproject->name }}</a> // <span>{{ $worklog->job->activity->name }}</span></strong><br />
				@if (!empty($worklog->notes))
					{{ $worklog->notes }}<br />
				@endif
					{{ $worklog->begin_at->formatLocalized('%A %d.%m.%Y') }}, {{ $worklog->begin_at->format('H:i') }} bis {{ $worklog->end_at->format('H:i') }} ({{ $worklog->begin_at->diffForHumans($worklog->end_at, true) }})<br />
					Status: @if ($worklog->is_exported) <span class="text-success">exportiert</span> @else <span class="text-danger">nicht exportiert</span> @endif <br />
                @if (!$worklog->is_exported)
                    <a href="{{ route('worklogs.edit', [$worklog->id, ]) }}" class="btn btn-default">bearbeiten</a>
                @endif
				</li>
			@endforeach
		@endforeach
            </ul>
        </div>
        <div class="panel-footer">
            <a href="{{ route('worklogs.export') }}" class="btn btn-default">Exportieren</a>
            <a href="{{ route('index') }}" class="btn btn-default">Zurück</a>
        </div>
	</div>
</div>
@endsection
