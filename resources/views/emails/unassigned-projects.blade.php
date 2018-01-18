<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prjktr: Nicht zugeordnete Projekte</title>
</head>
<body>
@if (!$projects->isEmpty())
    <h1>Die folgenden Aufträge haben noch keine NetProject-Verknüpfung</h1>

    @foreach ($projects as $project)
    <p>
        Id: {{ $project->id }}<br />
        Name: {{ $project->name }}<br />
    </p>
    @endforeach
@endif

@if (!$subprojects->isEmpty())
    <h1>Die folgenden Teilaufträge haben noch keine NetProject-Verknüpfung</h1>

    @foreach ($subprojects as $subproject)
    <p>
        Id: {{ $subproject->id }}<br />
        Name: {{ $subproject->name }}<br />
        Auftrag: {{ $subproject->project->name }}<br />
    </p>
    @endforeach
@endif
    <br />

    <a href="{{ route('index') }}" target="_blank">Prjktr aufrufen</a><br />
</body>
</html>
