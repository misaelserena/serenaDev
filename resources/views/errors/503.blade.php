<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Ad Global Management - Error</title>

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css') }}">
	<style type="text/css">
		@font-face
		{
			font-family: 'AvalonPlain';
			src: url( {{ asset('fonts/AvalonPlain.eot?#iefix') }}) format('embedded-opentype'), 
				url( {{ asset('fonts/AvalonPlain.woff') }} ) format('woff'),
				url( {{ asset('fonts/AvalonPlain.ttf') }} )  format('truetype'),
				url( {{ asset('fonts/AvalonPlain.svg#AvalonPlain') }} ) format('svg');
			font-weight: normal;
			font-style: normal;
		}
		body
		{
			background-color: #efefef;
		}
		.container
		{
			margin		: 0 auto;
			max-width	: 600px;
			text-align	: center;
			width		: 90%;
		}
		.logo
		{
			min-width		: 10em;
			padding-bottom	: 5%;
			padding-top		: 5px;
			width			: 60%;
		}
		.animation
		{
			height		: 100%;
			margin		: 0 auto;
			padding-top	: 14%;
			position	: relative;
			width		: 90%;
		}
		.animation .background
		{
			width: 100%;
		}
		.big-one
		{
			height	: 0.7em;
			width	: 0.7em;
		}
		.medium-one
		{
			height					: 0.5em;
			width					: 0.5em;
			-webkit-animation-delay	: 2s;
			animation-delay			: 2s;
		}
		.small-one
		{
			height					: 0.3em;
			width					: 0.3em;
			-webkit-animation-delay	: 1s;
			animation-delay			: 1s;
		}
		.sphere
		{
			-webkit-animation-duration			: 3s;
			-webkit-animation-fill-mode			: both;
			-webkit-animation-iteration-count	: infinite;
			-webkit-animation-name				: spheres;
			animation-duration					: 3s;
			animation-fill-mode					: both;
			animation-iteration-count			: infinite;
			animation-name						: spheres;
			background							: #ffdba9;
			border-radius						: 50%;
			position							: absolute;
		}
		.animate
		{
			-webkit-animation-duration			: 5s;
			-webkit-animation-fill-mode			: both;
			-webkit-animation-iteration-count	: infinite;
			-webkit-animation-name				: tada;
			animation-duration					: 5s;
			animation-fill-mode					: both;
			animation-iteration-count			: infinite;
			animation-name						: tada;
			left								: 30%;
			position							: absolute;
			top									: 0;
			width								: 48%;
		}
		.title-error
		{
			display		: inline-block;
			font-family	: 'AvalonPlain';
			font-size	: 340%;
			padding		: 0.3em 0 0;
		}
		.text-error
		{
			display		: inline-block;
			font-family	: 'AvalonPlain';
			font-size	: 180%;
			font-weight	: lighter;
		}
		.red-button
		{
			background		: #f04420;
			border-radius	: 5px;
			color			: #fff;
			display			: inline-block;
			font-family		: 'AvalonPlain';
			font-size		: 110%;
			font-weight		: bold;
			padding			: 9px 20px;
		}
		@-webkit-keyframes spheres
		{
			from
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}
			50%
			{
				-webkit-transform	: scale3d(0.8, 0.8, 0.8);
				transform			: scale3d(0.8, 0.8, 0.8);
			}
			to
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}
		}
		@-webkit-keyframes tada
		{
			from
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}

			3%,
			5%
			{
				-webkit-transform	: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
				transform			: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
			}

			7%,
			12%,
			18%,
			23%
			{
				-webkit-transform	: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
				transform			: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
			}

			10%,
			15%,
			20%
			{
				-webkit-transform	: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
				transform			: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
			}

			25%
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}

			to
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}
		}
		@keyframes spheres
		{
			from
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}
			50%
			{
				-webkit-transform	: scale3d(0.8, 0.8, 0.8);
				transform			: scale3d(0.8, 0.8, 0.8);
			}
			to
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}
		}
		@keyframes tada
		{
			from
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}

			3%,
			5%
			{
				-webkit-transform	: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
				transform			: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
			}

			7%,
			12%,
			18%,
			23%
			{
				-webkit-transform	: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
				transform			: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
			}

			10%,
			15%,
			20%
			{
				-webkit-transform	: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
				transform			: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
			}

			25%
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}

			to
			{
				-webkit-transform	: scale3d(1, 1, 1);
				transform			: scale3d(1, 1, 1);
			}
		}
		@media screen and (max-width: 900px)
		{
			.title-error
			{
				font-size: 200%;
			}
			.text-error
			{
				font-size: 120%;
			}
			.red-button
			{
				font-size: 80%;
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<img src="{{ asset('images/error/logo-ad-global-error.png') }}" class="logo">
		<div class="animation">
			<img src="{{ asset('images/error/error-1.png') }}" class="background">
			<img src="{{ asset('images/error/error-2.png') }}" class="animate">
			<div style=" position: absolute;top: 16%;left: 24%;">
				<div class="sphere big-one" style=" top: -13px;"></div>
				<div class="sphere medium-one" style=" left: -21px;"></div>
				<div class="sphere small-one" style=" top: 13px;"></div>
			</div>
			<div style=" position: absolute;left: 0;top: 58%;">
				<div class="sphere big-one"></div>
			</div>
			<div style=" position: absolute;top: 65%;left: 12%;">
				<div class="sphere medium-one" style=" top: 5px;left: 10px;"></div>
				<div class="sphere small-one" style=" top: -2px;left: -4px;"></div>
			</div>
			<div style=" position: absolute;right: 13%;top: 33%;">
				<div class="sphere big-one"></div>
			</div>
			<div style=" position: absolute;right: 4%;top: 43%;">
				<div class="sphere medium-one" style=" top: 7px;left: -12px;"></div>
				<div class="sphere small-one"></div>
			</div>
			<div style=" position: absolute;right: 17%;bottom: 18%;">
				<div class="sphere medium-one" style=" top: 1px;left: 7px;"></div>
				<div class="sphere small-one" style=" top: -6px;left: -8px;"></div>
			</div>
		</div>
		<span class="text-error">Una disculpa, la página se encuentra en mantenimiento.</span>
		<br><br><br>
		<span class="red-button">El equipo de ADGLOBAL</span>
	</div>
	
</body>
</html>