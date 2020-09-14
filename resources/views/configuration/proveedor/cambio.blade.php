@extends('layouts.child_module')

@section('css')
	<style type="text/css">
		.custom-select+.help-block.form-error
		{
			background: #cc0404;
			border-radius: 0;
			border: 1px solid #cc0404;
			color: #ffffff !important;
			display: inline-block !important;
			font-size: .8em;
			height: auto;
			line-height: 140% !important;
			margin: -2px 0 0 !important;
			padding: 2px 10px;
			position: absolute;
			right: 0;
			top: calc(-100% + 1.4em);
			width: auto;
		}
		.relative
		{
			position: relative;
		}
	</style>
@endsection

@section('data')
	{!! Form::open(['route' => ['provider.update', $provider->idProvider], 'method' => 'PUT', 'id' => 'container-alta']) !!}
		<div class="container-blocks" id="container-data">
			<div class="form-container">
				<label class="label-form"><h1>- DATOS DEL PROVEEDOR -</h1></label>
			</div>
			<br><br>
			<div class="div-form-group">
				<p>
					<label class="label-form">Raz&oacute;n Social</label>
					<input type="text" name="reason" class="input-text remove" placeholder="Razón Social" data-validation="length server required" data-validation-length="max150" value="{{ $provider->businessName }}" data-validation-url="{{ url('configuration/provider/validate') }}" data-validation-req-params="{{ json_encode(array('oldReason'=>$provider->businessName)) }}">
				</p>
				<p><label class="label-form">Calle</label>
					<input type="text" name="address" class="input-text remove" placeholder="Calle" data-validation="required length" data-validation-length="max100" value="{{ $provider->address }}">
				</p>
				<p><label class="label-form">Número</label>
					<input type="text" name="number" class="input-text remove" placeholder="Número" data-validation="required length" data-validation-length="max45" value="{{ $provider->number }}">
				</p>
				<p><label class="label-form">Colonia</label>
					<input type="text" name="colony" class="input-text remove" placeholder="Colonia" data-validation="required length" data-validation-length="max70" value="{{ $provider->colony }}">
				</p>
				<p><label class="label-form">CP</label>
					<input type="text" name="cp" class="input-text remove" placeholder="Código postal" data-validation="required length" data-validation-length="max10" value="{{ $provider->postalCode }}">
				</p>
				<p><label class="label-form">Ciudad</label>
					<input type="text" name="city" class="input-text remove" placeholder="Ciudad" data-validation="required length" data-validation-length="max70" value="{{ $provider->city }}">
				</p>
			</div>
			<div class="div-form-group">
				<p>
					<select class="input-text js-state" name="state" multiple="multiple" data-validation="required">
						<option value="">Seleccione una opción</option>
						@foreach(App\State::orderName()->get() as $state)
							@if($state->idstate==$provider->state_idstate)
								<option value="{{ $state->idstate }}" selected>{{ $state->description }}</option>
							@else
								<option value="{{ $state->idstate }}">{{ $state->description }}</option>
							@endif
						@endforeach
					</select>
				</p>
				<p><label class="label-form">RFC</label>
					<input type="text" name="rfc" class="input-text remove" placeholder="Ingrese el RFC" data-validation="rfc server required" value="{{ $provider->rfc }}" data-validation-url="{{ url('configuration/provider/validate') }}" data-validation-req-params="{{ json_encode(array('oldRfc'=>$provider->rfc)) }}">
				</p>
				<p>
					<label class="label-form">Tel&eacute;fono</label>
					<input id="input-small" type="text" name="phone" placeholder="Ingrese el teléfono" class="input-text phone remove" data-validation="number" value="{{ $provider->phone }}">
				</p>
				<p>
					<label class="label-form">Contacto</label>
					<input type="text" name="contact" placeholder="Nombre del contacto" class="input-text remove" data-validation="required" value="{{ $provider->contact }}">
				</p>
				<p>
					<label class="label-form">Beneficiario</label>
					<input type="text" name="beneficiary" placeholder="Nombre del beneficiario" class="input-text remove" data-validation="required" value="{{ $provider->beneficiary }}">
				</p>
				<p>
					<label class="label-form">Otro</label>
					<input type="text" name="other" placeholder="Otro..." class="input-text" value="{{ $provider->commentaries }}">
				</p>
			</div>
		</div>
		<br><br>
		<br><br>
		<center>
			<strong>CUENTAS BANCARIAS</strong>
		</center>
		<div class="divisor">
			<div class="gray-divisor"></div>
			<div class="orange-divisor"></div>
			<div class="gray-divisor"></div>
		</div>
		<br><br>
		<div class="table-responsive">
			<table class="full-table">
				<thead>
					<tr>
						<th>Banco</th>
						<th>Alias</th>
						<th>Cuenta</th>
						<th>Sucursal</th>
						<th>Referencia</th>
						<th>CLABE</th>
						<th>Moneda</th>
						<th>Convenio</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="banks-body">
					@foreach($provider->providerBank as $bank)
						<tr>
							<td>
								{{$bank->bank->description}}
								<input type="hidden" class="providerBank" name="providerBank[]" value="{{$bank->idProvider}}">
								<input type="hidden" name="bank[]" value="{{$bank->banks_idBanks}}">
							</td>
							<td>
								{{$bank->alias}}
								<input type="hidden" name="alias[]" value="{{$bank->alias}}">
							</td>
							<td>
								{{$bank->account}}
								<input type="hidden" name="account[]" value="{{$bank->account}}">
							</td>
							<td>
								{{$bank->branch}}
								<input type="hidden" name="branch_office[]" value="{{$bank->branch}}">
							</td>
							<td>
								{{$bank->reference}}
								<input type="hidden" name="reference[]" value="{{$bank->reference}}">
							</td>
							<td>
								{{$bank->clabe}}
								<input type="hidden" name="clabe[]" value="{{$bank->clabe}}">
							</td>
							<td>
								{{$bank->currency}}
								<input type="hidden" name="currency[]" value="{{$bank->currency}}">
							</td>
							<td>
								@if($bank->agreement=='')
									-------------------------
								@else
									{{$bank->agreement}}
								@endif
								<input type="hidden" name="agreement[]" value="{{$bank->agreement}}">
							</td>
							<td>
								<button class="delete-item" type="button"><span class="icon-x delete-span"></span></button>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		Para agregar una cuenta nueva es necesario colocar los siguientes campos:
		<div id="banks">
			<div class="form-container" id="form-container-inline">
				<div class="table-responsive">
					<table class="full-table">
						<tbody>
							<tr>
								<td colspan="7">
									<p>
										<select class="input-text js-bank" multiple="multiple">
											<option value="">Seleccione uno</option>
											@foreach(App\Banks::orderName()->get() as $bank)
												<option value="{{ $bank->idBanks }}">{{ $bank->description }}</option>
											@endforeach
										</select>
									</p>
								</td>
							</tr>
							<tr>
								<td>
									<p>
										<input type="text" class="input-text alias" placeholder="Alias">
									</p>
								</td>
								<td>
									<p>
										<input type="text" class="input-text account" placeholder="Cuenta bancaria" data-validation="cuenta">
									</p>
								</td>
								<td>
									<p>
										<input type="text" class="input-text branch_office" placeholder="Sucursal">
									</p>
								</td>
								<td>
									<p>
										<input type="text" class="input-text reference" placeholder="Referencia">
									</p>
								</td>
								<td>
									<p>
										<input type="text" class="input-text clabe" placeholder="CLABE" data-validation="clabe">
									</p>
								</td>
								<td>
									<div class="relative" style="margin-right: 1em;">
										<select class="custom-select currency" style="width: 6em;">
											<option value="">Seleccione una moneda</option>
											<option value="MXN">MXN</option>
											<option value="USD">USD</option>
											<option value="EUR">EUR</option>
											<option value="Otro">Otro</option>
										</select>
									</div>
								</td>
								<td>
									<p>
										<input type="text" class="input-text agreement" placeholder="Convenio (opcional)">
									</p>
								</td>
								<td>
									<button class="add2 plus-btn" type="button" name="add" id="add">+</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
		</div>
		<div id="delete"></div>
		<center>
			<p>
				<input class="btn btn-red enviar" type="submit"  name="enviar" value="ACTUALIZAR DATOS"> 
				<a
			  		@if(isset($option_id)) 
						href="{{ url(App\Module::find($option_id)->url) }}" 
					@else 
						href="{{ url(App\Module::find($child_id)->url) }}" 
					@endif 
				><button class="btn" type="button">REGRESAR</button></a>
			</p>
		</center>
		<br>
    {!! Form::close() !!}
