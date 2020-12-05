@extends('layouts.layout')

@section('title', 'Inicio')

@section('content')
	<div class="container-blocks-all">
		<div id="index-container">
			<div id="principal">
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">
					<!--img width="30%" src="{{ asset('images/banner.png') }}"-->
				</h1>
				<div class="btn-toolbar mb-2 mb-md-0">
				  <div class="btn-group mr-2">
					
				  </div>
				  
				</div>
			  </div>

			  <section>
				Somos un negocio dedicado a la fotografia, siempre cumpliendo con las expectivas que tienen nuestros clientes sobre nosotros, nos respalda nuestro trabajo con más de 25 años en la ciudad de Coatepec, Veracruz.
				<br><br>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				<br><br>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			  </section>
			<div id="right-nav">
				<p><br></p>
				<center>
					<div class="releases-title"><a style="text-decoration: none; color: white;" href="{{ url('releases') }}">ORDENES</a></div>
				</center>
				<br>
					
				<p><br></p>
				<center>
					<div class="news-title"><a style="text-decoration: none; color: white;" href="{{ url('news') }}">PENDIENTES</a></div>
				</center>
			</div>
		</div>
	</div>
@endsection