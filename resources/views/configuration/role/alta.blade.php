@extends('layouts.child_module')

@section('data')
	<!-- FORMULARIO ALTA -->
	{!! Form::open(['route' => 'role.store', 'method' => 'POST', 'id' => 'container-alta']) !!}
		<div class="container-blocks" id="container-data">
			<div class="div-form-group">
				<label class="label-form">Nombre del rol</label>
				<p><input type="text" name="name" class="input-text" data-validation="required server" placeholder="Nombre" data-validation-url="{{ url('configuration/role/validate') }}"></p>
				<br><br>
			</div>
			<div class="div-form-group">
				<label class="label-form">Descripción del rol</label>
				<p><textarea name="details" class="input-text" data-validation="required" placeholder="Descripción"></textarea></p>
			</div>
		</div>
		<div class="form-container">
			<div class="div-form-group full">
				<br><br>
				<center>
					<label class="label-form">-ACCESO A MÓDULOS-</label>
				</center>
			</div>
			<div class="div-form-group modules">
				<label class="label-form">Módulos:</label>
			{!! App\Http\Controllers\ConfiguracionRolController::build_modules(NULL) !!}
			</div>
			<br><br>
		</div>
		<div class="form-container">
			<div class="div-form-group full">
				<br><br>
				<center>
					<label class="label-form">-ACCESO A MÓDULOS ESPECIFICOS-</label>
				</center>
			</div>
			@foreach(App\Module::where('father',null)->where('permissionRequire',1)->get() as $moduleFather)
			<div class="table-responsive">
				<table class="table-permission">
					<thead>
						<tr>
							<th colspan="100%">{{ $moduleFather->name }}</th>
						</tr>
					</thead>
					<tbody id="body-admin">
						@foreach(App\Module::where('father',$moduleFather->id)->get() as $admin)
							<tr>
								<th width="10%" style="font-weight: bolder;vertical-align: middle;">{{ $admin->name }}</th>
								@foreach(App\Module::where('father',$admin->id)->get() as $submodule)
									<td>{{ $submodule->name }}<br><br><input name="module[]" class="newmodules" type="checkbox" hidden value="{{ $submodule->id }}" id="module_{{ $submodule->id }}"><label class="switch" style="vertical-align: middle;" for="module_{{ $submodule->id }}"><span class="slider round"></span></label> <span class="module_{{ $submodule->id }}"></span></td>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<br><br><br>
			@endforeach
			<div id="myModal" class="modal">
				<div class='modal-content-permission'>
					<div class='modal-header'>
					</div>
					<div class='modal-body'>
						<input type="hidden" id="idmodule">
						<p>
							<select class="js-enterprises" name="enterpriseid" multiple="multiple" style="width: 98%; border: 0px;">
								@foreach(App\Enterprise::orderName()->where('status','ACTIVE')->get() as $enterprise)
									<option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
								@endforeach
							</select><br>
						</p>
						<br>
						<p>
							<select class="js-departments" class="input-text" multiple="multiple" name="departmentid" style="width: 98%;border: 0px;">
								@foreach(App\Departament::orderName()->where('status','ACTIVE')->get() as $department)
									<option value="{{ $department->id }}">{{ $department->name }}</option>
								@endforeach
							</select><br>
						</p>
						<center>
							<button class="add2 addpermission" type="button" name="add" id="add"><div class="btn_plus">+</div> Agregar permisos</button>
							<button class="btn exitAddPermission" type="button">Cerrar</button>
							<button class="add2 updatepermission" type="button" name="add" id="add" style="display: none;"><div class="btn_plus">+</div> Actualizar permisos</button>
							<button class="btn exitUpdatePermission" style="display: none;" type="button">Cerrar</button>
						</center>
					</div>
				</div>
			</div>
		</div>
		<div class="form-container">
			<input class="btn btn-red" type="submit" name="enviar" value="CREAR ROL"> 
			<input class="btn btn-delete-form" type="reset" name="borrar" value="Borrar campos">
		</div>
		<br>
	{!! Form::close() !!}
