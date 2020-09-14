@extends('layouts.layout')
@section('title', $title)
@section('content')
	<div class="container-blocks-all">
		<div class="title-config">
			<h1>{{ $title }}</h1>
		</div>
		<center>
			<i style="color: #B1B1B1">{{ $details }}</i>
		</center>
		<br>
		<hr>
		<br>
		¡Hola, {{ Auth::user()->name }}!
		<br><br>
		A continuación encontrará un resumen de su perfil y podrá modificar algunos datos básicos:
		<div class="data-container">
			{!! Form::open(['route' => ['profile.update', Auth::user()->id], 'method' => 'PUT', 'id' => 'container-alta']) !!}
				<div class="profile-table-center">
					<div class="profile-table-center-header">
						Datos Personales
					</div>
					<div class="profile-table-center-row">
						<div class="left">
							Nombre:
						</div>
						<div class="right">
							<p>{{ Auth::user()->name }} {{ Auth::user()->last_name }} {{ Auth::user()->scnd_last_name }}</p>
						</div>
					</div>
					<div class="profile-table-center-row">
						<div class="left">
							Correo Electrónico:
						</div>
						<div class="right">
							<p>{{ Auth::user()->email }}</p>
						</div>
					</div>
					<div class="profile-table-center-row">
						<div class="left">
							Contraseña:
						</div>
						<div class="right">
							<p><a href="{{ route('profile.password') }}" class="btn btn-red">Modificar contraseña</a></p>
						</div>
					</div>
					<div class="profile-table-center-row">
						<div class="left">
							Teléfono:
						</div>
						<div class="right">
							<p><input type="text" name="phone" placeholder="Ingrese el teléfono" class="phone" value="{{ Auth::user()->phone }}" data-validation="phone"></p>
						</div>
					</div>
					<div class="profile-table-center-row">
						<div class="left">
							Extensión:
						</div>
						<div class="right">
							<p><input type="text" name="extension" placeholder="Ingrese la extensión" class="extension" value="{{ Auth::user()->extension }}"></p>
						</div>
					</div>
					<div class="profile-table-center-row">
						<div class="left">
							Dirección:
						</div>
						<div class="right">
							<p>{{ Auth::user()->area->name }}</p>
						</div>
					</div>
					<div class="profile-table-center-row">
						<div class="left">
							Departamento:
						</div>
						<div class="right">
							@if(isset(Auth::user()->departament))
								<p>{{ Auth::user()->departament->name }}</p>
							@endif
						</div>
					</div>
					<div class="profile-table-center-row no-border">
						<div class="left">
							Recibir Email:
						</div>
						<div class="right">
							@php
								$notification = App\User::find(Auth::user()->id);
							@endphp

							@if(isset(Auth::user()->id))
							<p>
								<input type="radio" name="mails" id="no" value="0" @if($notification->notification == 0) checked @endif>
								<label for="no">No</label> 
								<input type="radio" name="mails" id="si" value="1" @if($notification->notification == 1) checked @endif>
								<label for="si">Sí</label>
							</p>
							@endif
						</div>
					</div>
				</div>
				<br><br><br>
				<center>
					<strong>EMPRESAS</strong>
				</center>
				<div class="divisor">
					<div class="gray-divisor"></div>
					<div class="orange-divisor"></div>
					<div class="gray-divisor"></div>
				</div>
				<div class="profile-enterprises">
					@foreach(Auth::user()->enterprise as $enterprise)
						<div class="profile-enterprise-item">
							<div class="profile-logo-enterprise" style="background-image: url({{ url('images/enterprise/'.$enterprise->path) }});"></div>
							<span class="profile-name-enterprise">{{ $enterprise->name }}</span>
							<span class="profile-details-enterprise">{{ $enterprise->details }}</span>
						</div>
					@endforeach
				</div>
				<br><br><br>
				<center>
					<strong>CUENTAS BANCARIAS</strong>
				</center>
				<div class="divisor">
					<div class="gray-divisor"></div>
					<div class="orange-divisor"></div>
					<div class="gray-divisor"></div>
				</div>
				<br><br>
				<label class="profile-no-accounts" @if(Auth::user()->employee->where('visible',1)->count()>0) style="display: none;" @endif>Ninguna cuenta agregada</label>
				<div class="table-responsive">
					<table class="full-table options" @if(Auth::user()->employee->where('visible',1)->count()==0) style="display: none;" @endif>
						<thead>
							<tr>
								<th>Banco</th>
								<th>Alias</th>
								<th>Número de tarjeta</th>
								<th>CLABE interbancaria</th>
								<th>Número de cuenta</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="banks-body">
							@foreach(Auth::user()->employee->where('visible',1) as $emp)
								<tr>
									<td>
										{{ $emp->bank->description }}
										<input type="hidden" class="idEmployee" name="idEmployee[]" value="{{ $emp->idEmployee }}">
										<input type="hidden" class="idEmployee" name="bank[]" value="{{ $emp->idBanks }}">
									</td>
									<td>
										@if($emp->alias=='')
											-------------------------
										@else
											{{ $emp->alias }}
										@endif
										<input type="hidden" name="alias[]" value="{{ $emp->alias }}">
									</td>
									<td>
										@if($emp->cardNumber=='')
											-------------------------
										@else
											{{ $emp->cardNumber }}
										@endif
										<input type="hidden" name="card[]" value="{{ $emp->cardNumber }}">
									</td>
									<td>
										@if($emp->clabe=='')
											-------------------------
										@else
											{{ $emp->clabe }}
										@endif
										<input type="hidden" name="clabe[]" value="{{ $emp->clabe }}">
									</td>
									<td>
										@if($emp->account=='')
											-------------------------
										@else
											{{ $emp->account }}
										@endif
										<input type="hidden" name="account[]" value="{{ $emp->account }}">
									</td>
									<td>
										<button class="delete-item" type="button"><span class="icon-x delete-span"></span></button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				Para agregar una cuenta nueva es necesario colocar al menos uno de los campos:
				<div id="banks">
					<div class="form-container" id="form-container-inline">
						<div class="table-responsive">
							<table class="full-table">
								<tbody>
									<tr>
										<td>
											<p>
												<select class="input-text bank" multiple="multiple">
													<option value="">Seleccione uno</option>
													@foreach(App\Banks::orderName()->get() as $bank)
														<option value="{{ $bank->idBanks }}">{{ $bank->description }}</option>
													@endforeach
												</select>
											</p>
										</td>
										<td>
											<p>
												<input type="text" class="input-text alias" placeholder="Alias">
											</p>
										</td>
										<td>
											<p>
												<input type="text" class="input-text card" placeholder="Número de tarjeta" data-validation="tarjeta">
											</p>
										</td>
										<td>
											<p>
												<input type="text" class="input-text clabe" placeholder="CLABE" data-validation="clabe">
											</p>
										</td>
										<td>
											<p>
												<input type="text" class="input-text account" placeholder="Cuenta bancaria" data-validation="cuenta">
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
			</div>
			<div id="delete">
				
			</div>
			<center>
				<input type="submit" name="send" value="GUARDAR CAMBIOS" class="btn btn-red">
			</center>
			{!! Form::close() !!}
		</div>
		<br><br><br><br>
	</div>
