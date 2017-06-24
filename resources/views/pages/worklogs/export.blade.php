@extends('layouts.default')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">abgeschlossene Jobs</div>
		<div class="panel-body">
			<ul class="list-group">
			@foreach ($worklogs as $worklog)
				<li class="list-group-item" id="worklog-{{ $worklog->id }}">
					{{ $worklog->toNpSql() }}
				</li>
			@endforeach
			</ul>
		</div>
		<div class="panel-footer">
			<a href="{{ route('worklogs.index') }}" class="btn btn-default">Zurück</a>
		</div>
	</div>
</div>
@endsection