@endsection
@section('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
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
	});
	$('.modules').show();
	$('.js-enterprises').select2(
	{
		placeholder				: 'Seleccione una o varias empresas',
		language				: "es"
	});
	$('.js-departments').select2(
	{
		placeholder				: 'Seleccione uno o varios departamentos',
		language				: "es"
	});
	$(document).on('change','input[type="checkbox"]',function()
	{
		if(this.checked)
		{
			$(this).parents('li').children('input[type="checkbox"]').prop('checked',true);

		}
		var checked = $(this).prop("checked"),
			father = $(this).parent();

			father.find('input[type="checkbox"]').prop({
				checked: checked
			});

			function checkSiblings(check)
			{
				var parent = check.parent().parent(),
					all = true;

				check.siblings().each(function() 
				{
					return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
				});

				if (all && checked) 
				{
					$(this).parents('li').children('input[type="checkbox"]').prop('checked',true);
					parent.children('input[type="checkbox"]').prop({
						checked: checked
					});
					checkSiblings(parent);
				}
				else if(all && !checked)
				{
					parent.children('input[type="checkbox"]').prop("checked",checked);
					parent.children('input[type="checkbox"]').prop((parent.find('input[type="checkbox"]').length < 0));
					checkSiblings(parent);
				}
				else
				{
					check.parent("li").children('input[type="checkbox"]').prop('checked',false);
				}
			} 
			checkSiblings(father);
	})
	.on('change','input[type="checkbox"].newmodules',function()
	{
		if ($(this).val() != 127 && $(this).val() != 101 && $(this).val() != 30 && $(this).val() != 31 && $(this).val() != 49 && $(this).val() != 50) 
		{
			if ($(this).is(':checked')) 
			{
				$('#idmodule').val($(this).val());
				$('#myModal').show();
				$('.addpermission,.exitAddPermission').show();
				$('.exitUpdatePermission,.updatepermission').hide();
				$('.js-enterprises').select2(
				{
					placeholder				: 'Seleccione una o varias empresas',
					language				: "es"
				});
				$('.js-departments').select2(
				{
					placeholder				: 'Seleccione uno o varios departamentos',
					language				: "es"
				});
			}
			else
			{
				idmodule = 'module_'+$(this).val();
				$('#body-admin tr').find('.'+idmodule).empty();
				$('.addpermission,.exitAddPermission').show();
				$('.exitUpdatePermission,.updatepermission').hide();
			}
		}
		
	})
	.on('click','.exitAddPermission',function()
	{
		$('#myModal').hide();
		idmodule = 'module_'+$('#idmodule').val();
		$('#body-admin tr').find('#'+idmodule).prop('checked',false);	
		$('.js-enterprises,.js-departments').val(null).trigger('change');
	})
	.on('click','.exitUpdatePermission',function()
	{
		$('.js-enterprises,.js-departments').val(null).trigger('change');
		$('#myModal').hide();
	})
	.on('click','.addpermission',function()
	{
		if ($('.js-enterprises option:selected').length>0 && $('.js-departments option:selected').length>0) 
		{
			idmodule = 'module_'+$('#idmodule').val();

			btn 	= $('<button class="follow-btn editModule" type="button"><span class="icon-pencil"></span></button>');

			enterprises = $('<span></span>');
			$('.js-enterprises option:selected').each(function()
			{
				enterprises.append($('<input type="hidden" class="enterprises" name="enterprises_'+idmodule+'[]" value="'+$(this).val()+'">'));
			});

			departments= $('<span></span>');
			$('.js-departments option:selected').each(function()
			{
				departments.append($('<input type="hidden" class="departments" name="departments_'+idmodule+'[]" value="'+$(this).val()+'">'));
			});

			$('#body-admin tr').find('.'+idmodule).append(btn);
			$('#body-admin tr').find('.'+idmodule).append(enterprises);
			$('#body-admin tr').find('.'+idmodule).append(departments);
			$('.js-enterprises,.js-departments').val(null).trigger('change');
			$('#myModal').hide();
		}
		else
		{
			swal('', 'Debe seleccionar al menos una empresa y un departamento.', 'error');
		}

	})
	.on('click','.updatepermission',function()
	{
		if ($('.js-enterprises option:selected').length>0 && $('.js-departments option:selected').length>0) 
		{
			idmodule = 'module_'+$('#idmodule').val();
			$('#body-admin tr').find('.'+idmodule).empty();

			btn 	= $('<button class="follow-btn editModule" type="button"><span class="icon-pencil"></span></button>');

			enterprises = $('<span></span>');
			$('.js-enterprises option:selected').each(function()
			{
				enterprises.append($('<input type="hidden" class="enterprises" name="enterprises_'+idmodule+'[]" value="'+$(this).val()+'">'));
			});

			departments= $('<span></span>');
			$('.js-departments option:selected').each(function()
			{
				departments.append($('<input type="hidden" class="departments" name="departments_'+idmodule+'[]" value="'+$(this).val()+'">'));
			});

			$('#body-admin tr').find('.'+idmodule).append(btn);
			$('#body-admin tr').find('.'+idmodule).append(enterprises);
			$('#body-admin tr').find('.'+idmodule).append(departments);
			$('.js-enterprises,.js-departments').val(null).trigger('change');
			$('#myModal').hide();
		}
		else
		{
			swal('', 'Debe seleccionar al menos una empresa y un departamento.', 'error');
		}
	})
	.on('click','.editModule',function()
	{
		$('.js-enterprises,.js-departments').val(null).trigger('change');
		$('.addpermission,.exitAddPermission').hide();
		$('.exitUpdatePermission,.updatepermission').show();
		arrayEnterprises = [];
		arrayDepartments = [];
		$('#idmodule').val($(this).parents('td').find('.newmodules').val());
		$('.js-enterprises').select2(
		{
			placeholder				: 'Seleccione una o varias empresas',
			language				: "es"
		});
		$('.js-departments').select2(
		{
			placeholder				: 'Seleccione uno o varios departamentos',
			language				: "es"
		});
		$(this).parents('td').find('.enterprises').each(function()
		{
			arrayEnterprises.push($(this).val());
		});
		$(this).parents('td').find('.departments').each(function()
		{
			arrayDepartments.push($(this).val());
		});
		$('.js-enterprises').val(arrayEnterprises).trigger('change');
		$('.js-departments').val(arrayDepartments).trigger('change');
		$('#myModal').show();
	})
	.on('click','.btn-delete-form',function(e)
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
	});
</script>
@endsection