@extends('layouts.child_module')
@section('css')
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<style>
		.taxError
		{
			background: #ffd6d1;
		}
		.table-responsive ul.select2-selection__rendered li:not(:first-child)
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
		.payments-receipt
		{
			display: none;
		}
	</style>
@endsection

@section('data')
@if($bill->status == 0 || $bill->status == 7)
	<form id="container-factura" action="{{route('bill.nomina.save.saved',$bill->idBill)}}" method="POST">
		@csrf
@endif
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Nómina</h5>
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
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->rfc}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Razón social:</strong></span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->businessName}}" @endif>
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Régimen fiscal:</strong></span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->taxRegime}} - {{$bill->cfdiTaxRegime->description}}" @endif>
				</div>
				<p>
					<label>Receptor:</label>
				</p>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*RFC:</strong></span>
					</div>
					<input type="text" class="form-control" data-validation="custom required" name="rfc_receiver" data-validation-regexp="^([A-ZÑ&]{4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$" data-validation-error-msg="Por favor, ingrese un RFC válido" @if(isset($bill)) value="{{$bill->clientRfc}}" @endif>
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Razón social:</strong></span>
					</div>
					<input type="text" class="form-control" data-validation="required" name="business_name_receiver" @if(isset($bill)) value="{{$bill->clientBusinessName}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Uso de CFDI:</strong></span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->cfdiUse->description}}" @endif>
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Tipo de CFDI:</strong></span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="Nómina" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Código postal:</strong></span>
					</div>
					<select class="custom-select" id="cp_cfdi" name="cp_cfdi" data-validation="required" multiple>
						@if(isset($bill) && $bill->postalCode != '')
							<option value="{{$bill->postalCode}}" selected>{{$bill->postalCode}}</option>
						@endif
					</select>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Forma de pago:</strong></span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->paymentWay}} {{$bill->cfdiPaymentWay->description}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Método de pago:</strong></span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->paymentMethod}} {{$bill->cfdiPaymentMethod->description}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Serie:</span>
					</div>
					<input name="serie" type="text" class="form-control" @if(isset($bill)) value="{{$bill->serie}}" @endif>
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text">Condiciones de pago:</span>
					</div>
					<input type="text" class="form-control" name="conditions" @if(isset($bill)) value="{{$bill->conditions}}" @endif>
				</div>
				<div class="table-responsive">
					<table class="table cfdi-concepts">
						<tbody>
							@if(isset($bill))
								@foreach($bill->billDetail as $d)
									<tr>
										<td colspan="8">
											<table class="table table-borderless">
												<thead class="thead-dark">
													<tr>
														<th><strong>Clave de producto o servicio</strong></th>
														<th><strong>Clave de unidad</strong></th>
														<th><strong>Cantidad</strong></th>
														<th width="20%"><strong>Descripción</strong></th>
														<th><strong>Valor unitario</strong></th>
														<th><strong>Importe</strong></th>
														<th><strong>Descuento</strong></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->keyProdServ}}"></td>
														<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->keyUnit}}"></td>
														<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->quantity}}"></td>
														<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->description}}"></td>
														<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->value}}"></td>
														<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->amount}}"></td>
														<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->discount}}"></td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<p><br></p>
				<div class="card payments-receipt" style="display: block;">
					<div class="card-header">
						<h5 class="card-title">Nómina</h5>
					</div>
					<div class="card-body">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Datos complementarios del receptor</h5>
							</div>
							<div class="card-body">
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*CURP:</strong></span>
									</div>
									<input type="text" class="form-control" name="nomina_curp" data-validation="custom required" data-validation-regexp="^([A-Z][A,E,I,O,U,X][A-Z]{2})(\d{2})((01|03|05|07|08|10|12)(0[1-9]|[12]\d|3[01])|02(0[1-9]|[12]\d)|(04|06|09|11)(0[1-9]|[12]\d|30))([M,H])(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)([B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3})([0-9,A-Z][0-9])$" data-validation-error-msg="Por favor, ingrese un CURP válido" @if(isset($bill)) value="{{$bill->nominaReceiver->curp}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Número de seguridad social:</strong></span>
									</div>
									<input type="text" class="form-control" name="nss" @if(isset($bill)) value="{{$bill->nominaReceiver->nss}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Fecha de inicio de relación laboral:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nominaReceiver->laboralDateStart}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Antigüedad:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nominaReceiver->antiquity}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Riesgo de puesto:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nominaReceiver->nominaPositionRisk->description}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Salario diario integrado:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nominaReceiver->sdi}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Tipo contrato:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nominaReceiver->nominaContract->description}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Tipo régimen:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nominaReceiver->nominaRegime->description}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Número de empleado:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nominaReceiver->employee_id}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Periodicidad del pago:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nominaReceiver->nominaPeriodicity->description}}" @endif>
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Clave entidad federativa:</strong></span>
									</div>
									<select class="custom-select" name="nomina_state">
										@foreach(App\State::orderName()->get() as $state)
											<option value="{{$state->c_state}}" @if($bill->nominaReceiver->c_state==$state->c_state) selected @endif>{{$state->c_state}} - {{$state->description}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<p><br></p>
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Datos generales de la nómina</h5>
							</div>
							<div class="card-body">
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Tipo de nómina:</strong></span>
									</div>
									<select class="custom-select" name="nomina_type">
										<option value="O" @if($bill->nomina->type=='O') selected @endif>Ordinaria</option>
										<option value="E" @if($bill->nomina->type=='E') selected @endif>Extraordinaria</option>
									</select>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Fecha de pago:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nomina->paymentDate}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Fecha inicial de pago:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nomina->paymentStartDate}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Fecha final de pago:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nomina->paymentEndDate}}" @endif>
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Número de días pagados:</strong></span>
									</div>
									<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->nomina->paymentDays}}" @endif>
								</div>
							</div>
						</div>
						<p><br></p>
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Percepciones</h5>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead class="thead-dark">
											<tr>
												<th width="30%">*Tipo de percepción</th>
												<th width="15%">*Clave</th>
												<th width="35%">*Concepto</th>
												<th width="10%">*Importe gravado</th>
												<th width="10%">*Importe excento</th>
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
								</div>
							</div>
						</div>
						<p><br></p>
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Deducciones</h5>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead class="thead-dark">
											<tr>
												<th width="35%">*Tipo de deducción</th>
												<th width="15%">*Clave</th>
												<th width="40%">*Concepto</th>
												<th width="10%">*Importe</th>
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
								</div>
							</div>
						</div>
						<p><br></p>
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Otros pagos</h5>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead class="thead-dark">
											<tr>
												<th width="35%">*Tipo otro pago</th>
												<th width="15%">*Clave</th>
												<th width="40%">*Concepto</th>
												<th width="10%">*Importe</th>
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
								</div>
							</div>
						</div>
					</div>
				</div>
				<p><br></p>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Subtotal:</strong></span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->subtotal}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Descuento:</span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->discount}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Total:</strong></span>
					</div>
					<input type="text" class="form-control" disabled @if(isset($bill)) value="{{$bill->total}}" @endif>
				</div>
			</div>
			<div class="card-footer text-right">
				@if($bill->status == 0 || $bill->status == 7)
					@if($bill->status == 7)
						<div class="alert alert-danger text-center" role="alert">
							<b>Error durante el timbrado:</b><br>
							<p>
								{!!$bill->error!!}
							</p>
						</div>
					@endif
					<button class="btn btn-blue" id="save_only" type="submit">Guardar nómina</button>
					<button class="btn btn-green" type="submit" formaction="{{route('bill.nomina.add.queue',$bill->idBill)}}">Agregar a cola de timbrado</button>
					<button class="btn btn-red" type="submit" formaction="{{route('bill.nomina.stamp.saved',$bill->idBill)}}">Timbrar ahora</button>
				@elseif($bill->status == 6)
					<div class="alert alert-danger text-center" role="alert">
						El CFDI de nómina se encuentra en cola para timbrado.
					</div>
				@endif
			</div>
		</div>
