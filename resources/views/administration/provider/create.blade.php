@extends('layouts.child_module')

@section('data')
	@if(isset($provider))
		{!! Form::open(['route' => ['administration.provider.update', $provider->id], 'method' => 'PUT', 'class' => 'needs-validation','novalidate']) !!}
	@else
		{!! Form::open(['route' => 'administration.provider.store', 'method' => 'POST', 'class' => 'needs-validation','novalidate']) !!}
	@endif
		@csrf
		<div class="card" id="form_search_create">
			<div class="card-header text-white bg-green">
				DATOS DE PROVEEDOR
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-user prefix"></i>
						<label  for="businessName">Nombre</label>
						<input type="text" class="form-control" id="businessName" name="businessName" @if(isset($provider)) value="{{ $provider->businessName }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-phone prefix"></i>
						<label  for="phone">Télefono</label>
						<input type="text" class="form-control" id="phone" name="phone" @if(isset($provider)) value="{{ $provider->phone }}" @endif required>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-user prefix"></i>
						<label  for="rfc">RFC</label>
						<input type="text" class="form-control" id="rfc" name="rfc" @if(isset($provider)) value="{{ $provider->rfc }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-address-card prefix"></i>
						<label  for="address">Dirección</label>
						<input type="text" class="form-control" id="address" name="address" @if(isset($provider)) value="{{ $provider->address }}" @endif required>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-hashtag prefix"></i>
						<label  for="number">Número</label>
						<input type="text" class="form-control" id="number" name="number" @if(isset($provider)) value="{{ $provider->number }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-building prefix"></i>
						<label  for="colony">Colonia</label>
						<input type="text" class="form-control" id="colony" name="colony" @if(isset($provider)) value="{{ $provider->colony }}" @endif required>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-mail-bulk prefix"></i>
						<label  for="postalCode">Código Postal</label>
						<input type="text" class="form-control" id="postalCode" name="postalCode" @if(isset($provider)) value="{{ $provider->postalCode }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-city prefix"></i>
						<label  for="city">Ciudad</label>
						<input type="text" class="form-control" id="city" name="city" @if(isset($provider)) value="{{ $provider->city }}" @endif required>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label class="label-form" for="code">Estado</label>
						<select class="form-control" id="state_idstate" name="state_idstate" multiple="multiple" data-validation="required">
							@foreach(App\State::orderName()->get() as $state)
								<option value="{{ $state->idstate }}" @if(isset($provider) && $provider->state_idstate ==$state->idstate) selected="selected" @endif>{{ $state->description }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<p><br></p>
				<center>
					<button type="submit" class="btn btn-success">@if(isset($provider)) GUARDAR CAMBIOS @else REGISTRAR @endif</button>
				</center>
			</div>
		</div>
		<P><br></P>
	{!! Form::close() !!}
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
		$('[name="state_idstate"]').select2(
		{
			placeholder				: 'Seleccione uno',
			language				: "es",
			maximumSelectionLength	: 1,
		});
		$('#code').numeric(false);
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

	}); 	

</script>
@endsection