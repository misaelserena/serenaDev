<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	<style type="text/css">
		body *,
		tbody th,
		tbody td,
		{
			font-family: 'Baskerville' !important;
			font-size	: 10px;
		}
		@page {
			margin	: 4em 0 0 0 !important;
        }
		body
		{
			background	: white;
			font-size	: 12px;
			position	: relative !important;
		}
		header
		{
			left		: 0px;
			position	: fixed;
			right		: 0px;
			text-align	: center;
			top			: -5em;
		}
		.header
		{
			border-collapse	: separate;
			margin			: auto;
			margin-left		: 1rem;
			padding			: 0;
		}
		.header .logo
		{
			margin			: 0 auto;
			margin-bottom	: .1rem;
			padding			: .1rem;
			text-align		: left;
			vertical-align	: middle;
			width			: 4rem;
		}
		.header .logo img
		{
			width: 100%;
		}
		.request-info
		{
			border			: 1px solid #c6c6c6;
			border-collapse	: separate;
			margin			: 0 auto;
			width			: 90%;
		}
		.request-info.no-border
		{
			border	: 0;
		}
		.request-info tbody th
		{
			border-bottom	: 1px dotted #c6c6c6;
			font-family		: 'Baskerville' !important;
			font-weight		: 600;
			padding			: 0.5rem;
		}

		.request-info tbody th div.normal
		{
			font-weight	: 300;
		}
		.thead-dark tr th,
		.thead-dark tr td
		{
			font-family	: 'Baskerville' !important;
		}
		.request-info tbody th div.text-left
		{
			float		: left;
			font-family	: 'Baskerville' !important;
			font-weight	: bolder;
		}
		.request-info tbody tr.no-border th
		{
			border: none;
		}
		.pdf-divisor
		{
			margin	: 0 auto;
			width	: 95%;
		}
		.pdf-divisor tr td
		{
			padding			: 0;
		}
		.pdf-divisor tr td:nth-child(2)
		{
			width	: 20%;
		}
		.pdf-divisor tr td::after
		{
			background-color	: #c6c6c6;
			content				: '';
			display				: inline-block;
			height				: 1px;
			margin				: 1px 0;
			vertical-align		: middle;
			width				: 100%;
		}
		.pdf-divisor tr td:nth-child(2)::after
		{
			background-color	: #fca700;
			content				: '';
			display				: inline-block;
			height				: 3px;
			width				: 100%;
		}
		.centered-table
		{
			margin	: auto;
			width	: 90%;
		}
		.block-info
		{
			page-break-inside	: avoid;
		}
		.total-details tr td
		{
			text-align	: right;
		}
		.total-details tr td:nth-child(2)
		{
			text-align	: left;
		}
		.total-details tr td:first-child
		{
			width	: 40%;
		}
		.table
		{
			border-collapse	: collapse !important;
			margin			: 0;
		}

		.table td,
		.table th,
		.table-permission td,
		.table-permission th
		{
			padding	: .3rem !important;
		}
		.table thead th
		{
			border-bottom	: 0 !important;
			background		: none !important;
			color			: white !important;
			vertical-align	: middle;
		}
		.pdf-full
		{
			width	: 780px;
		}
		.text-break
		{
			font-size	: 8px;
			max-width	: 650px;
			width		: 650px;
			word-break	: break-all !important;
			word-wrap	: break-word !important;
		}
		.text-break2
		{
			font-size	: 8px;
			max-width	: 540px;
			width		: 540px;
			word-break	: break-all !important;
			word-wrap	: break-word !important;
		}
	</style>
</head>
<body>
	<header>
		<div style="width: 650px;margin: auto;position: relative;">
			<table class="header">
				<tbody>
					<tr>
						<td class="logo"><img src="{{ asset('/images/enterprise/'.\App\Enterprise::where('rfc',$bill->rfc)->first()->path) }}"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</header>
	<main>
		<div class="pdf-full">
			<div class="pdf-body">
				<div class="block-info">
					<p><b>ACUSE DE CANCELACIÓN</b></p>
					<p><br></p>
					<table class="request-info no-border centered-table">
						<tbody>
							<tr>
								<th width="50%" class="text-left">Fecha y hora de solicitud</th>
								<th width="50%" class="text-right normal">{{$bill->cancelRequestDate}}</th>
							</tr>
							<tr>
								<th width="50%" class="text-left">Fecha y hora de cancelación</th>
								<th width="50%" class="text-right normal">{{$bill->CancelledDate}}</th>
							</tr>
							<tr>
								<th width="50%" class="text-left">RFC emisor</th>
								<th width="50%" class="text-right normal">{{$bill->rfc}}</th>
							</tr>
						</tbody>
					</table>
				</div>
				<p><br></p>
				<div class="block-info">
					<table class="centered-table">
						<thead>
							<tr>
								<th>Folio fiscal</th>
								<th>Estado CFDI</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{$bill->uuid}}</td>
								<td>{{$bill->statusCFDI}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<p><br></p>
				<p><br></p>
				<div class="block-info">
					<table class="table" style="margin: auto;width: 600px;max-width: 600px;">
						<thead class="thead-dark">
							<tr>
								<th colspan="4">Sello digital SAT</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="left" colspan="4">
									<div class="text-break">{{$bill->signatureValueCancel}}</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</main>
</body>
</html>