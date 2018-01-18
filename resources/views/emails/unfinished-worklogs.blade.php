<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prjktr: Nicht abgeschlossene Arbeiten</title>
</head>
<body>
    <h1>Die folgenden Arbeiten sind zum aktuellen Zeitpunkt noch nicht abgeschlossen</h1>

@foreach ($worklogs as $worklog)
    {{ $worklog->job->project->name }} / {{ $worklog->job->subproject->name }} @if (!empty($worklog->notes)) / {{ $worklog->notes }} @endif <br />
    (seit {{ $worklog->begin_at->format('d.m.Y H:i') }} Uhr)<br />
@endforeach
    <br />

    <a href="{{ route('index') }}" target="_blank">Prjktr aufrufen</a><br />
</body>
</html>
