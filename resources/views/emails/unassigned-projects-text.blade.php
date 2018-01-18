@if (!$projects->isEmpty())
Die folgenden Aufträge haben noch keine NetProject-Verknüpfung:
@foreach ($projects as $project)

Name: {{ $project->name }}
Link: {{ route('projects.edit', ['project' => $project->id]) }}
@endforeach
@endif

@if (!$subprojects->isEmpty())
Die folgenden Teilaufträge haben noch keine NetProject-Verknüpfung:
@foreach ($subprojects as $subproject)

Name: {{ $subproject->project->name }} / {{ $subproject->name }}
Link: {{ route('projects.subprojects.edit', ['project' => $subproject->project->id, 'subproject' => $subproject->id]) }}
@endforeach
@endif

Prjktr aufrufen: {{ route('index') }}
