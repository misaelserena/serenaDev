@extends('layouts.page')
@section('styles')
	<style>
		html, body 
		{
			background-color : #fff;
			color            : #636b6f;
			font-family      : 'Raleway', sans-serif;
			font-weight      : 100;
			height           : 100vh;
			margin           : 0;
		}

		.full-height 
		{
			height : 100vh;
		}

		.flex-center 
		{
			align-items     : center;
			display         : flex;
			justify-content : center;
		}

		.position-ref 
		{
			position : relative;
		}

		.top-right 
		{
			position : absolute;
			right    : 10px;
			top      : 18px;
		}

		.content 
		{
			text-align : center;
		}

		.title 
		{
			font-size : 84px;
		}

		.links > a 
		{
			color           : #636b6f;
			padding         : 0 25px;
			font-size       : 12px;
			font-weight     : 600;
			letter-spacing  : .1rem;
			text-decoration : none;
			text-transform  : uppercase;
		}

		.m-b-md 
		{
			margin-bottom : 30px;
		}
		header.masthead 
		{
			padding-top				: 10rem;
			padding-bottom			: calc(10rem - 4.5rem);
			background				: -webkit-gradient(linear, left top, left bottom, from(rgba(92, 77, 66, 0.8)), to(rgba(92, 77, 66, 0.8))), url(/images/wallpaper_index.jpg?d4c0f161b973fd57fecaed365a4b51dd);
			background				: linear-gradient(to bottom, rgba(92, 77, 66, 0.8) 0%, rgba(92, 77, 66, 0.8) 100%), url({{ asset('images/wallpaper_index.jpg?d4c0f161b973fd57fecaed365a4b51dd') }});
			background-position		: center;
			background-repeat		: no-repeat;
			background-attachment	: scroll;
			background-size			: cover;
		}
	</style>
