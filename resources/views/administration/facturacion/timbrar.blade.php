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
	</style>
@endsection

@section('data')
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">Timbrar factura</h5>
		</div>
		<div class="card-body">
			<hr>
			<p>
				<label>Emisor:</label>
			</p>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>*RFC:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->rfc}}">
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>*Razón social:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->businessName}}">
			</div>
			<p>
				<label>Receptor:</label>
			</p>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>*RFC:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->clientRfc }}">
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>*Razón social:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->clientBusinessName }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>*Uso de CFDI:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->cfdiUse->description }}">
				<div class="input-group-append">
					<span class="input-group-text"><strong>*Tipo de CFDI:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->cfdiType->description}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>*Código postal:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->postalCode}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>*Forma de pago:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->cfdiPaymentWay->paymentWay}} {{$bill->cfdiPaymentWay->description}}">
				<div class="input-group-append">
					<span class="input-group-text"><strong>*Método de pago:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->cfdiPaymentMethod->paymentMethod}} {{$bill->cfdiPaymentMethod->description}}">
			</div>
			<div class="input-group mb-1">
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
														$id_temp	= time();
													@endphp
													<input type="text" disabled class="form-control-plaintext" value="{{$d->keyProdServ}}">
													<input type="hidden" value="{{$id_temp}}"></td>
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
					<span class="input-group-text"><strong>*Subtotal:</strong></span>
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
					<span class="input-group-text"><strong>*Total:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->total}}">
			</div>
		</div>
		<div class="card-footer text-right">
			<form method="post" action="{{route('bill.pending.pac',$bill->idBill)}}">
				@csrf
				<div class="div-form-group modules text-left" style="display: block;">
					<ul>
						<li>
							<input name="send_email_cfdi" type="checkbox" value="1" id="email_cfdi">
							<label class="switch" for="email_cfdi"><span class="slider round"></span>Enviar por email</label>
						</li>
					</ul>
				</div>
				<a href="{{route('bill.pending.edit',$bill->idBill)}}" class="btn btn-green">Modificar factura</a>
				<button class="btn btn-blue stamp-cfdi" type="submit">Timbrar factura</button>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript">
		$(document).ready(function()
		{
			$.validate(
			{
				onSuccess : function($form)
				{
					swal({
						icon				: 'http://localhost:8888/sistema/public/images/load.gif',
						button				: false,
						closeOnEsc			: false,
						closeOnClickOutside	: false,
					});
				}
			});
			$(document).on('change','[name="send_email_cfdi"]',function()
			{
				if($(this).is(':checked'))
				{
					$('.modules').append('<button type="button" class="btn btn-blue add-email-cfdi mb-1"><span class="icon-plus"></span> Agregar email</button>');
					$('.modules').append('<div class="input-group mb-1 email-cfdi"><input type="email" class="form-control" data-validation="required email" name="email_cfdi[]"></div>');
					$.validate(
					{
						onSuccess : function($form)
						{
							swal({
								icon				: 'http://localhost:8888/sistema/public/images/load.gif',
								button				: false,
								closeOnEsc			: false,
								closeOnClickOutside	: false,
							});
						}
					});
				}
				else
				{
					$('.add-email-cfdi,.email-cfdi').remove();
					form = $(this).parent('li').parent('ul').parent('div').parent('form');
					form[0].reset();
				}
			})
			.on('click','.add-email-cfdi',function()
			{
				$('.modules').append('<div class="input-group mb-1 email-cfdi"><input type="email" class="form-control" data-validation="required email" name="email_cfdi[]"><div class="input-group-append"><button class="btn btn-red delete-email-cfdi" type="button"><span class="icon-x"></span></button></div></div>');
				$.validate(
				{
					onSuccess : function($form)
					{
						swal({
							icon				: 'http://localhost:8888/sistema/public/images/load.gif',
							button				: false,
							closeOnEsc			: false,
							closeOnClickOutside	: false,
						});
					}
				});
			})
			.on('click','.delete-email-cfdi',function()
			{
				$(this).parent('.input-group-append').parent('.input-group').remove();
				$.validate(
				{
					onSuccess : function($form)
					{
						swal({
							icon				: 'http://localhost:8888/sistema/public/images/load.gif',
							button				: false,
							closeOnEsc			: false,
							closeOnClickOutside	: false,
						});
					}
				});
			});
		});
	</script>
@endsection