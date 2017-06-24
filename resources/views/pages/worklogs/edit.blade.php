@extends('layouts.default')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			Projektarbeit zu "{{ $worklog->job->project->name }} // {{ $worklog->job->subproject->name }}"<br />
			{{ $worklog->notes }}
		</div>
		<div class="panel-body">
			{!! Form::model($worklog, ['method' => 'PUT', 'route' => ['worklogs.update', $worklog->id], 'role' => 'form']) !!}
			{!! Form::hidden('id', $worklog->id) !!}
			
		@if (!is_null($previousWorklog))
			<div class="form-group">
				vorherige Projektarbeit war "{{ $previousWorklog->job->project->name }} // {{ $previousWorklog->job->subproject->name }}"<br />
				von {{ $previousWorklog->begin_at->format('d.m.Y H:i') }} bis {{ $previousWorklog->end_at->format('d.m.Y H:i') }}.
			</div>
		@endif
			
			<div class="form-group">
				<label for="begin_at"@if ($errors->has('begin_at')) class="error" @endif>Beginn</label>
				<div class="row">
					<div class="col-xs-3">
						{!! Form::date('begin_at_date', $worklog->begin_at->format('Y-m-d'), ['class' => 'form-control']) !!}
					</div>
					<div class="col-xs-3">
						{!! Form::time('begin_at_time', $worklog->begin_at->format('H:i'), ['class' => 'form-control']) !!}
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="end_at"@if ($errors->has('end_at')) class="error" @endif>Ende</label>
				<div class="row">
					<div class="col-xs-3">
						{!! Form::date('end_at_date', $worklog->end_at->format('Y-m-d'), ['class' => 'form-control']) !!}
					</div>
					<div class="col-xs-3">
						{!! Form::time('end_at_time', $worklog->end_at->format('H:i'), ['class' => 'form-control']) !!}
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="notes"@if ($errors->has('notes')) class="error" @endif>Kommentar</label>
				{!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 4]) !!}
			</div>
			
		@if (!is_null($nextWorklog))
			<div class="form-group">
				nächste Projektarbeit war "{{ $nextWorklog->job->project->name }} // {{ $nextWorklog->job->subproject->name }}"<br />
				von {{ $nextWorklog->begin_at->format('d.m.Y H:i') }} bis {{ $nextWorklog->end_at->format('d.m.Y H:i') }}.
			</div>
		@endif
			
			<input type="submit" class="btn btn-default" value="Speichern">
			<a href="{{ route('worklogs.index') }}#{{ $worklog->id }}" class="btn btn-default">Abbrechen</a>
			
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