@endsection
@section('content')
		<!-- Masthead-->
		<header class="masthead">
			<div class="container h-100">
				<div class="row h-100 align-items-center justify-content-center text-center">
					<div class="col-lg-10 align-self-end">
						<h1 class="text-uppercase text-white font-weight-bold">FOTO SERENA</h1>
						<hr class="divider my-4" />
					</div>
					<div class="col-lg-8 align-self-baseline">
						<p class="text-white-75 font-weight-light mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex.</p>
						<a class="btn btn-orange btn-xl js-scroll-trigger" href="#about">
							PRÓXIMAMENTE
						</a>
					</div>
				</div>
			</div>
		</header>
		<!-- Services-->
		<section class="page-section" id="services">
			<div class="container">
				<h2 class="text-center mt-0">NUESTROS SERVICIOS</h2>
				<hr class="divider my-4" />
				<div class="row">
					<div class="col-lg-3 col-md-6 text-center">
						<div class="mt-5">
							<i class="fas fa-4x fa-gem text-primary mb-4"></i>
							<h3 class="h4 mb-2">Fotografía para trámites</h3>
							<p class="text-muted mb-0">Manejamos diferentes tamaños de fotografía, dependiente del trámite que vayas a realizar</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center">
						<div class="mt-5">
							<i class="fas fa-4x fa-laptop-code text-primary mb-4"></i>
							<h3 class="h4 mb-2">Videos</h3>
							<p class="text-muted mb-0">Grabamos tus eventos para tenerlos de recuerdo.</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center">
						<div class="mt-5">
							<i class="fas fa-4x fa-globe text-primary mb-4"></i>
							<h3 class="h4 mb-2">Transferencia</h3>
							<p class="text-muted mb-0">Transferimos tus videos VHS a DVD</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center">
						<div class="mt-5">
							<i class="fas fa-4x fa-heart text-primary mb-4"></i>
							<h3 class="h4 mb-2">Sesiones Fotográficas</h3>
							<p class="text-muted mb-0">Te hacemos tu sesión de fotos a tu gusto.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Portfolio-->
		<div id="portfolio">
			<div class="container-fluid p-0">
				<div class="row no-gutters">
					<div class="col-lg-4 col-sm-6">
						<a class="portfolio-box" href="{{ asset('img/portfolio/fullsize/1.jpg') }}">
							<img class="img-fluid" src="{{ asset('img/portfolio/thumbnails/1.jpg') }}" alt="" />
							<div class="portfolio-box-caption">
								<div class="project-category text-white-50">Category</div>
								<div class="project-name">Project Name</div>
							</div>
						</a>
					</div>
					<div class="col-lg-4 col-sm-6">
						<a class="portfolio-box" href="{{ asset('img/portfolio/fullsize/2.jpg') }}">
							<img class="img-fluid" src="{{ asset('img/portfolio/thumbnails/2.jpg') }}" alt="" />
							<div class="portfolio-box-caption">
								<div class="project-category text-white-50">Category</div>
								<div class="project-name">Project Name</div>
							</div>
						</a>
					</div>
					<div class="col-lg-4 col-sm-6">
						<a class="portfolio-box" href="{{ asset('img/portfolio/fullsize/3.jpg') }}">
							<img class="img-fluid" src="{{ asset('img/portfolio/thumbnails/3.jpg') }}" alt="" />
							<div class="portfolio-box-caption">
								<div class="project-category text-white-50">Category</div>
								<div class="project-name">Project Name</div>
							</div>
						</a>
					</div>
					<div class="col-lg-4 col-sm-6">
						<a class="portfolio-box" href="{{ asset('img/portfolio/fullsize/4.jpg') }}">
							<img class="img-fluid" src="{{ asset('img/portfolio/thumbnails/4.jpg') }}" alt="" />
							<div class="portfolio-box-caption">
								<div class="project-category text-white-50">Category</div>
								<div class="project-name">Project Name</div>
							</div>
						</a>
					</div>
					<div class="col-lg-4 col-sm-6">
						<a class="portfolio-box" href="{{ asset('img/portfolio/fullsize/5.jpg') }}">
							<img class="img-fluid" src="{{ asset('img/portfolio/thumbnails/5.jpg') }}" alt="" />
							<div class="portfolio-box-caption">
								<div class="project-category text-white-50">Category</div>
								<div class="project-name">Project Name</div>
							</div>
						</a>
					</div>
					<div class="col-lg-4 col-sm-6">
						<a class="portfolio-box" href="{{ asset('img/portfolio/fullsize/6.jpg') }}">
							<img class="img-fluid" src="{{ asset('img/portfolio/thumbnails/6.jpg') }}" alt="" />
							<div class="portfolio-box-caption p-3">
								<div class="project-category text-white-50">Category</div>
								<div class="project-name">Project Name</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- About-->
		<section class="page-section container-orange" id="about">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8 text-center">
						<h2 class="text-white mt-0">CONOCENOS!</h2>
						<hr class="divider light my-4" />
						<p class="text-white-50 mb-4">
							Somos un negocio dedicado a la fotografia, siempre cumpliendo con las expectivas que tienen nuestros clientes sobre nosotros, nos respalda nuestro trabajo con más de 25 años en la ciudad de Coatepec, Veracruz.
						</p>
					</div>
				</div>
			</div>
		</section>
		<!-- Contact-->
		<section class="page-section" id="contact">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8 text-center">
						<h2 class="mt-0">CONTACTO</h2>
						<hr class="divider my-4" />
						<p class="text-muted mb-5">
							<form class="text-left">
								<div class="form-group">
									<label for="name">Nombre</label>
									<input type="text" class="form-control" id="name" placeholder="Ej. Esperanza Serena..">
								</div>
								<div class="form-group">
									<label for="mail">Correo Electrónico</label>
									<input type="email" class="form-control" id="mail" placeholder="ejemplo@ejemplo.com">
								</div>
								<div class="form-group">
									<label for="content">Correo Electrónico</label>
									<textarea id="content" class="form-control"></textarea>
								</div>
								<center>
									<input type="submit" name="send" class="btn btn-primary" value="Contactar">
								</center>
							</form>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
						<i class="fas fa-phone fa-3x mb-3 text-muted"></i>
						<div>Tel: (228)8 16 50 94</div>
					</div>
					<div class="col-lg-4 mr-auto text-center">
						<i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
						<!-- Make sure to change the email address in BOTH the anchor text and the link target below!-->
						<a class="d-block" href="misael_serena@hotmail.com">misael_serena@hotmail.com</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Footer-->
		<footer class="bg-light py-5">
			<div class="container"><div class="small text-center text-muted">Copyright © 2020 - Serena Dev</div></div>
		</footer>
@endsection