@if($bill->status == 0)
	</form>
@endif
@endsection
@section('scripts')
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="{{ asset('js/select2.min.js') }}"></script>
	<script src="{{ asset('js/datepicker.js') }}"></script>
	<script>
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		formValidate();
		$(document).ready(function()
		{
			$('#cp_cfdi').select2({
				maximumSelectionLength	: 1,
				ajax					:
				{
					delay		: 400,
					url			: '{{route('income.catalogue.zip')}}',
					dataType	: 'json',
					method		: 'post',
					data		: function (params)
					{
						s =
						{
							search: params.term,
						}
						return s;
					}
				},
				minimumInputLength		: 3,
				language				:
				{
					noResults: function()
					{
						return "No hay resultados";
					},
					searching: function()
					{
						return "Buscando...";
					},
					inputTooShort: function(args)
					{
						return 'Por favor ingrese más de 3 caracteres';
					}
				}
			});
			$(document).on('change','#emiter_cfdi_search,[name="receptor_cfdi_search"]',function()
			{
				$('.cfdi-search-container').html('');
			})
			.on('change','#enterprise_selector',function()
			{
				rfc				= $(this).val();
				businessName	= $(this).find('option:selected').text();
				taxRegime		= $(this).find('option:selected').attr('data-tax-regime');
				$('[name="business_name_emitter"]').val(businessName);
				$('[name="rfc_emitter"]').val(rfc);
				$('[name="tax_regime_cfdi"]').val(taxRegime);
			})
			.on('click','#save_only',function()
			{
				$('#container-factura')[0].submit();
			});
		});
		function formValidate()
		{
			$.validate(
			{
				form		: '#container-factura',
				onSuccess	: function($form)
				{
					if($('#taxRegime').val()!='')
					{
						if($('.table.cfdi-concepts tbody tr').length<1)
						{
							swal('','Al menos debe ingresar un concepto','error');
							return false;
						}
						else if(Number($('[name="cfdi_total"]').val()) <= 0 && $('[name="cfdi_kind"]').val() != 'P')
						{
							swal('','No pueden timbrarse facturas en cero o total negativo','error');
							return false;
						}
						else
						{
							swal({
								icon				: '{{asset('/images/load.gif')}}',
								button				: false,
								closeOnEsc			: false,
								closeOnClickOutside	: false,
							});
						}
					}
					else
					{
						swal('','La empresa seleccionada no cuenta con régimen fiscal registrado por lo que no se podrá proceder.','warning');
						return false;
					}
				},
			});
		}
	</script>
@endsection