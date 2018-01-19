@if (!$blockingWorklogs->isEmpty())
Die folgenden noch nicht exportierten Arbeiten sind Blocker (> 12 Stunden)
@foreach ($blockingWorklogs as $worklog)

{{ $worklog->job->project->name }} / {{ $worklog->job->subproject->name }} @if (!empty($worklog->notes)) / {{ $worklog->notes }} @endif
({{ $worklog->begin_at->format('d.m.Y H:i') }} - {{ $worklog->end_at->format('d.m.Y H:i') }} = {{ $worklog->hours }}h)
@endforeach
@endif

@if (!$suspiciousWorklogs->isEmpty())
Die folgenden noch nicht exportierten Arbeiten sind verdächtig (> 6 Stunden)
@foreach ($suspiciousWorklogs as $worklog)

{{ $worklog->job->project->name }} / {{ $worklog->job->subproject->name }} @if (!empty($worklog->notes)) / {{ $worklog->notes }} @endif
({{ $worklog->begin_at->format('d.m.Y H:i') }} - {{ $worklog->end_at->format('d.m.Y H:i') }} = {{ $worklog->hours }}h)
Link: {{ route('worklogs.edit', ['worklog' => $worklog->id]) }}
@endforeach
@endif

Übersicht anzeigen: {{ route('worklogs.index') }}
