@extends('layouts.child_module')
@section('css')
	<style>
		.taxError
		{
			background: #ffd6d1;
		}
		ul.select2-selection__rendered li:not(:first-child)
		{
			height		: 0;
			overflow	: hidden;
		}
		.help-block.form-error
		{
			position	: absolute;
			right		: 0;
			top			: -19px;
		}
		.custom-select + span.select2.select2-container.select2-container--default
		{
			padding	: .2rem .5rem;
		}
		.custom-select + span .select2-selection.select2-selection--multiple
		{
			background		: none !important;
			border-bottom	: 0 !important;
			height			: 1rem;
		}
		.select2-selection__choice
		{
			margin	: 0 !important;
			padding	: .1rem !important;
		}
		.icon-xml,
		.icon-pdf
		{
			font-size	: 4rem;
			padding		: 1rem 2rem;
		}
	</style>
@endsection

@section('data')
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">Cancelar factura</h5>
		</div>
		<div class="card-body">
			<hr>
			<p>
				<label>Emisor:</label>
			</p>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>RFC:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->rfc}}">
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Razón social:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->businessName}}">
			</div>
			<p>
				<label>Receptor:</label>
			</p>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>RFC:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->clientRfc }}">
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Razón social:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->clientBusinessName }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Folio Fiscal (UUID):</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->uuid }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>No. Certificado Digital:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->noCertificate }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>No. Certificado Digital SAT:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->satCertificateNo }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Uso de CFDI:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->cfdiUse->description }}">
				<div class="input-group-append">
					<span class="input-group-text"><strong>Tipo de CFDI:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->cfdiType->description}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Código postal:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->postalCode}}">
				<div class="input-group-append">
					<span class="input-group-text"><strong>Fecha de timbrado:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->stampDate}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Forma de pago:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->cfdiPaymentWay->paymentWay}} {{$bill->cfdiPaymentWay->description}}">
				<div class="input-group-append">
					<span class="input-group-text"><strong>Método de pago:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->cfdiPaymentMethod->paymentMethod}} {{$bill->cfdiPaymentMethod->description}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Folio:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->folio}}">
				<div class="input-group-prepend">
					<span class="input-group-text">Serie:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->serie}}">
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text">Condiciones de pago:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->conditions}}">
			</div>
			<div class="table-responsive">
				<table class="table">
					<tbody>
						@foreach($bill->billDetail as $d)
							<tr>
								<td colspan="8">
									<table class="table table-borderless">
										<thead class="thead-dark">
											<tr>
												<th><strong>Clave de producto o servicio</strong></th>
												<th><strong>Clave de unidad</strong></th>
												<th><strong>Cantidad</strong></th>
												<th><strong>Descripción</strong></th>
												<th><strong>Valor unitario</strong></th>
												<th><strong>Importe</strong></th>
												<th><strong>Descuento</strong></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="align-middle">
													@php
														$id	= time();
													@endphp
													<input type="text" disabled class="form-control-plaintext" value="{{$d->keyProdServ}}">
													<input type="hidden" value="{{$id}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->keyUnit}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->quantity}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->description}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->value}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->amount}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->discount}}"></td>
											</tr>
											<tr>
												<td colspan="7">
													@if($d->taxesRet->count()>0)
														<table class="table table-borderless">
															<thead class="thead-white">
																<tr>
																	<th colspan="4">Retenciones</th>
																</tr>
															</thead>
															<tbody>
														@foreach($d->taxesRet as $ret)
																<tr>
																	<td class="align-middle">{{$ret->cfdiTax->description}}</td>
																	<td class="align-middle">{{$ret->quota}}</td>
																	<td class="align-middle">{{$ret->quotaValue}}</td>
																	<td class="align-middle">{{$ret->amount}}</td>
																</tr>
														@endforeach
															</tbody>
														</table>
													@endif
													@if($d->taxesTras->count()>0)
														<table class="table table-borderless">
															<thead class="thead-white">
																<tr>
																	<th colspan="4">Traslados</th>
																</tr>
															</thead>
															<tbody>
														@foreach($d->taxesTras as $tras)
																<tr>
																	<td class="align-middle">{{$tras->cfdiTax->description}}</td>
																	<td class="align-middle">{{$tras->quota}}</td>
																	<td class="align-middle">{{$tras->quotaValue}}</td>
																	<td class="align-middle">{{$tras->amount}}</td>
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
			<div class="mb-5"></div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Subtotal:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->subtotal}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Descuento:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->discount}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Total de impuestos trasladados:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->tras}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Total de impuestos retenidos:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->ret}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Total:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->total}}">
			</div>
		</div>
		<div class="card-footer text-center">
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Estatus SAT</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->statusCFDI}}">
			</div>
			<p><br></p>
			<form action="{{route('bill.cancel',$bill->idBill)}}" method="post">
				@csrf
				<button type="submit" class="btn btn-red cancel-cfdi"><span class="icon-x"></span> Cancelar</button>
			</form>
		</div>
		<div class="card-footer text-right">
			<a href="{{route('bill.stamped')}}" class="btn btn-red">Regresar</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript"> 
		$(document).ready(function()
		{
			$(document).on('click','.cancel-cfdi',function(e)
			{
				e.preventDefault();
				actioner	= $(this);
				swal({
					title		: "",
					text		: "Confirme que desea cancelar el comprobante",
					icon		: "warning",
					buttons		:
					{
						cancel:
						{
							text		: "Abortar",
							value		: null,
							visible		: true,
							closeModal	: true,
						},
						confirm:
						{
							text		: "Proceder con la cancelación",
							value		: true,
							closeModal	: false
						}
					},
					dangerMode	: true,
				})
				.then((a) => {
					if (a)
					{
						actioner.parent('form').submit();
					}
				});
			});
		});
	</script>
@endsection