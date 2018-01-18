Die folgenden Arbeiten sind zum aktuellen Zeitpunkt noch nicht exportiert:
@foreach ($worklogs as $worklog)

{{ $worklog->job->project->name }} / {{ $worklog->job->subproject->name }} @if (!empty($worklog->notes))/ {{ $worklog->notes }} @endif
@endforeach

Export starten: {{ route('worklogs.export') }}