@endsection

@section('scripts')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript">
	$.validate(
	{
		form: '#container-alta',
		modeles: 'logic',
		onSuccess : function($form)
		{
			flag = false;
			$("#banks-body tr").each(function(i, v)
			{
				card		= $(this).find('.card').val();
				clabe		= $(this).find('.clabe').val();
				account 	= $(this).find('.account').val();
				if (card == "" && clabe == "" && account == "")
				{
					flag = true;
				}
			});
			if(flag == true)
			{
				swal('', 'Debe ingresar al menos un número de tarjeta, clabe o cuenta bancaria', 'error');
				return false;
				
			}
			else
			{
				return true;
			}
		}
	});
	$(document).ready(function()
	{
		$('.phone,.extension').numeric(false);    // números
		$('.card,.clabe,.account',).numeric(false);
		$('.bank').select2(
		{
			placeholder				: 'Seleccione el banco',
			language				: "es",
			maximumSelectionLength	: 1
		});
	});

	$(document).on('click','.delete-item', function()
	{
		value = $(this).parent('td').parent('tr').find('.idEmployee').val();
		del = $('<input type="hidden" name="delete[]">').val(value);
		$('#delete').append(del);
		$(this).parents('tr').remove();
		tempCount = $('#banks-body tr').length;
		if(tempCount==0)
		{
			$('.full-table.options').hide();
			$('.profile-no-accounts').show();
		}
	})
	.on('click','#add',function()
	{
		$('.full-table.options').show();
		$('.profile-no-accounts').hide();
		card		= $(this).parents('tr').find('.card').val();
		clabe		= $(this).parents('tr').find('.clabe').val();
		account		= $(this).parents('tr').find('.account').val();
		bank		= $(this).parents('tr').find('.bank').val();
		alias		= $(this).parents('tr').find('.alias').val();
		bankName	= $(this).parents('tr').find('.bank :selected').text();
		if(bank.length>0)
		{
			if (card == "" && clabe == "" && account == "")
			{
				$('.card, .clabe, .account').addClass('error');
				swal('', 'Debe ingresar al menos un número de tarjeta, clabe o cuenta bancaria', 'error');
			}
			else if($(this).parents('tr').find('.card').hasClass('error') || $(this).parents('tr').find('.clabe').hasClass('error') || $(this).parents('tr').find('.account').hasClass('error'))
			{
				swal('', 'Por favor ingrese datos correctos', 'error');
			}
			else
			{
				banks = $('<tr></tr>')
						.append($('<td></td>')
							.append(bankName)
							.append($('<input type="hidden" class="idEmployee" name="idEmployee[]" value="x">'))
							.append($('<input type="hidden" name="bank[]" value="'+bank+'">'))
							)
						.append($('<td></td>')
							.append(alias =='' ? '-------------------------' :alias)
							.append($('<input type="hidden" name="alias[]" value="'+alias+'">'))
							)
						.append($('<td></td>')
							.append(card =='' ? '-------------------------' :card)
							.append($('<input type="hidden" name="card[]" value="'+card+'">'))
							)
						.append($('<td></td>')
							.append(clabe =='' ? '-------------------------' :clabe)
							.append($('<input type="hidden" name="clabe[]" value="'+clabe+'">'))
							)
						.append($('<td></td>')
							.append(account =='' ? '-------------------------' :account)
							.append($('<input type="hidden" name="account[]" value="'+account+'">'))
							)
						.append($('<td></td>')
							.append($('<button class="delete-item" type="button"><span class="icon-x delete-span"></span></button>'))
							);
				$('#banks-body').append(banks);
				$('.card, .clabe, .account,.alias').removeClass('valid').val('');
				$('.bank').val(0).trigger("change");
			}
		}
		else
		{
			swal('', 'Seleccione un banco, por favor', 'error');
			$('.bank').addClass('error');
		}
	});
</script>
@if(isset($alert))
	<script type="text/javascript">
		{!! $alert !!}
	</script>
@endif
@endsection
