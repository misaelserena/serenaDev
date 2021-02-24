<!DOCTYPE html>
<html>
<head>
	
	<style type="text/css">
		@page {
			margin	: 9em 0 0 0 !important;
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
			top			: -9.3em;
		}
		.header
		{
			border-collapse	: separate;
			border-spacing	: 25px;
			margin			: auto;
			padding			: 0;
		}
		.header .logo
		{
			margin			: 0 auto;
			margin-bottom	: 5px;
			padding			: 5px;
			text-align		: left;
			vertical-align	: middle;
			width			: 100px;
		}
		.header .logo img
		{
			width: 100%;
		}
		.header .date
		{
			margin			: 0 auto;
			margin-bottom	: 5px;
			padding			: 5px;
			text-align		: right;
			width			: 450px;
		}
		.request-info
		{
			border			: 1px solid #c6c6c6;
			border-collapse	: separate;
			margin			: 0 auto;
			width			: 90%;
		}
		.request-info tbody th
		{
			border-bottom	: 1px dotted #c6c6c6;
			font-weight		: 600;
			padding			: 0.5em 0.3em;
		}
		.request-info tbody tr.no-border th
		{
			border: none;
		}
		.pdf-table-center-header
		{
			background		: #ff9f00;
			background		: -moz-linear-gradient(left, #ff9f00 0%, #ffb700 40%, #ffb700 60%, #ff9f00 100%);
			background		: -webkit-linear-gradient(left, #ff9f00 0%,#ffb700 40%,#ffb700 60%,#ff9f00 100%);
			background		: linear-gradient(to right, #ff9f00 0%,#ffb700 40%,#ffb700 60%,#ff9f00 100%);
			color			: #fff;
			filter			: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff9f00', endColorstr='#ff9f00',GradientType=1 );
			font-size		: 1em;
			font-weight		: 700;
			padding			: 0.5em 0;
			text-align		: center;
			text-transform	: uppercase;
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
			background-color	: #17847f;
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
		.bank-info
		{
			margin-top: .5em;
		}
		.bank-info th
		{
			font-weight: 600;
		}
		.bank-info th,
		.bank-info td
		{
			text-align: center;
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
		.pdf-notes
		{
			border		: 1px dotted #c6c6c6;
			margin		: 15px 5px 5px;
			padding		: 3px 5px;
			text-align	: left;
		}
	</style>
</head>
<body>
	<header>
		<table class="header">
			<tbody>
				<tr>
					<td class="logo"><img width="30%" src="{{ asset('images/logo-serena.png') }}"></td>
					<td class="date"><label class="pdf-label">Folio: {{ $sale->id }} </label> <br><label class="pdf-label">Fecha: {{ $sale->created_at }}</label></td>
				</tr>
			</tbody>
		</table>
	</header>
	<main>
		<div class="pdf-full">
			<div class="pdf-body">
				<p><br></p>
				<div class="block-info">
					<center>
						<strong>DATOS DEL CLIENTE</strong>
					</center>
					<table class="pdf-divisor">
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<table class="employee-details centered-table">
						<tbody>
							<tr>
								<td><b>Nombre:</b></td>
								<td><label>{{ $sale->clientData->fullName() }}</label></td>
							</tr>
							<tr>
								<td><b>RFC:</b></td>
								<td><label>{{ $sale->clientData->rfc }}</label></td>
							</tr>
							<tr>
								<td><b>Teléfono:</b></td>
								<td><label>{{ $sale->clientData->phone }}</label></td>
							</tr>
							<tr>
								<td><b>Calle:</b></td>
								<td><label>{{ $sale->clientData->address }}</label></td>
							</tr>
							<tr>
								<td><b>Número:</b></td>
								<td><label>{{ $sale->clientData->number }}</label></td>
							</tr>
							<tr>
								<td><b>Colonia:</b></td>
								<td><label>{{ $sale->clientData->colony }}</label></td>
							</tr>
							<tr>
								<td><b>CP:</b></td>
								<td><label>{{ $sale->clientData->postalCode }}</label></td>
							</tr>
							<tr>
								<td><b>Ciudad:</b></td>
								<td><label>{{ $sale->clientData->city }}</label></td>
							</tr>
							<tr>
								<td><b>Estado:</b></td>
								<td><label>{{ $sale->clientData->states->description }}</label></td>
							</tr>
						</tbody>
					</table>
				</div>
				<p><br></p>
				<div class="block-info">
					<center>
						<strong>DATOS DEL PEDIDO</strong>
					</center>
					<table class="pdf-divisor">
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<table class="centered-table bank-info">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Precio</th>
								<th>Subtotal</th>
								<th>IVA</th>
								<th>Descuento</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach($sale->detail as $detail)
								<tr>
									<td>
										{{ $detail->productData->nameProduct() }}
									</td>
									<td>
										{{ $detail->quantity }}
									</td>
									<td>
										${{ number_format($detail->price,2) }}
									</td>
									<td>
										${{ number_format($detail->subtotal,2) }}
									</td>
									<td>
										${{ number_format($detail->iva,2) }}
									</td>
									<td>
										${{ number_format($detail->discount,2) }}
									</td>
									<td>
										${{ number_format($detail->total,2) }}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<p>&nbsp;</p>
					<table class="centered-table bank-info total-details">
						<tbody>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>Subtotal:</td>
								<td>$ {{ number_format($sale->subtotal,2) }}</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>IVA:</td>
								<td>$ {{ number_format($sale->iva,2) }}</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>Descuento:</td>
								<td>$ {{ number_format($sale->discount,2) }}</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>TOTAL:</td>
								<td>$ {{ number_format($sale->total,2) }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</main>
</body>
</html>