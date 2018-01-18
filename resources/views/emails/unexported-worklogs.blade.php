<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prjktr: Nicht exportierte Arbeiten</title>
</head>
<body>
    <h1>Die folgenden abgeschlossenen Arbeiten sind zum aktuellen Zeitpunkt noch nicht exportiert</h1>

@foreach ($worklogs as $worklog)
    {{ $worklog->job->project->name }} / {{ $worklog->job->subproject->name }} @if (!empty($worklog->notes)) / {{ $worklog->notes }} @endif <br />
@endforeach
    <br />

    <a href="{{ route('worklogs.export') }}" target="_blank">Export starten</a><br />
</body>
</html>
