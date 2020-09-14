<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>ADGLOBAL MANAGEMENT</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<style type="text/css">
		/* Made with love by Mutiullah Samim*/

		@import url('https://fonts.googleapis.com/css?family=Numans');

		html,body{
		/* background-image: url('http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg');*/
		background-size: cover;
		background-repeat: no-repeat;
		height: 100%;
		font-family: 'Numans', sans-serif;
		background: #303734;
		}

		.container{
		height: 100%;
		align-content: center;
		}

		.card{
		height: 370px;
		margin-top: auto;
		margin-bottom: auto;
		width: 400px;
		background-color: rgba(0,0,0,0.5) !important;
		}

		.social_icon span{
		font-size: 60px;
		margin-left: 10px;
		color: #FFF;
		}

		.social_icon span:hover{
		color: white;
		cursor: pointer;
		}

		.card-header h3{
		color: white;
		}

		.social_icon{
		position: absolute;
		right: 20px;
		top: -45px;
		}

		.input-group-prepend span{
		width: 50px;
		background-color: #4376B7;
		color: white;
		border:0 !important;
		}

		input:focus{
		outline: 0 0 0 0  !important;
		box-shadow: 0 0 0 0 !important;

		}

		.remember{
		color: white;
		}

		.remember input
		{
		width: 20px;
		height: 20px;
		margin-left: 15px;
		margin-right: 5px;
		}

		.login_btn{
		color: white;
		background-color: #4376B7;
		width: 100px;
		}

		.login_btn:hover{
		color: black;
		background-color: white;
		}

		.links{
		color: white;
		}

		.links a{
		margin-left: 4px;
		}
	</style>
</head> 
<body><br><br>
	<div class="container">
		<form method="POST" action="{{ route('login') }}" class="login-form">
			@csrf
			<div class="d-flex justify-content-center h-100">
				<div class="card">
					<div class="card-header">
						<h3>Sign In</h3>
						<div class="d-flex justify-content-end social_icon">
							<span><i class="fab fa-facebook-square"></i></span>
							<span><i class="fab fa-google-plus-square"></i></span>
						</div>
					</div>
					<div class="card-body">
						<form>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" placeholder="username" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input placeholder="Contraseña" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" required/>
							   	@if ($errors->has('password'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
							<div class="row align-items-center remember">
								<input type="checkbox" {{ old('remember') ? 'checked' : '' }}>Recordar datos
							</div>
							<div class="form-group">
								<input type="submit" value="Iniciar" class="btn float-right login_btn">
							</div>
						</form>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-center">
							<a style="color: white;" href="{{ route('password.request') }}">¿Olvidaste la contrase&ntilde;a?</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>