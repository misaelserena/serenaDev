<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css') }}">
	<style type="text/css">
		body *,
		tbody th,
		tbody td,
		{
			font-family: 'Baskerville' !important;
			font-size	: 10px;
		}
		.table
		{
			border-collapse: collapse !important;
		}
		.table-bordered th,
		.table-bordered td
		{
			border: 1px solid #ddd !important;
		}
		table
		{
			background-color: transparent;
			max-width: 100%;
		}
		.table {
			width			: 100%;
			max-width		: 100%;
			margin-bottom	: 20px;
		}
		.table > thead > tr > th,
		.table > tbody > tr > th,
		.table > tfoot > tr > th,
		.table > thead > tr > td,
		.table > tbody > tr > td,
		.table > tfoot > tr > td {
			padding			: 8px;
			line-height		: 1.42857143;
			vertical-align	: middle;
			border-top		: 1px solid #ddd;
		}
		.table > thead > tr > th {
			vertical-align	: middle;
			border-bottom	: 2px solid #ddd;
		}
		.table > caption + thead > tr:first-child > th,
		.table > colgroup + thead > tr:first-child > th,
		.table > thead:first-child > tr:first-child > th,
		.table > caption + thead > tr:first-child > td,
		.table > colgroup + thead > tr:first-child > td,
		.table > thead:first-child > tr:first-child > td {
			border-top	: 0;
		}
		.table > tbody + tbody {
			border-top	: 2px solid #ddd;
		}
		.table > caption + thead > tr:first-child > th,
		.table > colgroup + thead > tr:first-child > th,
		.table > thead:first-child > tr:first-child > th,
		.table > caption + thead > tr:first-child > td,
		.table > colgroup + thead > tr:first-child > td,
		.table > thead:first-child > tr:first-child > td {
			border-top	: 0;
		}
		.table > tbody + tbody {
			border-top	: 2px solid #ddd;
		}
		.table .table {
			background-color	: #fff;
		}
		.table-condensed > thead > tr > th,
		.table-condensed > tbody > tr > th,
		.table-condensed > tfoot > tr > th,
		.table-condensed > thead > tr > td,
		.table-condensed > tbody > tr > td,
		.table-condensed > tfoot > tr > td {
			padding	: 5px;
		}
		.table-bordered {
			border	: 1px solid #ddd;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > tbody > tr > th,
		.table-bordered > tfoot > tr > th,
		.table-bordered > thead > tr > td,
		.table-bordered > tbody > tr > td,
		.table-bordered > tfoot > tr > td {
			border	: 1px solid #ddd;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > thead > tr > td {
			border-bottom-width	: 2px;
		}
		.table-striped > tbody > tr:nth-of-type(odd) {
			background-color	: #f9f9f9;
		}
		table col[class*="col-"] {
			position	: static;
			display		: table-column;
			float		: none;
		}
		table td[class*="col-"],
		table th[class*="col-"] {
			position	: static;
			display		: table-cell;
			float		: none;
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
		.logo
		{
			margin-bottom	: .1rem;
			position		: absolute;
			right			: 0;
			top				: 1.5rem;
			width			: 150px;
		}
		.request-info
		{
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
			font-family		: 'Baskerville' !important;
			font-weight		: 600;
			padding			: 0.1rem;
		}

		.request-info tbody th span.normal
		{
			font-weight	: 300;
		}
		.thead-dark tr th,
		.thead-dark tr td
		{
			font-family	: 'Baskerville' !important;
		}
		.request-info tbody th span.text-left
		{
			font-family	: 'Baskerville' !important;
			font-weight	: bolder;
		}
		.request-info tbody tr.no-border th
		{
			border: none;
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
			padding	: .1rem !important;
		}
		thead tr th,
		.proyecta-payment tr th
		{
			border-bottom	: 0 !important;
			background		: #41255b !important;
			color			: white !important;
			vertical-align	: middle;
		}
		.mainware-taxes thead tr th
		{
			background	: none !important;
			color		: black !important;
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
		.table
		{
			text-align: center;
			vertical-align: middle;
		}
		.table td.mainware-taxes-box
		{
			padding	: 0 !important;
		}
		hr
		{
			background	: #000;
			border		: 0;
			height		: 1px;
			width		: 100%;
		}
		.table-borderless td,
		.table-borderless th
		{
			border: 0!important;
		}
		.ita-table-bordered td,
		.ita-table-bordered th
		{
			border-bottom: 1px dotted #000;
		}
		.siner-border
		{
			border-top		: 2px solid #41255b !important;
			border-bottom	: 2px solid #41255b !important;
			position		: relative;
			margin			: 0 auto;
			width			: 90%;
		}
	</style>
</head>
<body>
	<main>
		<div class="pdf-full">
			<div class="pdf-body">
				<div class="block-info siner-border">
					@php
						$path	= public_path('/images/enterprise/'.\App\Enterprise::where('rfc',$bill->rfc)->first()->path);
						$type	= pathinfo($path, PATHINFO_EXTENSION);
						$data	= file_get_contents($path);
						$base64	= 'data:image/' . $type . ';base64,' . base64_encode($data);
					@endphp
					<img src="{{ $base64 }}" class="logo">
					<table width="70%">
						<tbody>
							<tr>
								<th>RFC emisor:</th>
								<td>{{$bill->rfc}}</td>
							</tr>
							<tr>
								<th>Nombre emisor:</th>
								<td>{{$bill->businessName}}</td>
							</tr>
							<tr>
								<th>RFC receptor:</th>
								<td>{{$bill->clientRfc}}</td>
							</tr>
							<tr>
								<th>Nombre receptor:</th>
								<td>{{$bill->clientBusinessName}}</td>
							</tr>
							@if($bill->related != null)
								<tr>
									<th>
										<span class="text-left">Tipo de relación: </span>
									</th>
									<td>
										<span class="normal">{{App\CatRelation::where('typeRelation',$bill->related)->first()->description}}</span>
									</td>
								</tr>
							@endif
							<tr>
								<th>
									<span class="text-left">Uso CFDI: </span>
								</th>
								<td>
									<span class="normal">{{$bill->cfdiUse->description}}</span>
								</td>
							</tr>
							<tr>
								<th>
									<span class="text-left">Efecto de comprobante: </span>
								</th>
								<td>
									<span class="normal">{{$bill->cfdiType->description}}</span>
								</td>
							</tr>
							@if($bill->related != null)
								<tr>
									<th>
										<span class="text-left">Folio fiscal a relacionar: </span>
									</th>
									<td>
										<span class="normal">
											@foreach($bill->cfdiRelated as $rel)
												{{$rel->uuid}}<br>
											@endforeach
										</span>
									</td>
								</tr>
							@endif
							@if($bill->uuid != '')
								<tr>
									<th>
										<span class="text-left">Folio fiscal: </span>
									</th>
									<td>
										<span class="normal">{{$bill->uuid}}</span>
									</td>
								</tr>
							@endif
							@if($bill->noCertificate != '')
								<tr>
									<th>
										<span class="text-left">No. de serie del CSD: </span>
									</th>
									<td>
										<span class="normal">{{$bill->noCertificate}}</span>
									</td>
								</tr>
							@endif
							@if($bill->satCertificateNo != '')
								<tr>
									<th>
										<span class="text-left">No. de serie del SAT: </span>
									</th>
									<td>
										<span class="normal">{{$bill->satCertificateNo}}</span>
									</td>
								</tr>
							@endif
							<tr>
								<th>
									<span class="text-left">Código postal, fecha y hora de emisión: </span>
								</th>
								<td>
									<span class="normal">{{$bill->postalCode}}, {{$bill->expeditionDateCFDI}}</span>
								</td>
							</tr>
							@if($bill->stampDate != '')
								<tr>
									<th>
										<span class="text-left">Fecha y hora de certificación: </span>
									</th>
									<td>
										<span class="normal">{{$bill->stampDate}}</span>
									</td>
								</tr>
							@endif
						</tbody>
					</table>
					@if($bill->type == 'N')
						<table style="border-collapse: separate;border-spacing: 0.1rem;width: 100%;margin: auto">
							<tbody>
								<tr>
									<td colspan="6" align="center"><b style="font-weight: 600">Datos complementarios del receptor</b></td>
								</tr>
								<tr>
									<td>CURP:</td>
									<td>{{$bill->nominaReceiver->curp}}</td>
									<td>Salario diario integrado</td>
									<td>{{$bill->nominaReceiver->sdi}}</td>
								</tr>
								<tr>
									<td>Tipo contrato:</td>
									<td colspan="3">{{$bill->nominaReceiver->nominaContract->description}}</td>
								</tr>
								<tr>
									<td>NSS</td>
									<td>{{$bill->nominaReceiver->nss}}</td>
									<td>Fecha de inicio de relación laboral</td>
									<td>{{$bill->nominaReceiver->laboralDateStart}}</td>
								</tr>
								<tr>
									<td>Antigüedad</td>
									<td>{{$bill->nominaReceiver->antiquity}}</td>
									<td>Riesgo de puesto</td>
									<td>{{$bill->nominaReceiver->nominaPositionRisk->description}}</td>
								</tr>
								<tr>
									<td>Tipo régimen</td>
									<td>{{$bill->nominaReceiver->nominaRegime->description}}</td>
									<td>Número de empleado</td>
									<td>{{$bill->nominaReceiver->employee_id}}</td>
								</tr>
								<tr>
									<td>Periodicidad del pago</td>
									<td>{{$bill->nominaReceiver->nominaPeriodicity->description}}</td>
									<td>Clave entidad federativa</td>
									<td>{{$bill->nominaReceiver->c_state}}</td>
								</tr>
							</tbody>
						</table>
					@endif
				</div>
				<p><br></p>
				@if($bill->type != 'N')
				<div class="block-info">
					<table class="request-info centered-table no-border">
						<tbody>
							@foreach($bill->billDetail as $d)
								<tr>
									<td>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Clave del producto/servicio</th>
													<th>Cantidad</th>
													<th>Clave de unidad</th>
													<th>Valor unitario</th>
													<th>Importe</th>
													<th>Descuento</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>{{$d->keyProdServ}}</td>
													<td>{{$d->quantity}}</td>
													<td>{{$d->keyUnit}}</td>
													<td>{{$d->value}}</td>
													<td>{{$d->amount}}</td>
													<td>{{$d->discount}}</td>
												</tr>
												<tr>
													<td colspan="3" class="align-middle">{{$d->description}}</td>
													<td colspan="3" class="mainware-taxes-box">
														@if($d->taxesTras->count()>0)
															<table class="table table-bordered mainware-taxes">
																<thead>
																	<tr>
																		<th colspan="4">Traslados</th>
																	</tr>
																</thead>
																<tbody>
																	@foreach($d->taxesTras as $t)
																		<tr>
																			<td>{{$t->cfdiTax->description}}</td>
																			<td>{{$t->quota}}</td>
																			<td>{{$t->quotaValue}}</td>
																			<td>{{$t->amount}}</td>
																		</tr>
																	@endforeach
																</tbody>
															</table>
														@endif
														@if($d->taxesRet->count()>0)
															<table class="table table-bordered mainware-taxes">
																<thead>
																	<tr>
																		<th colspan="4">Retenciones</th>
																	</tr>
																</thead>
																<tbody>
																	@foreach($d->taxesRet as $r)
																		<tr>
																			<td>{{$r->cfdiTax->description}}</td>
																			<td>{{$r->quota}}</td>
																			<td>{{$r->quotaValue}}</td>
																			<td>{{$r->amount}}</td>
																		</tr>
																	@endforeach
																</tbody>
															</table>
														@endif
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<p><br></p>
				@endif
				@if($bill->type == 'N')
				<div class="block-info">
					@if($bill->nomina->nominaPerception->count()>0)
						<table class="table centered-table table-bordered">
							<thead>
								<tr>
									<th>Tipo de percepción</th>
									<th>Clave</th>
									<th>Concepto</th>
									<th>Importe gravado</th>
									<th>Importe excento</th>
								</tr>
							</thead>
							<tbody>
								@foreach($bill->nomina->nominaPerception as $per)
									<tr>
										<td>{{$per->type}} - {{$per->perception->description}}</td>
										<td>{{$per->perceptionKey}}</td>
										<td>{{$per->concept}}</td>
										<td>{{$per->taxedAmount}}</td>
										<td>{{$per->exemptAmount}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<p><br></p>
					@endif
					@if($bill->nomina->nominaDeduction->count()>0)
						<table class="table centered-table table-bordered">
							<thead>
								<tr>
									<th>Tipo de deducción</th>
									<th>Clave</th>
									<th>Concepto</th>
									<th>Importe</th>
								</tr>
							</thead>
							<tbody>
								@foreach($bill->nomina->nominaDeduction as $ded)
									<tr>
										<td>{{$ded->type}} - {{$ded->deduction->description}}</td>
										<td>{{$ded->deductionKey}}</td>
										<td>{{$ded->concept}}</td>
										<td>{{$ded->amount}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<p><br></p>
					@endif
					@if($bill->nomina->nominaOtherPayment->count()>0)
						<table class="table centered-table table-bordered">
							<thead>
								<tr>
									<th>Tipo otro pago</th>
									<th>Clave</th>
									<th>Concepto</th>
									<th>Importe</th>
								</tr>
							</thead>
							<tbody>
								@foreach($bill->nomina->nominaOtherPayment as $other)
									<tr>
										<td>{{$other->type}} - {{$other->otherPayment->description}}</td>
										<td>{{$other->otherPaymentKey}}</td>
										<td>{{$other->concept}}</td>
										<td>{{$other->amount}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<p><br></p>
					@endif
				</div>
				@endif
				<div class="block-info">
					<table class="request-info no-border centered-table">
						<tbody>
							<tr>
								<td width="50%">
									<table class="request-info table table-bordered proyecta-payment">
										<tbody>
											<tr>
												<th align="left">Moneda</th>
												<td align="left">{{$bill->cfdiCurrency->description}}</td>
											</tr>
											@if($bill->paymentWay != null)
												<tr>
													<th align="left">Forma de pago</th>
													<td align="left">{{$bill->cfdiPaymentWay->description}}</td>
												</tr>
											@endif
											@if($bill->paymentMethod != null)
												<tr>
													<th align="left">Método de pago</th>
													<td align="left">{{$bill->cfdiPaymentMethod->description}}</td>
												</tr>
											@endif
										</tbody>
									</table>
								</td>
								<td>
									<table class="request-info ita-table-bordered">
										<tbody>
											<tr>
												<th align="left">Subtotal</th>
												<td align="right">$ {{$bill->subtotal}}</td>
											</tr>
											@if($bill->type != 'P')
												<tr>
													<th align="left">Descuento</th>
													<td align="right">$ {{$bill->discount}}</td>
												</tr>
											@endif
											@if($bill->type != 'P' && $bill->type != 'N')
												<tr>
													<th align="left">Total de impuestos trasladados</th>
													<td align="right">$ {{$bill->tras}}</td>
												</tr>
												<tr>
													<th align="left">Total de impuestos retenidos</th>
													<td align="right">$ {{$bill->ret}}</td>
												</tr>
											@endif
											<tr>
												<th align="left">Total</th>
												<td align="right">$ {{$bill->total}}</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				@if($bill->type == 'P')
					<div class="block-info">
						<table class="table table-borderless request-info no-border centered-table">
							<tbody>
								<tr>
									<th colspan="2">Información de pago</th>
								</tr>
								<tr>
									<td>
										<table class="table table-borderless request-info no-border centered-table">
											<tbody>
												<tr>
													<th align="left">Forma de pago</th>
													<td align="right">{{$bill->paymentComplement->first()->complementPaymentWay->description}}</td>
												</tr>
												<tr>
													<th align="left">Fecha de pago</th>
													<td align="right">{{$bill->paymentComplement->first()->paymentDate}}</td>
												</tr>
											</tbody>
										</table>
									</td>
									<td>
										<table class="table table-borderless request-info no-border centered-table">
											<tbody>
												<tr>
													<th align="left">Moneda de pago</th>
													<td align="right">{{$bill->paymentComplement->first()->complementCurrency->description}}</td>
												</tr>
												<tr>
													<th align="left">Monto</th>
													<td align="right">{{$bill->paymentComplement->first()->amount}}</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<p><br></p>
					<div class="block-info">
						<table class="table table-borderless request-info no-border centered-table">
							<tbody>
								<tr>
									<th colspan="2">Documento relacionado</th>
								</tr>
								@foreach($bill->cfdiRelated as $rel)
									<tr>
										<td>
											<table class="table table-borderless request-info no-border centered-table">
												<tbody>
													<tr>
														<th align="left">ID documento</th>
														<td>{{$rel->uuid}}</td>
													</tr>
													<tr>
														<th align="left">Número parcialidad</th>
														<td align="right">{{$rel->pivot->partial}}</td>
													</tr>
												</tbody>
											</table>
										</td>
										<td>
											<table class="table table-borderless request-info no-border centered-table">
												<tbody>
													<tr>
														<th align="left">Moneda del documento relacionado</th>
														<td align="right">{{$rel->cfdiCurrency->description}}</td>
													</tr>
													<tr>
														<th align="left">Método de pago del documento relacionado</th>
														<td align="right">{{$rel->cfdiPaymentMethod->description}}</td>
													</tr>
													<tr>
														<th align="left">Importe de saldo anterior</th>
														<td align="right">{{$rel->pivot->prevBalance}}</td>
													</tr>
													<tr>
														<th align="left">Importe pagado</th>
														<td align="right">{{$rel->pivot->amount}}</td>
													</tr>
													<tr>
														<th align="left">Importe de saldo insoluto</th>
														<td align="right">{{$rel->pivot->unpaidBalance}}</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
				<p><br></p>
				@if($bill->status == 1)
					<div class="block-info">
						<table style="margin: auto;width: 600px;max-width: 600px;">
							<thead>
								<tr>
									<th colspan="4">Sello digital del CFDI</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="left" colspan="4">
										<div class="text-break">{{$bill->digitalStampCFDI}}</div>
									</td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th colspan="4">Sello digital del SAT</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="left" colspan="4">
										<div class="text-break">{{$bill->digitalStampSAT}}</div>
									</td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">Cadena original</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="left" style="width: 500px;max-width: 100px;" colspan="3">
										<div class="text-break2">{{$bill->originalChain}}</div>
									</td>
									<td style="width: 100px;max-width: 100px;padding-left: .5rem" rowspan="2">
										<img style="width: 100px" src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->errorCorrection('H')->margin(0)->generate('https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id='.$bill->uuid.'&re='.$bill->rfc.'&rr='.$bill->clientRfc.'&tt='.$bill->total.'&fe='.substr($bill->digitalStampCFDI,-8))) !!}">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</main>
</body>
</html>