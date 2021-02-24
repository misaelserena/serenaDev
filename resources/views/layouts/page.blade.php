<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SERENA DEV</title>
		<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	@yield('styles')
</head>
<body id="page-top">
	<div id="app">
		 <!-- Navigation-->
		<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
			<div class="container">
				<a class="navbar-brand js-scroll-trigger" href="#page-top">
					<img style="width: 40px; height: auto;max-width: 90%;" src="{{ asset('images/logo_cafe_bn_circle.png') }}"> SERENA DEV
				</a>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto my-2 my-lg-0">
						@auth
							<li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('/') }}">Inicio</a></li>
							<!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="#services">Servicios</a></li-->
							<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#portfolio">Portafolio</a></li>
							<!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">Acerca de</a></li-->
							<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contacto</a></li>
							<li class="nav-item dropdown">
								<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									{{ Auth::user()->name }} <span class="caret"></span>
								</a>

								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('home') }}">
										Panel de Usuario
									</a>
									<a class="dropdown-item" href="{{ route('logout') }}"
									   onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
										Cerrar sesión
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</div>
							</li>
						@else
							<!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="#services">Servicios</a></li-->
							<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#portfolio">Portafolio</a></li>
							<!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">Acerca de</a></li-->
							<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contacto</a></li>
							<li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('login') }}">Login</a></li>
							<!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('register') }}">Registro</a></li-->
						@endif
					</ul>
				</div>
			</div>
		</nav>

		@yield('content')
	</div>
</body>
</html>