@endsection

@section('scripts')
	<script src="{{ asset('js/select2.min.js') }}"></script>
	<script src="{{ asset('js/jquery.numeric.js') }}"></script>
	<script>
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.validate(
		{
			form		: '#container-alta',
			modules		: 'security',
			onSuccess	: function($form)
			{
				if($('#banks-body tr').length>0)
				{
					return true;
				}
				else
				{
					swal('','Debe ingresar al menos una cuenta bancaria','error');
					return false;
				}
			}
		});
		$('.js-bank').select2(
		{
			placeholder				: 'Seleccione un banco',
			language				: "es",
			maximumSelectionLength	: 1
		});
		$('.js-state').select2(
		{
			placeholder				: 'Seleccione un estado',
			language				: "es",
			maximumSelectionLength	: 1
		});
		$(document).ready(function()
		{
			$('input[name="cp"]').numeric(false);
			$('input[name="phone"]').numeric(false);
			$('.account,.clabe').numeric(false);
			$(document).on('click','#add',function()
			{
				bank			= $(this).parents('tbody').find('.js-bank').val();
				bankName		= $(this).parents('tbody').find('.js-bank :selected').text();
				account			= $(this).parents('tbody').find('.account').val();
				branch_office	= $(this).parents('tbody').find('.branch_office').val();
				reference		= $(this).parents('tbody').find('.reference').val();
				clabe			= $(this).parents('tbody').find('.clabe').val();
				currency		= $(this).parents('tbody').find('.currency').val();
				agreement		= $(this).parents('tbody').find('.agreement').val();
				alias 			= $(this).parents('tbody').find('.alias').val();
				if(bank.length>0)
				{
					$('.account,.reference,.clabe,.currency').removeClass('error');
					if (account == "" && reference=="" && clabe == "" || currency == "")
					{
						if(account == "" && reference=="" && clabe == "")
						{
							if(account == "")
							{
								$('.account').addClass('error');
							}
							if(reference=="")
							{
								$('.reference').addClass('error');
							}
							if(clabe == "")
							{
								$('.clabe').addClass('error');
							}
						}
						if(currency == "")
						{
							$('.currency').addClass('error');
						}
						swal('', 'Debe ingresar todos los campos requeridos', 'error');
					}
					else if($(this).parents('tr').find('.clabe').hasClass('error') || $(this).parents('tr').find('.account').hasClass('error'))
					{
						swal('', 'Por favor ingrese datos correctos', 'error');
					}
					else
					{
						bank = $('<tr></tr>')
								.append($('<td></td>')
									.append(bankName)
									.append($('<input type="hidden" class="providerBank" name="providerBank[]" value="x">'))
									.append($('<input type="hidden" name="bank[]" value="'+bank+'">'))
									)
								.append($('<td></td>')
									.append(alias)
									.append($('<input type="hidden" name="alias[]" value="'+alias+'">'))
									)
								.append($('<td></td>')
									.append(account)
									.append($('<input type="hidden" name="account[]" value="'+account+'">'))
									)
								.append($('<td></td>')
									.append(branch_office)
									.append($('<input type="hidden" name="branch_office[]" value="'+branch_office+'">'))
									)
								.append($('<td></td>')
									.append(reference)
									.append($('<input type="hidden" name="reference[]" value="'+reference+'">'))
									)
								.append($('<td></td>')
									.append(clabe)
									.append($('<input type="hidden" name="clabe[]" value="'+clabe+'">'))
									)
								.append($('<td></td>')
									.append(currency)
									.append($('<input type="hidden" name="currency[]" value="'+currency+'">'))
									)
								.append($('<td></td>')
									.append(agreement =='' ? '-------------------------' :agreement)
									.append($('<input type="hidden" name="agreement[]" value="'+agreement+'">'))
									)
								.append($('<td></td>')
									.append($('<button class="delete-item" type="button"><span class="icon-x delete-span"></span></button>'))
									);
						$('#banks-body').append(bank);
						$('.clabe, .account').removeClass('valid').val('');
						$('.branch_office,.reference,.currency,.agreement').val('');
						$(this).parents('tbody').find('.error').removeClass('error');
						$('.js-bank').val(0).trigger("change");
					}
				}
				else
				{
					swal('', 'Seleccione un banco, por favor', 'error');
					$('.js-bank').addClass('error');
				}
			})
			.on('click','.delete-item', function()
			{
				value	= $(this).parent('td').parent('tr').find('.providerBank').val();
				del		= $('<input type="hidden" name="delete[]">').val(value);
				$('#delete').append(del);
				$(this).parents('tr').remove();
			});
		});
	</script>
@endsection