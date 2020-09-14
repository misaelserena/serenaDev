@extends('layouts.child_module')
@section('data')

	{!! Form::open(['route' => 'labels.store', 'method' => 'POST', 'id' => 'container-alta']) !!}


	<div class="container-blocks" id="container-data">
		<table>
			<tbody>
			<tr>
				<td style="width: 63%;">
					<p>
						<label class="label-form">Descripción</label>
						<input type="text" name="description" class="input-text label" data-validation="server" data-validation-url="{{ url('configuration/labels/validate') }}">
					</p> 
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<center>
		<p>
			<button class="add2 input-extrasmall4" type="button" name="add" id="add"><div class="btn_plus">+</div> Agregar</button>
		</p>
	</center>
	<div class="table-responsive">
		<table class="table-no-bordered">
		<thead>
			<tr>
				<th width="50%">Etiqueta</th>
				<th width="50%">Acción</th>
			</tr>
		</thead>
		<tbody id="body">
		</tbody>
	</table>
	</div>
	
		
	<div class="form-container">
		<input type="submit" name="enviar" value="CREAR ETIQUETA" class="btn btn-red">
		<input type="reset" name="borrar" value="Borrar campos" class="btn btn-delete-form">
	</div>
    {!! Form::close() !!}


@endsection

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
		modules		: 'security',
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
				swal('', 'Agregar minimo una etiqueta', 'error');
				return false;
			}
		}
	});
	$(document).ready(function() {
		$('.account').numeric(false);
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
		.on('click','#add',function()
		{
			label  	= $('.label').val();
			error 	= $('.label').hasClass('error');
			valid 	= $('.label').hasClass('valid');
			if (label == "")
			{
				if (label == "") 
				{
					$('input[name="description"]').addClass('error');
				} 
				swal('', 'Favor de llenar el campo necesario', 'error');
			}
			else if (error)
			{
				swal('', 'La etiqueta ya existe', 'error');
			}
			else if (valid)
			{
				if ($('#body tr').length == 0) 
				{
					labels = $('<tr></tr>')
									.append($('<td></td>')
										.append(label)
												.append($('<input type="hidden" name="description[]">').val(label)
													))
									.append($('<td></td>')
										.append($('<p></p>')
											.append($('<button type="button" class="delete-item"></button>')
												.append($('<span class="icon-x delete-span"></span>'))
													)));
									$('#body').append(labels);

									$('.label').val('');
									$('.label').removeClass('error');
									$('.label').removeClass('valid');
				}
				else
				{
					yes = 0;
					$('#body tr').each(function()
					{
						exist = $(this).find("td").text();
						if (label == exist) 
						{
							yes++;
						}
					});
					if (yes == 0) 
					{
						labels = $('<tr></tr>')
										.append($('<td></td>')
											.append(label)
													.append($('<input type="hidden" name="description[]">').val(label)
														))
										.append($('<td></td>')
											.append($('<p></p>')
												.append($('<button type="button" class="delete-item"></button>')
													.append($('<span class="icon-x delete-span"></span>'))
														)));
										$('#body').append(labels);

										$('.label').val('');
										$('.label').removeClass('error');
										$('.label').removeClass('valid');
					}
					else
					{
						swal('', 'Ya ha agregado esta etiqueta en la lista', 'error');
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
		})
	});
</script>
@endsection

