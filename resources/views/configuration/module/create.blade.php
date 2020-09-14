@extends('layouts.child_module')

@section('data')
	<!-- FORMULARIO ALTA -->
	@if(isset($module))
		{!! Form::open(['route' => ['configuration.module.update', $module->id], 'method' => 'PUT', 'class' => 'needs-validation','novalidate']) !!}
	@else
		{!! Form::open(['route' => 'configuration.module.store', 'method' => 'POST', 'class' => 'needs-validation','novalidate']) !!}
	@endif
		@csrf
		<div class="form-row">
			<div class="col-md-6 mb-3">
				<label for="name">Nombre</label>
				<input type="text" class="form-control" id="name" name="name" @if(isset($module)) value="{{ $module->name }}" @endif placeholder="Alta/Edición" data-validation="required">
			</div>
		</div>
		@if(!isset($module))
		<div class="form-row" id="modules">
			<div class="col-md-6 mb-3">
				<label for="module_answer_father">¿Es módulo padre?</label>
				<select class="form-control" id="module_answer_father" name="module_answer_father" multiple="multiple" data-validation="required">
					<option value="1">Sí</option>
					<option value="0">No</option>
				</select>
			</div>
			<div class="col-md-6 mb-3" id="select_module_father">
				<label for="module_father">Módulo padre</label>
				<select class="form-control" id="module_father" disabled="disabled" name="module_father" multiple="multiple" data-validation="required">
					@foreach(App\Module::where('father',null)->get() as $e)
						<option value="{{ $e->id }}" @if(isset($module) && $module->id == $e->id) selected="selected" @endif>{{ $e->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-6 mb-3">
				<label for="module_answer_child">¿Es módulo hijo del módulo padre seleccionado anteriormente?</label>
				<select class="form-control" id="module_answer_child" name="module_answer_child" multiple="multiple" data-validation="required">
					<option value="1">Sí</option>
					<option value="0">No</option>
				</select>
			</div>
			<div class="col-md-6 mb-3" id="select_module_child">
				<label for="module_child">Módulo hijo</label>
				<select class="form-control" id="module_child" disabled="disabled" name="module_child" multiple="multiple" data-validation="required">
					
				</select>
			</div>
		</div>
		@endif
		<div class="form-row">
			<div class="col-md-6 mb-3">
				<label for="cathegory">Categoria</label>
				<input type="text" class="form-control" id="cathegory" name="cathegory" @if(isset($module)) value="{{ $module->cathegory }}" @endif placeholder="Ventas">
			</div>
			<div class="col-md-6 mb-3">
				<label for="accion">Acción</label>
				<input type="text" class="form-control" id="accion" name="accion" @if(isset($module)) value="{{ $module->accion }}" @endif placeholder="Acción">
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-6 mb-3">
				<label for="details">Detalles</label>
				<input type="text" class="form-control" id="details" name="details" @if(isset($module)) value="{{ $module->details }}" @endif placeholder="Este modulo sirve para...">
			</div>
			<div class="col-md-6 mb-3">
				<label for="url">URL</label>
				<input type="text" class="form-control" id="url" name="url" @if(isset($module)) value="{{ $module->url }}" @endif placeholder="Ej. configuration/module/create" data-validation="required">
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-6 mb-3">
				<label for="order">Orden</label>
				<input type="text" class="form-control" id="order" name="order" placeholder="Ej. 1" data-validation="required" @if(isset($module)) value="{{ $module->order }}" @endif placeholder>
			</div>
			<div class="col-md-6 mb-3">
				¿Requiere permisos adicionales?: <br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" name="permissionRequire" type="radio" id="si" value="1" required="required" @if(isset($module) && $module->permissionRequire == "1") checked="checked" @endif>
					<label class="form-check-label" for="si">Sí</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" name="permissionRequire" type="radio" id="no" value="0" required="required" @if(isset($module) && $module->permissionRequire == "0") checked="checked" @endif>
					<label class="form-check-label" for="no">No</label>
				</div>
				<br>
			</div>
		</div>
		
		<br>
		<center>
			<button type="submit" class="btn btn-success">@if(isset($module)) GUARDAR CAMBIOS @else REGISTRAR @endif</button>
		</center>
	{!! Form::close() !!}
	<p><br></p>
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
	$.validate(
	{
		modules 	: 'file security',
		form		: '.needs-validation',
		language 	: 'es',
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
		$('[name="module_father"],[name="module_child"],[name="module_answer_father"],[name="module_answer_child"]').select2(
		{
			placeholder				: 'Seleccione uno',
			language				: "es",
			maximumSelectionLength	: 1
		});

		$(document).on('change','[name="module_answer_father"]',function()
		{
			isfahter = $(this).val();
			if (isfahter == 0) 
			{
				$('[name="module_father"]').prop('disabled',false);
			}
			else
			{
				$('[name="module_father"]').prop('disabled',true);
				$('[name="module_child"]').prop('disabled',true);
				$('[name="module_answer_child"]').prop('disabled',true);
			}
		})
		.on('change','[name="module_answer_child"]',function()
		{
			ischild = $(this).val();
			if (ischild == 0) 
			{
				$('[name="module_child"]').prop('disabled',false);
			}
			else
			{
				$('[name="module_child"]').prop('disabled',true);
			}
		})
		.on('change','[name="module_father"]',function()
		{
			$('[name="module_child"]').empty();
			idfather = $(this).val();
			if (idfather != "") 
			{
				swal({
					text: 'Cargando',
					html: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
					type: 'info',
					timer: 3000,
				  });
				$.ajax(
				{
					type 	: 'get',
					url 	: '{{ url("configuration/module/getchild") }}',
					data 	: {'idfather':idfather},
					success : function(data)
					{
						swal.close();
						$.each(data,function(i, d) {
							$('[name="module_child"]').append('<option value='+d.id+'>'+d.name+'</option>');
						});
					}
				});
			}
		})
	}); 	

</script>
@endsection
