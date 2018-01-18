@if (!$projects->isEmpty())
Die folgenden Aufträge haben noch keine NetProject-Verknüpfung:
@foreach ($projects as $project)

Id: {{ $project->id }}
Name: {{ $project->name }}
@endforeach
@endif

@if (!$subprojects->isEmpty())
Die folgenden Teilaufträge haben noch keine NetProject-Verknüpfung:
@foreach ($subprojects as $subproject)

Id: {{ $subproject->id }}
Name: {{ $subproject->name }}
Auftrag: {{ $subproject->project->name }}
@endforeach
@endif

Prjktr aufrufen: {{ route('index') }}
