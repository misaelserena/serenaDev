@extends('layouts.child_module')
@section('data')
	{!! Form::open(['route'	=> 'account.store', 'method' => 'POST', 'id' => 'container-alta']) !!}
	
	<div class="container-blocks" id="container-data">
			<div class="search-table-center">
				<div class="search-table-center-row">
					<p>
						<select class="js-enterprises removeselect" name="enterprise_id" multiple="multiple" id="multiple-enterprises select2-selection--multiple" style="width: 98%; max-width: 150px;">
							@foreach(App\Enterprise::orderName()->get() as $enterprise)
								<option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
							@endforeach
						</select><br>
					</p>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form" >Número de cuenta</label>
					</div>
					<div class="right">
						<p>
							<input type="text" class="input-text-large account" name="account" placeholder="Número de cuenta" data-validation="server" data-validation-url="{{ url('configuration/account/validate') }}" data-validation-req-params="{{ json_encode(array('enterprise_id'=>0)) }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Cuenta</label>
					</div>
					<div class="right">
						<p>
							<textarea class="input-text-large description" name="description" id="description" placeholder="Nombre de la cuenta" rows="3"></textarea>						
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Tipo de Gasto</label>
					</div>
					<div class="right">
						<p>
							<textarea class="input-text-large content" name="content" id="content" placeholder="Ej. Gasto de Venta" rows="3"></textarea>						
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Saldo</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="balance" id="balance" placeholder="$0.00" class="input-text-large">					
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<p>
						<label class="label-form">Visible</label><br><br>
						<input type="radio" name="visible" id="novisible" value="0">
						<label for="novisible">No</label> 
						<input type="radio" name="visible" id="visible" value="1">
						<label for="visible">Sí</label>
						<br><br>
					</p>
				</div>
		</div>
	</div>
		<center>
			<p>
				<button class="add2 input-extrasmall4" type="button" name="add" id="add"><div class="btn_plus">+</div> Agregar</button>
			</p>
		</center>
	<br><br>
	
	<div class="table-responsive">
		<table class="table-no-bordered" id="table-show" style="display: none;">
			<thead>
				<tr>
					<th width="20%">Empresa</th>
					<th width="20%">Número de cuenta</th>
					<th width="20%">Cuenta</th>
					<th width="20%">Tipo de gasto</th>
					<th width="20%">Saldo</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tbody id="body">
			</tbody>
		</table>
	</div>
	<div class="form-container">
		<input type="submit" name="enviar" value="CREAR CUENTA(S)" class="btn btn-red">
		<input type="reset" name="borrar" value="Borrar campos" class="btn btn-delete-form">
	</div>

	{!! Form::close() !!}
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript">
	$.ajaxSetup(
	{
		headers:
		{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.validate(
	{
		modules: 'security',
		form: '#container-alta',
		onSuccess : function($form)
		{
			
			cuentas	= $('#body tr').length;
			if(cuentas>0)
			{
				return true;
			}
			else
			{	
				swal('', 'Agregar minimo una cuenta', 'error');
				return false;
			}
		}
	});
	$(document).ready(function() {

		$('input[name="balance"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});

		$('.js-enterprises').select2({
			placeholder: 'Seleccione la Empresa',
			language: "es",
			maximumSelectionLength: 1
		});
		$('.account').numeric({ negative : false, decimal : false });
		$(document).on('click','.btn-delete-form',function(e)
		{
			e.preventDefault();
			form = $(this).parents('form');
			swal({
				title		: "Limpiar formulario",
				text		: "¿Confirma que desea limpiar el formulario?",
				icon		: "warning",
				buttons		: true,
				dangerMode	: true,
			})
			.then((willClean) =>
			{
				if(willClean)
				{
					$('#body').html('');
					$('.removeselect').val(null).trigger('change');
					form[0].reset();
				}
				else
				{
					swal.close();
				}
			});
		})
		.on('change','.js-enterprises',function()
		{
			enterpriseid = $('select[name="enterprise_id"] option:selected').val();
			$('input[name="account"]').attr('data-validation-req-params','{"enterprise_id":'+enterpriseid+'}').val('');
		})
		.on('click','#add',function()
		{
			account  	= $('.account').val();
			accError 	= $('.account').hasClass('error');
			accValid 	= $('.account').hasClass('valid');
			balance 	= $('#balance').val();
			description = $('textarea[id="description"]').val();
			content 	= $('textarea[id="content"]').val();
			enterprise 	= $('select[name="enterprise_id"] option:selected').text();
			identerprise = $('select[name="enterprise_id"] option:selected').val();
			selectable  = $('input[name="visible"]:checked').val();
			if (account == "" || description == "" || balance == "" || enterprise == "" || selectable == null)
			{
				if (account == "") 
				{
					$('input[name="acc"]').addClass('error');
				}
				if (balance == "") 
				{
					$('#balance').addClass('error');
				} 
				if(description == "")
				{
					$('textarea[id="description"]').addClass('error');
				}
				swal('', 'Favor de llenar los campos necesarios', 'error');
			}
			else if(accError)
			{
				swal('', 'El número de cuenta ya existe', 'error');
			}
			else if(accValid)
			{
				if ($('#body tr').length == 0) 
				{
					accounts = $('<tr></tr>')
						.append($('<td></td>')
							.append(enterprise)
								.append($('<input type="hidden" name="idEnterprise[]" class="input-text" data-validation="required" placeholder="Nombre">').val(identerprise)
									))
						.append($('<td></td>')
							.append(account)
								.append($('<input type="hidden" name="account[]" class="input-text" data-validation="required" placeholder="Nombre">').val(account)
										))
						.append($('<td></td>')
							.append(description)
								.append($('<input type="hidden" name="description[]" class="input-text" data-validation="required" placeholder="Detalles">').val(description)
										))
						.append($('<td></td>')
							.append(content)
								.append($('<input type="hidden" name="content[]" class="input-text" placeholder="Detalles">').val(content)
										))
						.append($('<td></td>')
							.append(balance)
								.append($('<input type="hidden" name="balance[]" class="input-text">').val(balance)
									)
								.append($('<input type="hidden" name="selectable[]" class="input-text">').val(selectable)
									))
						.append($('<td></td>')
							.append($('<p></p>')
								.append($('<button type="button" class="delete-item"></button>')
									.append($('<span class="icon-x delete-span"></span>'))
										)));
						$('#body').append(accounts);

						$('.account').val('');
						$('.account').removeClass('valid');
						$('.account').removeClass('error');
						$('#balance').removeClass('error');
						$('#balance').val('');
						$('.js-enterprises').val(null).trigger('change');
						$('textarea[id="description"]').val('');
						$('textarea[id="content"]').val('');
						cuentas	= $('#body tr').length;
						if (cuentas > 0) 
						{
							$('#table-show').show();
						}
				}
				else
				{
					yes = 0;
					$('#body tr').each(function()
					{
						exist = $(this).find("td:eq(1)").text();
						existE = $(this).find("td:eq(0)").text();
						console.log(exist);
						console.log(account);
						if (enterprise == existE && account == exist) 
						{
							yes++;
						}
					});
					if (yes == 0) 
					{
						accounts = $('<tr></tr>')
									.append($('<td></td>')
										.append(enterprise)
											.append($('<input type="hidden" name="idEnterprise[]" class="input-text" data-validation="required" placeholder="Nombre">').val(identerprise)
												))
									.append($('<td></td>')
										.append(account)
											.append($('<input type="hidden" name="account[]" class="input-text" data-validation="required" placeholder="Nombre">').val(account)
													))
									.append($('<td></td>')
										.append(description)
											.append($('<input type="hidden" name="description[]" class="input-text" data-validation="required" placeholder="Detalles">').val(description)
													))
									.append($('<td></td>')
										.append(content)
											.append($('<input type="hidden" name="content[]" class="input-text" placeholder="Detalles">').val(content)
													))
									.append($('<td></td>')
										.append(balance)
											.append($('<input type="hidden" name="balance[]" class="input-text">').val(balance)
												)
											.append($('<input type="hidden" name="selectable[]" class="input-text">').val(selectable)
												))
									.append($('<td></td>')
										.append($('<p></p>')
											.append($('<button type="button" class="delete-item"></button>')
												.append($('<span class="icon-x delete-span"></span>'))
													)));
									$('#body').append(accounts);

									$('.account').val('');
									$('.account').removeClass('valid');
									$('.account').removeClass('error');
									$('#balance').removeClass('error');
									$('#balance').val('');
									$('.js-enterprises').val(null).trigger('change');
									$('textarea[id="description"]').val('');
									$('textarea[id="content"]').val('');
									cuentas	= $('#body tr').length;
									if (cuentas > 0) 
									{
										$('#table-show').show();
									}
					}
					else
					{
						swal('', 'Ya ha agregado esta cuenta a la lista', 'error');
					}
				}
			}
			else
			{
				swal('', 'Espere a que se verifique el dato ingresado.', 'warning');
			}

		})
		.on('click','.delete-item', function() 
		{
			$(this).parents('tr').remove();
			cuentas	= $('#body tr').length;
			if (cuentas <= 0) 
			{
				$('#table-show').hide();
			}
		})
	});
</script>
@endsection