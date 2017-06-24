@extends('layouts.default')

@section('content')
{!! Form::model($job, ['method' => 'POST', 'route' => ['jobs.store', $job->id], 'role' => 'form']) !!}

<script>
	let projects = [];
@foreach ($projects as $project)
	projects[{{ $project->id }}] = [];
	@foreach ($project->subprojects as $subproject)
	projects[{{ $project->id }}][{{ $subproject->id }}] = "{{ $subproject->name }}";
	@endforeach
@endforeach

	let $projectId, $subprojectId;
	
	$(function() {
		$projectId = $("#project_id");
		$subprojectId = $("#subproject_id");
		
		$projectId
			.change(function() {
				var $this = $(this);
				
				/* Remove all but the first subproject options */
				
				$subprojectId.find("option:gt(0)").remove();

				/* Add in all subprojects for the selected project if necessary */

				var projectId = $this.val();

				if ("" != projectId) {
					for (var subprojectId in projects[projectId]) {
						$("<option value='" + subprojectId + "'>" + projects[projectId][subprojectId] + "</option>").appendTo($subprojectId);
					}
				}
			})
			.change();
	});
</script>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Neuen Job erstellen</div>
				
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="project_id"@if ($errors->has('project_id')) class="error" @endif>Auftrag</label>
								<select name="project_id" id="project_id" size="1" class="form-control">
									<option value="">[ Auftrag wählen oder unten neu eingeben ]</option>
								@foreach ($projects as $project)
									<option value="{{ $project->id }}">{{ $project->name }}</option>
								@endforeach
								</select><br />
								{!! Form::text('project_name', null, ['class' => 'form-control']) !!}
							</div>
 						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="subproject_id"@if ($errors->has('subproject_id')) class="error" @endif>Teilauftrag</label>
								<select name="subproject_id" id="subproject_id" size="1" class="form-control">
									<option value="">[ Teilauftrag wählen oder unten neu eingeben ]</option>
								</select><br />
								{!! Form::text('subproject_name', null, ['class' => 'form-control']) !!}
							</div>
 						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="activity_id"@if ($errors->has('activity_id')) class="error" @endif>Tätigkeit</label>
								<select name="activity_id" id="activity_id" size="1" class="form-control">
									<option value="">[ Tätigkeit wählen ]</option>
								@foreach ($activities as $activity)
									<option value="{{ $activity->id }}">{{ $activity->name }}</option>
								@endforeach
								</select><br />
							</div>
 						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="description"@if ($errors->has('description')) class="error" @endif>Beschreibung</label>
								<textarea name="description" id="description" class="form-control"></textarea>
							</div>
 						</div>
					</div>
				</div>
				
				<div class="panel-footer">	
					<div class="row">
						<div class="col-xs-12">
							<input type="submit" class="btn btn-default" value="Speichern">
							<a href="{{ route('index') }}" class="btn btn-default">Abbrechen</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{!! Form::close() !!}
@endsection
