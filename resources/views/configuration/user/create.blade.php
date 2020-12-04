@extends('layouts.child_module')
@section('css')
	<style type="text/css">
		.all-select
		{
			display	: block;
			margin	: 0 0 0 auto;
		}
		.all-select.select:before
		{
			content: 'Seleccionar';
		}
		.all-select:before
		{
			content: 'Deseleccionar';
		}
		

	</style>
@endsection

@section('data')
	<!-- FORMULARIO ALTA -->
	@if(isset($user))
		{!! Form::open(['route' => ['configuration.user.update', $user->id], 'method' => 'PUT', 'class' => 'needs-validation','novalidate']) !!}
	@else
		{!! Form::open(['route' => 'configuration.user.store', 'method' => 'POST', 'class' => 'needs-validation','novalidate']) !!}
	@endif
		@csrf
		<div class="card" id="form_search_create">
			<div class="card-header text-white bg-green">
				DATOS DE USUARIO
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="name">Nombre</label>
						<input type="text" class="form-control" id="name" name="name" @if(isset($user)) value="{{ $user->name }}" @endif placeholder="Nombre" required>
					</div>
					<div class="col-md-6 mb-3">
						<label for="last_name">Apellido Paterno</label>
						<input type="text" class="form-control" id="last_name" name="last_name" @if(isset($user)) value="{{ $user->last_name }}" @endif placeholder="Apellido Paterno" required>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="scnd_last_name">Apellido Materno</label>
						<input type="text" class="form-control" id="scnd_last_name" name="scnd_last_name" @if(isset($user)) value="{{ $user->scnd_last_name }}" @endif placeholder="Apellido Materno">
					</div>
					<div class="col-md-6 mb-3">
						Seleccione el genero: <br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" name="gender" type="radio" id="hombre" value="hombre" required="required" @if(isset($user) && $user->gender == "hombre") checked="checked" @endif>
							<label class="form-check-label" for="hombre">Hombre</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" name="gender" type="radio" id="mujer" value="mujer" required="required" @if(isset($user) && $user->gender == "mujer") checked="checked" @endif>
							<label class="form-check-label" for="mujer">Mujer</label>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="phone">Teléfono (Opcional)</label>
						<input type="text" class="form-control" id="phone" name="phone" @if(isset($user)) value="{{ $user->phone }}" @endif placeholder="8165094">
					</div>
					<div class="col-md-6 mb-3">
						<label for="cell">Celular (Opcional)</label>
						<input type="text" class="form-control" id="cell" name="cell" @if(isset($user)) value="{{ $user->cell }}" @endif placeholder="2281909010">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="email">Correo Electrónico</label>
						<input type="email" class="form-control" id="email" name="email" @if(isset($user)) value="{{ $user->email }}" @endif placeholder="example@example.com" required>
					</div>
					<div class="col-md-6 mb-3">
						<label for="password">Contraseña</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="position">Puesto</label>
						<input type="text" class="form-control" id="position" name="position" @if(isset($user)) value="{{ $user->position }}" @endif placeholder="Director" required>
					</div>
					<div class="col-md-6 mb-3">
						<label for="enterprise">Empresa</label>
						<select class="form-control" id="enterprise" name="enterprise" multiple="multiple" data-validation="required">
							@foreach(App\Enterprise::where('status','ACTIVE')->get() as $e)
								<option value="{{ $e->id }}" @if(isset($user) && $user->enterprise_id == $e->id) selected="selected" @endif>{{ $e->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="department">Departamento</label>
						<select class="form-control" id="department" name="department" multiple="multiple" data-validation="required">
							@foreach(App\Departament::where('status','ACTIVE')->get() as $e)
								<option value="{{ $e->id }}" @if(isset($user) && $user->department_id == $e->id) selected="selected" @endif>{{ $e->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="area">Area</label>
						<select class="form-control" id="area" name="area" multiple="multiple" data-validation="required">
							@foreach(App\Area::where('status','ACTIVE')->get() as $e)
								<option value="{{ $e->id }}"@if(isset($user) && $user->area_id == $e->id) selected="selected" @endif>{{ $e->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<br>
				<center>
					<button type="submit" class="btn btn-success">@if(isset($user)) GUARDAR CAMBIOS @else REGISTRAR @endif</button>
				</center>
			</div>
		</div>
	{!! Form::close() !!}
	<p><br></p>
	@if(isset($user))
		<div id="view-permission" style="display: block;">
			<div class="form-container" style="display: block;">
				<div class="div-form-group full">
					<br><br>
					<center>
						<label class="label-form">-ACCESO A MÓDULOS-</label>
					</center>
				</div>
				<div class="div-form-group modules" style="display: block;">
					<label class="label-form">Módulos:</label>
					@php
						$accessMod = json_decode(json_encode($user->module->pluck('id')),true);
					@endphp
					{!! App\Http\Controllers\ConfigurationUsersController::build_modules(NULL,$accessMod) !!}
				</div>
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
									<th colspan="100%">{{ $moduleFather->name }} <input hidden type="checkbox" id="father_{{$moduleFather->id}}" value="{{$moduleFather->id}}" @if(in_array($moduleFather->id, $accessMod)) checked @endif></th>
								</tr>
							</thead>
							<tbody>
								@foreach(App\Module::where('father',$moduleFather->id)->get() as $admin)
									<tr>
										<th width="10%" style="font-weight: bolder;vertical-align: middle;">{{ $admin->name }} <input type="checkbox" hidden id="admin_{{$admin->id}}" value="{{$admin->id}}" @if(in_array($admin->id, $accessMod)) checked @endif data-father="father_{{$moduleFather->id}}"></th>
										@foreach(App\Module::where('father',$admin->id)->get() as $submodule)
											<td>
												<div class="module_title">{{ $submodule->name }}</div>
												<div class="module_buttons">
													<input name="module[]" class="newmodules" type="checkbox" hidden value="{{ $submodule->id }}" id="module_{{ $submodule->id }}" @if(in_array($submodule->id, $accessMod)) checked @endif data-father="admin_{{$admin->id}}">
													<label class="switch" style="vertical-align: middle;" for="module_{{ $submodule->id }}">
														<span class="slider round"></span>
													</label>
													@if($submodule->id != 127 && $submodule->id != 101)
														<button class="btn btn-info editModule" type="button" data-id="{{$submodule->id}}" @if(!in_array($submodule->id, $accessMod)) style="display: none;" @endif><svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#pencil") }}"></use></svg></button>
													@endif
												</div>
											</td>
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
							<h5 class="modal-title">Permisos</h5>
						</div>
						<div class='modal-body'>
							<button class="btn btn-success all-select select" type="button" data-target="js-enterprises-permission"> todas</button>
							<input type="hidden" id="idmodule">
							<p>
								<select class="js-enterprises-permission" name="enterpriseid" multiple="multiple" style="width: 98%; border: 0px;">
									@foreach(App\Enterprise::orderName()->where('status','ACTIVE')->get() as $enterprise)
										<option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
									@endforeach
								</select><br>
							</p>
							<br>
							<button class="btn btn-success all-select select" type="button" data-target="js-departments-permission"> todos</button>
							<p>
								<select class="js-departments-permission" class="input-text" multiple="multiple" name="departmentid" style="width: 98%;border: 0px;">
									@foreach(App\Departament::orderName()->where('status','ACTIVE')->get() as $department)
										<option value="{{ $department->id }}">{{ $department->name }}</option>
									@endforeach
								</select><br>
							</p>
							<center>
								<button class="btn btn-success" type="button" id="add_permission">Aceptar</button>
								<button class="btn btn-danger" type="button" data-dismiss="modal">Cerrar</button>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
@endsection
@section('scripts')
<script type="text/javascript">
	$.ajaxSetup(
	{
		headers:
		{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	(function() {
		'use strict';
		  	window.addEventListener('load', function() {
			var forms = document.getElementsByClassName('needs-validation');
			var validation = Array.prototype.filter.call(forms, function(form) {
			  	form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) 
					{
					 	event.preventDefault();
					  	event.stopPropagation();
					}
					form.classList.add('was-validated');
			  	}, false);
			});
		}, false);
	})();
	$(document).ready(function()
	{
		$('[name="enterprise"],[name="department"],[name="area"]').select2(
		{
			placeholder				: 'Seleccione uno',
			language				: "es",
			maximumSelectionLength	: 1
		});
		$('#cell,#phone').numeric(false);
		$(document).on('click','[data-dismiss="modal"]',function()
		{
			$('.js-enterprises-permission').val(null).trigger('change');
			$('.js-departments-permission').val(null).trigger('change');
			$('.all-select').addClass('select');
			$('#idmodule').val('');
			$('#myModal').hide();
		})
		.on('change','input[type="checkbox"]',function()
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
		})
		@if (isset($user))
			.on('change','input[type="checkbox"].newmodules',function()
			{
				checkBox	= $(this);
				id			= $(this).val();
				if (id != 127 && id != 101)
				{
					if(checkBox.is(':checked'))
					{
						$('#idmodule').val(id);
						checkBox.prop('checked',false);
						$('#myModal').show();
						$('.js-enterprises-permission').select2(
						{
							placeholder				: 'Seleccione una o varias empresas',
							language				: "es"
						});
						$('.js-departments-permission').select2(
						{
							placeholder				: 'Seleccione uno o varios departamentos',
							language				: "es"
						});
					}
					else
					{
						swal({
							title		: "Confirme que desea continuar",
							text		: "Esta acción eliminará el acceso del usuario al módulo, ¿desea continuar?",
							icon		: "warning",
							buttons		:
							{
								cancel:
								{
									text		: "Cancelar",
									value		: null,
									visible		: true,
									closeModal	: true,
								},
								confirm:
								{
									text		: "Eliminar",
									value		: true,
									closeModal	: false
								}
							},
							dangerMode	: true,
						})
						.then((willDelete) =>
						{
							if (willDelete)
							{
								father	= checkBox.attr('data-father');
								if($('[data-father="'+father+'"]:checked').length>0)
								{
									$('#'+father).prop('checked',true);
								}
								else
								{
									$('#'+father).prop('checked',false);
								}
								father2	= $('#'+father).attr('data-father');
								if($('[data-father="'+father2+'"]:checked').length>0)
								{
									$('#'+father2).prop('checked',true);
								}
								else
								{
									$('#'+father2).prop('checked',false);
								}
								additional	= [];
								if(!$('#'+father).is(':checked'))
								{
									additional.push($('#'+father).val());
								}
								if(!$('#'+father2).is(':checked'))
								{
									additional.push($('#'+father2).val());
								}
								$.ajax(
								{
									type	: 'post',
									url		: '{{ route('configuration.user.module.permission.update') }}',
									data	: {'module' : id, 'user': {{$user->id}},'action':'off','additional':additional },
									success	:function(data)
									{
										if(data == 'DONE')
										{
											checkBox.siblings('.btn-info.editModule').hide();
											swal.close();
										}
									}
								});
							}
							else
							{
								checkBox.prop('checked',true);
							}
						});
					}
				}
				else
				{
					swal({
						icon				: '{{ url('images/load.gif') }}',
						button				: false,
						closeOnClickOutside	: false,
						closeOnEsc			: false,
					});
					if(checkBox.is(':checked'))
					{
						action = 'on';
					}
					else
					{
						action = 'off'
					}
					$.ajax(
					{
						type	: 'post',
						url		: '{{ route('configuration.user.module.permission.update') }}',
						data	: {'module' : id, 'user': {{$user->id}},'action':action },
						success	:function(data)
						{
							if(data == 'DONE')
							{
								swal.close();
							}
						}
					});
				}
			})
			.on('click','.editModule',function()
			{
				id = $(this).attr('data-id');
				if($(this).siblings('[name="module[]"]').is(':checked'))
				{
					swal({
						icon				: '{{ url('images/load.gif') }}',
						button				: false,
						closeOnClickOutside	: false,
						closeOnEsc			: false,
					});
					$.ajax(
					{
						type	: 'post',
						url		: '{{ route('configuration.user.module.permission') }}',
						data	: {'module' : id, 'user': {{$user->id}} },
						success	:function(data)
						{
							$('#idmodule').val(id);
							$('.js-enterprises-permission').val(data.enterprise);
							$('.js-departments-permission').val(data.department);
							$('#myModal').show();
							$('.js-enterprises-permission').select2(
							{
								placeholder				: 'Seleccione una o varias empresas',
								language				: "es"
							});
							$('.js-departments-permission').select2(
							{
								placeholder				: 'Seleccione uno o varios departamentos',
								language				: "es"
							});
							swal.close();
						}
					});
				}
			})
			.on('click','#add_permission',function()
			{
				if($('.js-enterprises-permission').val() != '' && $('.js-departments-permission').val() != '')
				{
					id = $('#idmodule').val();
					swal({
						icon				: '{{ url('images/load.gif') }}',
						button				: false,
						closeOnClickOutside	: false,
						closeOnEsc			: false,
					});
					father		= $('#module_'+id).attr('data-father');
					father2		= $('#'+father).attr('data-father');
					additional	= [];
					additional.push($('#'+father).val());
					additional.push($('#'+father2).val());
					$.ajax(
					{
						type	: 'post',
						url		: '{{ route('configuration.user.module.permission.update') }}',
						data	: {'module' : id, 'user': {{$user->id}},'action':'on','enterprise': $('.js-enterprises-permission').val(),'department':$('.js-departments-permission').val(),'additional':additional},
						success	:function(data)
						{
							if(data == 'DONE')
							{
								$('#module_'+id).prop('checked',true);
								$('#module_'+id).siblings('.btn-info.editModule').show();
								$('.js-enterprises-permission').val(null).trigger('change');
								$('.js-departments-permission').val(null).trigger('change');
								$('.all-select').addClass('select');
								$('#idmodule').val('');
								$('#myModal').hide();
								$('#'+father).prop('checked',true);
								$('#'+father2).prop('checked',true);
								swal.close();
							}
						}
					});
				}
				else
				{
					swal('','Debe seleccionar al menos una empresa y un departamento','error');
				}
			})
			.on('change','[name="moduleCheck[]"]',function()
			{
				swal({
					icon				: '{{ url('images/load.gif') }}',
					button				: false,
					closeOnClickOutside	: false,
					closeOnEsc			: false,
				});
				modules = [];
				$('[name="moduleCheck[]"]:checked').each(function(i,v)
				{
					modules.push($(this).val());
				});
				$.ajax(
				{
					type	: 'post',
					url		: '{{ route('configuration.user.module.permission.update.simple') }}',
					data	: {'modules' : modules, 'user': {{$user->id}} },
					success	:function(data)
					{
						if(data == 'DONE')
						{
							swal.close();
						}
					}
				});
			})
			.on('click','.all-select',function()
			{
				target	= '.'+$(this).attr('data-target');
				if($(this).hasClass('select'))
				{
					$(this).removeClass('select');
					$(target+' option').each(function(i,v)
					{
						$(this).prop('selected',true);
						$(target).trigger('change');
					});
				}
				else
				{
					$(this).addClass('select');
					$(target+' option').each(function(i,v)
					{
						$(this).prop('selected',false);
						$(target).trigger('change');
					});
				}
			});

		@endif

		function getEntDep($value)
		{	
			$.ajax(
			{
				type : 'get',
				url  : '{{ url("configuration/user/getentdep") }}',
				data : {'module_id':$value},
				success:function(data)
				{
					$('.module_'+$value).append(data);
				}
			});
		}
	}); 	

</script>
@endsection
