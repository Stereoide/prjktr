<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Prjktr</title>

	<!-- Fonts -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

	<!-- Styles -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{ asset('app.css') }}" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>
		var _$ = jQuery;
		// jQuery.noConflict();
	</script>
	
	<style>
		body {
			font-family: 'Lato';
			padding: 20px;
		}

		.fa-btn {
			margin-right: 6px;
		}
		
		.data-label {
			font-weight: bold;
		}
		
		.data-content {
			font-weight: normal;
		}
		
		LABEL.error {
			color: #a94442;
		}
	</style>
</head>
<body id="app-layout">
	@if (Session::has('message'))
	<div class="container">
		<div class="alert alert-success">
			{{ Session::get('message') }}
		</div>
	</div>	
	@endif

	@if (Session::has('warning'))
	<div class="container">
		<div class="alert alert-warning">
			{{ Session::get('warning') }}
		</div>
	</div>	
	@endif
	
	@yield('content')

	<!-- JavaScripts -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/de.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
</body>
</html>
