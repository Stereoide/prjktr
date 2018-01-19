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
Auftrag: {{ route('projects.edit', ['project' => $project->id]) }}
@if (!empty($subproject->project->np_id))
NP-Auftrag: https://netproject.otterbach.de/netproject/protected/pl_projekte/details.php?pid={{ $subproject->project->np_id }}
@endif
Link: {{ route('projects.subprojects.edit', ['project' => $subproject->project->id, 'subproject' => $subproject->id]) }}
@endforeach
@endif

Prjktr aufrufen: {{ route('index') }}
