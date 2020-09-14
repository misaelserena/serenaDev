<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>ADGLOBAL MANAGEMENT</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/styles-login.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head> 
<body class="fondo">
	<div class="container-login">
		<div class="div-log">
			<div class="card-body">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif
				<form method="POST" action="{{ route('password.email') }}">
					@csrf
					<div class="div-form-group">
						<label class="label-form">Correo Electrónico</label>
						
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Ingrese su correo electrónico"><br>
							@if ($errors->has('email'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('email') }}</strong>
								</span><br>
							@endif
						<button type="submit" class="btn btn-red">
							Enviar email
						</button>
						<a href="{{ route('login') }}" class="btn" style="text-decoration: none; color: black">Regresar</a>
					</div>
				</form>
			</div>		
		</div>
	</div>
</body>
</html>