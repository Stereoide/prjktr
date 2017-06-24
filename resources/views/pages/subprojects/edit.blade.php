@extends('layouts.default')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Teilauftrag "{{ $subproject->project->name }} // {{ $subproject->name }}"</div>
		<div class="panel-body">
			{!! Form::model($subproject, ['method' => 'PUT', 'route' => ['projects.subprojects.update', $subproject->project->id, $subproject->id], 'role' => 'form']) !!}
			{!! Form::hidden('id', $subproject->id) !!}
			
			<div class="form-group">
				<label for="name"@if ($errors->has('name')) class="error" @endif>Name</label>
				{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
			</div>
			
			<div class="form-group">
				<label for="np_id"@if ($errors->has('np_id')) class="error" @endif>NetProject-ID</label>
				{!! Form::text('np_id', null, ['class' => 'form-control', 'placeholder' => 'NetProject-ID']) !!}
			</div>
			
			<input type="submit" class="btn btn-default" value="Speichern">
			<a href="{{ route('worklogs.index') }}" class="btn btn-default">Abbrechen</a>
			
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
