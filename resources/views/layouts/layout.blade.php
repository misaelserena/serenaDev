<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Serena DEV - @yield('title')</title>

	<!-- Styles -->
	
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/apexcharts.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/validator/theme-default.min.css') }}">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">


	
	<style type="text/css">
		.nav-dark
		{
			background	: #31424a;
			color		: white;
		}
		.feather 
		{
			width			: 16px;
			height			: 16px;
			vertical-align	: text-bottom;
		}

		.sidebar 
		{
			position	: fixed;
			top			: 0;
			bottom		: 0;
			left		: 0;
			z-index		: 100; /* Behind the navbar */
			padding		: 70px 0 0; /* Height of navbar */
			box-shadow	: inset -1px 0 0 rgba(0, 0, 0, .1);
		}

		@media (max-width: 767.98px) 
		{
		  	.sidebar 
		  	{
				top: 3rem;
		  	}
		}

		.sidebar-sticky 
		{
			position	: relative;
			top			: 0;
			height		: calc(100vh - 48px);
			padding-top	: .5rem;
			overflow-x	: hidden;
			overflow-y	: auto; /* Scrollable contents if viewport is shorter than content. */
		}

		@supports ((position: -webkit-sticky) or (position: sticky)) 
		{
		  	.sidebar-sticky 
		  	{
				position	: -webkit-sticky;
				position	: sticky;
		  	}
		}

		.sidebar .nav-link 
		{
			color		: #ffffff;
		}

		.sidebar .nav-link .feather 
		{
			margin-right	: 4px;
			color			: #999;
		}

		.nav-link:hover
		{
			background: white;
			color: black !important;
		}

		.sidebar .nav-link:hover .feather,
		.sidebar .nav-link.active .feather 
		{
			color	: inherit;
		}

		.sidebar-heading 
		{
			font-size		: .75rem;
			text-transform	: uppercase;
		}

		.navbar-brand 
		{
			padding-top			: .75rem;
			padding-bottom		: .75rem;
			font-size			: 1rem;
			background-color	: rgba(0, 0, 0, .25);
			box-shadow			: inset -1px 0 0 rgba(0, 0, 0, .25);
		}

		.navbar .navbar-toggler 
		{
			top		: .25rem;
			right	: 1rem;
		}

		.navbar .form-control 
		{
			padding			: .75rem 1rem;
			border-width	: 0;
			border-radius	: 0;
		}

		.form-control-dark 
		{
			color				: #000;
			background-color	: rgba(255, 255, 255, .1);
			border-color		: rgba(255, 255, 255, .1);
		}

		.form-control-dark:focus 
		{
			border-color	: transparent;
			box-shadow		: 0 0 0 3px rgba(255, 255, 255, .25);
		}

	</style>
	@yield('css')
</head>
<body>
	<nav class="navbar navbar-dark sticky-top bg-green flex-md-nowrap p-0 shadow">
	  	<a class="col-md-3 col-lg-2 mr-0 px-3" href="#" style="padding: 5px;padding-right: 5px;padding-left: 5px;text-align: center;">
	  		<img style="width: 67px;height: auto;max-width: 90%;" src="{{ asset('images/logo_cafe_plato.png') }}">
	  	</a>
	  	<a class="btn position-absolute" style="color: white; right: 70px;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
			<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#door-closed-fill") }}"/></svg> Salir
		</a>
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
		<button style="color: white;" class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</nav>
	<div class="container-fluid">
		<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block nav-dark sidebar collapse">
	  		<div class="sidebar-sticky pt-3">
				<ul class="nav flex-column">
		  			<li class="nav-item">
						<a class="nav-link @unless(isset($id)) active-nav @endunless" href="{{ url("/home") }}">
			  				<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#house-fill") }}"/></svg> Inicio
						</a>
		  			</li>
		  			@foreach(Auth::user()->module->where('father',null)->sortBy('name') as $module)
			  			<li class="nav-item">
							<a class="nav-link @if(isset($id) && $id == $module->id) active-nav @endif" href="{{ url("$module->url") }}">
				  				<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#".$module->icon) }}"></use></svg> {{ $module->name }}
							</a>
			  			</li>
			  		@endforeach
			  		<li class="nav-item">
						<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#door-closed-fill") }}"/></svg> Cerrar sesión
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
				  	</li>
				  	<li class="nav-item">
						<a class="nav-link" href="{{ url('/') }}">
							<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#arrow-left-circle-fill") }}"/></svg> Regresar a la pagina
						</a>
				  	</li>
				</ul>
	  		</div>
		</nav>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
			@yield('content')
		</main>
	</div>
	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
 	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="{{ asset('js/validator/jquery.form-validator.min.js') }}"></script>
	<script src="{{ asset('js/apexcharts.js') }}"></script>

	
	<script>
		@if(session('alert'))
			{!! session('alert') !!}
		@endif
		@if(isset($alert))
			{!! $alert !!}
		@endif
		
	</script>
	@yield('scripts')
</body>
</html>