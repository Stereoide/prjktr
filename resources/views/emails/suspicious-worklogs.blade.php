<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prjktr: Nicht abgeschlossene Arbeiten</title>
</head>
<body>
@if (!$blockingWorklogs->isEmpty())
    <h1>Die folgenden noch nicht exportierten Arbeiten sind Blocker (> 12 Stunden)</h1>

    @foreach ($blockingWorklogs as $worklog)
        <p>
            {{ $worklog->job->project->name }} / {{ $worklog->job->subproject->name }} @if (!empty($worklog->notes)) / {{ $worklog->notes }} @endif <br />
            ({{ $worklog->begin_at->format('d.m.Y H:i') }} - {{ $worklog->end_at->format('d.m.Y H:i') }} = {{ $worklog->hours }}h)<br />
        </p>
    @endforeach
@endif
    <br />

@if (!$suspiciousWorklogs->isEmpty())
    <h1>Die folgenden noch nicht exportierten Arbeiten sind verdächtig (> 6 Stunden)</h1>

    @foreach ($suspiciousWorklogs as $worklog)
        <p>
            <a href="{{ route('worklogs.edit', ['worklog' => $worklog->id]) }}" target="_blank">{{ $worklog->job->project->name }} / {{ $worklog->job->subproject->name }} @if (!empty($worklog->notes)) / {{ $worklog->notes }} @endif </a><br />
            ({{ $worklog->begin_at->format('d.m.Y H:i') }} - {{ $worklog->end_at->format('d.m.Y H:i') }} = {{ $worklog->hours }}h)<br />
        </p>
    @endforeach
@endif
    <br />

    <a href="{{ route('worklogs.index') }}" target="_blank">Übersicht anzeigen</a><br />
</body>
</html>
