@extends('layouts.default')

@section('content')
<script>
	var jobId = null;
	var $startJobClicker = null;
	
	$(function() {
		$startJobClicker = $("#startjob-clicker");
		
		$(".job-clicker").click(function(e) {
			e.preventDefault();
			
			var $job = $(this);
			jobId = $job.data("job-id");
			
			$(".job-clicker").removeClass("active");
			$job.addClass("active");
			
			$startJobClicker.removeClass("disabled");
		});

		$startJobClicker.click(function(e) {
			if (null != jobId) {
                var date = $("#date").val();
                if ("" == date) {
                    date = 0;
                }

                var timeBegin = $("#time-begin").val();
                if ("" == timeBegin) {
                    timeBegin = "0";
                }

                var timeEnd = $("#time-end").val();
                if ("" == timeEnd) {
                    timeEnd = "0";
                }

                var notes = $("#notes").val();
                if ("" == notes) {
                    notes = "0";
                }

                var url = "{{ url('worklogs/start') }}";
                url += "?jobId=" + jobId;
                url += "&date=" +  encodeURIComponent(date);
                url += "&timeBegin=" + encodeURIComponent(timeBegin);
                url += "&timeEnd=" + encodeURIComponent(timeEnd);
                url += "&notes=" + encodeURIComponent(notes);
                document.location = url;
			}
		});

		$(".job-close-clicker").click(function(e) {
		    e.preventDefault();


		    var $job = $(this);
		    var jobId = $job.data("id");

            document.location = "{{ route('jobs.close', 'YAY') }}".replace("/YAY/", "/" + jobId + "/");
		    return false;
		});

		$("#show-job-links-clicker").change(function(e) {
			$("#job-list").toggleClass("show-job-links");
		});
	});
</script>

<div class="container">
@if (!is_null($activeWorklog))
	<div class="panel panel-default">
		<div class="panel-heading">Aktueller Job</div>

		<div class="panel-body">
			<strong>{{ $activeWorklog->job->project->name }} // {{ $activeWorklog->job->subproject->name }} // {{ $activeWorklog->job->activity->name }}</strong><br />
		@if (!empty($activeWorklog->notes))
			{{ $activeWorklog->notes }}<br />
		@endif
			Aktiv seit {{ $activeWorklog->begin_at->format('d.m.Y H:i') }} ({{ $activeWorklog->begin_at->diffForHumans(Carbon\Carbon::now(), true) }})
		</div>
		
		<div class="panel-footer">
			<a href="{{ route('worklogs.finish') }}" class="btn btn-default">Job beenden</a>
		</div>
	</div>
@endif
	
	<div class="panel panel-default">
		<div class="panel-heading">
			verfügbare Aufträge &nbsp;&nbsp;&nbsp;
			<input type="checkbox" id="show-job-links-clicker" value="true" /> <label for="show-job-links-clicker">Bearbeitungs-Links anzeigen</label>
		</div>

		<div class="panel-body">
			<div id="job-list" class="list-group">
			@foreach ($jobs as $job)
				<a href="" class="list-group-item job-clicker" data-job-id="{{ $job->id }}">
					<strong>{{ $job->project->name }} // {{ $job->subproject->name }} // {{ $job->activity->name }}</strong><br />
				@if (!empty($job->description))
					{{ $job->description }}<br />
				@endif
					<div class="job-links">
						<span class="job-close-clicker" data-id="{{ $job->id }}">schließen</span>
					</div>
				</a>
			@endforeach
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-xs-3">
						<label for="date">Datum</label>
					</div>
					<div class="col-xs-3">
						<label for="time-begin">Startzeit</label>
					</div>
					<div class="col-xs-3">
						<label for="time-end">Endzeit</label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<input type="date" name="date" id="date" value="{{ $date }}" />
					</div>
					<div class="col-xs-3">
						<input type="time" name="time-begin" id="time-begin" value="{{ $timeBegin }}" />
					</div>
					<div class="col-xs-3">
						<input type="time" name="time-end" id="time-end" value="{{ $timeEnd }}" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="notes"@if ($errors->has('notes')) class="error" @endif>Notizen zum Job</label>
				<textarea name="notes" id="notes" class="form-control"></textarea>
			</div>
		</div>
		
		<div class="panel-footer">
			<div class="row">
				<div class="col-xs-12">
					<span id="startjob-clicker" class="btn btn-default disabled">Job starten</span>
					<a href="{{ route('jobs.create') }}" class="btn btn-default">neuen Auftrag erstellen</a>
					<a href="{{ route('worklogs.index') }}" class="btn btn-default">Protokolle</a>
				</div>
			</div>
		</div>
	</div>
	
@if (!$worklogs->isEmpty())
	<div class="panel panel-default">
		<div class="panel-heading">Jobs von heute</div>
		<div class="panel-body">
			<ul class="list-group">
			@foreach ($worklogs as $worklog)
				<li class="list-group-item">
					<strong><span @if (empty($worklog->job->project->np_id)) class="text-danger"@endif>{{ $worklog->job->project->name }}</span> // <span @if (empty($worklog->job->subproject->np_id)) class="text-danger"@endif>{{ $worklog->job->subproject->name }}</span> // <span>{{ $worklog->job->activity->name }}</span></strong><br />
				@if (!empty($worklog->notes))
					{{ $worklog->notes }}<br />
				@endif
					{{ $worklog->begin_at->format('H:i') }} bis {{ $worklog->end_at->format('H:i') }} ({{ $worklog->begin_at->diffForHumans($worklog->end_at, true) }})<br />

                    <a href="{{ route('worklogs.edit', [$worklog->id, ]) }}" class="btn btn-default">bearbeiten</a>
                @if ($worklog->job->is_open && (is_null($activeWorklog) || $activeWorklog->job_id != $worklog->job_id))
                    <a href="{{ route('worklogs.restart', [$worklog->id, ]) }}" class="btn btn-default">diese Arbeit wiederaufnehmen</a><br />
                @endif
				</li>
			@endforeach
			</ul>
		</div>
	</div>
@endif
</div>
@endsection
