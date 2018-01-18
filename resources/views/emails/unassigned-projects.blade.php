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
        <a href="{{ route('projects.edit', ['project' => $project->id]) }}" target="_blank">{{ $project->name }}</a><br />
    </p>
    @endforeach
@endif

@if (!$subprojects->isEmpty())
    <h1>Die folgenden Teilaufträge haben noch keine NetProject-Verknüpfung</h1>

    @foreach ($subprojects as $subproject)
    <p>
        {{ $subproject->project->name }} / <a href="{{ route('projects.subprojects.edit', ['project' => $subproject->project->id, 'subproject' => $subproject->id]) }}" target="_blank">{{ $subproject->name }}</a><br />
    </p>
    @endforeach
@endif
    <br />

    <a href="{{ route('index') }}" target="_blank">Prjktr aufrufen</a><br />
</body>
</html>
