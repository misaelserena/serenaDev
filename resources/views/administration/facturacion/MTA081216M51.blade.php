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
		.logo img
		{
			width: 100%;
			margin-bottom	: .1rem;
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
		table.mainware-payment-info tr th
		{
			border-bottom	: 0 !important;
			background		: #384d9c !important;
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
		.mainware-data tr th,
		.mainware-footer tbody tr th,
		.mainware-footer tbody tr td
		{
			border-bottom: 1px dotted #000;
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
	</style>
</head>
<body>
	<main>
		<div class="pdf-full">
			<div class="pdf-body">
				<div class="block-info">
					<table class="centered-table">
						<tbody>
							<tr>
								<td width="53%">
									@php
										$path	= public_path('/images/enterprise/'.\App\Enterprise::where('rfc',$bill->rfc)->first()->path);
										$type	= pathinfo($path, PATHINFO_EXTENSION);
										$data	= file_get_contents($path);
										$base64	= 'data:image/' . $type . ';base64,' . base64_encode($data);
									@endphp
									<img src="{{ $base64 }}" class="logo">
									<p><br></p>
									<table class="table table-bordered" style="width: 98%">
										<thead>
											<tr>
												<th>RFC emisor:</th>
												<th>Nombre emisor:</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>{{$bill->rfc}}</th>
												<th>{{$bill->businessName}}</th>
											</tr>
										</tbody>
										<thead>
											<tr>
												<th>RFC receptor:</th>
												<th>Nombre receptor:</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{{$bill->clientRfc}}</td>
												<td>{{$bill->clientBusinessName}}</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td width="47%">
									<table class="request-info no-border mainware-data" style="width: 98%">
										<tbody>
											@if($bill->related != null)
												<tr>
													<th>
														<span class="text-left">Tipo de relación: </span>
														<span class="normal">{{App\CatRelation::where('typeRelation',$bill->related)->first()->description}}</span>
													</th>
												</tr>
											@endif
											<tr>
												<th>
													<span class="text-left">Uso CFDI: </span>
													<span class="normal">{{$bill->cfdiUse->description}}</span>
												</th>
											</tr>
											<tr>
												<th>
													<span class="text-left">Efecto de comprobante: </span>
													<span class="normal">{{$bill->cfdiType->description}}</span>
												</th>
											</tr>
											@if($bill->related != null)
												<tr>
													<th>
														<span class="text-left">Folio fiscal a relacionar: </span>
														<span class="normal">
															@foreach($bill->cfdiRelated as $rel)
																{{$rel->uuid}}<br>
															@endforeach
														</span>
													</th>
												</tr>
											@endif
											@if($bill->uuid != '')
												<tr>
													<th>
														<span class="text-left">Folio fiscal: </span>
														<span class="normal">{{$bill->uuid}}</span>
													</th>
												</tr>
											@endif
											@if($bill->noCertificate != '')
												<tr>
													<th>
														<span class="text-left">No. de serie del CSD: </span>
														<span class="normal">{{$bill->noCertificate}}</span>
													</th>
												</tr>
											@endif
											@if($bill->satCertificateNo != '')
												<tr>
													<th>
														<span class="text-left">No. de serie del SAT: </span>
														<span class="normal">{{$bill->satCertificateNo}}</span>
													</th>
												</tr>
											@endif
											<tr>
												<th>
													<span class="text-left">Código postal, fecha y hora de emisión: </span>
													<span class="normal">{{$bill->postalCode}}, {{$bill->expeditionDateCFDI}}</span>
												</th>
											</tr>
											@if($bill->stampDate != '')
												<tr>
													<th>
														<span class="text-left">Fecha y hora de certificación: </span>
														<span class="normal">{{$bill->stampDate}}</span>
													</th>
												</tr>
											@endif
										</tbody>
									</table>
								</td>
							</tr>
							@if($bill->type=='N')
								<tr>
									<td colspan="2">
										<table class="request-info no-border mainware-data" style="width: 90%; margin: auto;">
											<tbody>
												<tr>
													<th colspan="2">
														<center><b style="font-weight: 600">Datos complementarios del receptor</b></center>
													</th>
												</tr>
												<tr>
													<th>
														<span class="text-left">CURP:</span>
														<span class="normal">{{$bill->nominaReceiver->curp}}</span>
													</th>
													<th>
														<span class="text-left">Tipo contrato:</span>
														<span class="normal">{{$bill->nominaReceiver->nominaContract->description}}</span>
													</th>
												</tr>
												<tr>
													<th>
														<span class="text-left">Riesgo de puesto:</span>
														<span class="normal">{{$bill->nominaReceiver->nominaPositionRisk->description}}</span>
													</th>
													<th>
														<span class="text-left">Tipo régimen</span>
														<span class="normal">{{$bill->nominaReceiver->nominaRegime->description}}</span>
													</th>
												</tr>
												<tr>
													<th>
														<span class="text-left">SDI</span>
														<span class="normal">{{$bill->nominaReceiver->sdi}}</span>
													</th>
													<th>
														<span class="text-left">Número de seguridad social</span>
														<span class="normal">{{$bill->nominaReceiver->nss}}</span>
													</th>
												</tr>
												<tr>
													<th>
														<span class="text-left">Número de empleado</span>
														<span class="normal">{{$bill->nominaReceiver->employee_id}}</span>
													</th>
													<th>
														<span class="text-left">Inicio de relación laboral</span>
														<span class="normal">{{$bill->nominaReceiver->laboralDateStart}}</span>
													</th>
												</tr>
												<tr>
													<th>
														<span class="text-left">Periodicidad del pago</span>
														<span class="normal">{{$bill->nominaReceiver->nominaPeriodicity->description}}</span>
													</th>
													<th>
														<span class="text-left">Antigüedad</span>
														<span class="normal">{{$bill->nominaReceiver->antiquity}}</span>
													</th>
												</tr>
												<tr>
													<th>
														<span class="text-left">Clave entidad federativa</span>
														<span class="normal">{{$bill->nominaReceiver->c_state}}</span>
													</th>
													<th>
														
													</th>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							@endif
						</tbody>
					</table>
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
					<table class="request-info no-border centered-table mainware-footer">
						<tbody>
							<tr>
								<td width="50%" rowspan="5">
									<table class="request-info table table-bordered mainware-payment-info">
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
							<tbody>
								<tr>
									<td colspan="4">Sello digital del CFDI<hr></td>
								</tr>
								<tr>
									<td align="left" colspan="4">
										<div class="text-break">{{$bill->digitalStampCFDI}}</div>
									</td>
								</tr>
								<tr>
									<td colspan="4">Sello digital del SAT<hr></td>
								</tr>
								<tr>
									<td align="left" colspan="4">
										<div class="text-break">{{$bill->digitalStampSAT}}</div>
									</td>
								</tr>
								<tr>
									<td colspan="4">Cadena original<hr></td>
								</tr>
								<tr>
									<td align="left" style="width: 500px;max-width: 100px;" colspan="3">
										<div class="text-break2">{{$bill->originalChain}}</div>
									</td>
									<td style="width: 100px;max-width: 100px;">
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