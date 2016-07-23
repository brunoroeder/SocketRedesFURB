<!doctype html>
<html>
<head>
	<title>LARC - FURB</title>


	<link href="https://fonts.googleapis.com/css?family=Catamaran:100" rel="stylesheet" type="text/css">

	<style>
		html, body {
			height: 100%;
		}

		body {
			margin: 0;
			padding: 0;
			width: 100%;
			display: table;
			font-weight: 100;
			font-family: 'Catamaran';
			color: #000;
			background-color: #c0c0c0;
		}

		.container {
			text-align: center;
			display: table-cell;
			vertical-align: middle;
		}

		.content {
			text-align: center;
			display: inline-block;
		}

		.title {
			font-size: 96px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="content">
			{{ Form::open(array('url' => 'login')) }}
			<h1>Login</h1>

			<!-- if there are login errors, show them here -->
			<p>
				{{ $errors->first('userId') }}
				{{ $errors->first('password') }}
			</p>

			<p>
				{{ Form::label('userId', 'Id Usuário') }}
				{{ Form::text('userId', Input::old('userId')) }}
			</p>

			<p>
				{{ Form::label('password', 'Senha') }}
				{{ Form::password('password') }}
			</p>

			<p>{{ Form::submit('Submit!') }}</p>
			{{ Form::close() }}

		</div>
	</div>