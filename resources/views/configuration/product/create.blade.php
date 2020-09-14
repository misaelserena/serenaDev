@extends('layouts.child_module')

@section('data')
	@if(isset($product))
		{!! Form::open(['route' => ['configuration.product.update', $product->id], 'method' => 'PUT', 'class' => 'needs-validation','novalidate']) !!}
	@else
		{!! Form::open(['route' => 'configuration.product.store', 'method' => 'POST', 'class' => 'needs-validation','novalidate']) !!}
	@endif
		@csrf
		<div class="form-row">
			<div class="md-form col-md-6 mb-3">
				<i class="fas fa-hashtag prefix"></i>
				<label for="code">Código</label>
				<input type="text" class="form-control" id="code" name="code" @if(isset($product)) value="{{ $product->code }}" @endif required>
			</div>
			<div class="md-form col-md-6 mb-3">
				<i class="fas fa-align-justify prefix"></i>
				<label for="description">Descripcion</label>
				<input type="text" class="form-control" id="description" name="description" @if(isset($product)) value="{{ $product->description }}" @endif required>
			</div>
		</div>
		<div class="form-row">
			<div class="md-form col-md-6 mb-3">
				<i class="fas fa-cubes prefix"></i>
				<label for="net_content">Contenido Neto</label>
				<input type="text" class="form-control" id="net_content" name="net_content" @if(isset($product)) value="{{ $product->net_content }}" @endif required>
			</div>
			<div class="md-form col-md-6 mb-3">
				<i class="fas fa-cubes prefix"></i>
				<select class="form-control" id="unit" name="unit" multiple="multiple" data-validation="required">
					@foreach(App\CatMeasurementTypes::whereNotNull('type')->get() as $m_types)
						@foreach ($m_types->childrens()->orderBy('child_order','asc')->get() as $child)
							<option value="{{ $child->description }}"  @if(isset($product) && $child->description == $product->unit) selected="selected" @endif>{{ $child->description }}</option>			
						@endforeach
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-row">
			<div class="md-form col-md-6 mb-3">
				<i class="fas fa-dollar-sign prefix"></i>
				<label for="price">Precio</label>
				<input type="text" class="form-control" id="price" name="price" @if(isset($product)) value="{{ $product->price }}" @endif required>
			</div>
			<div class="md-form col-md-6 mb-3">
				<i class="fas fa-dollar-sign prefix"></i>
				<select class="form-control" id="provider_id" name="provider_id" multiple="multiple" data-validation="required">
					@foreach(App\Provider::where('status',1)->get() as $e)
						<option value="{{ $e->id }}" @if(isset($product) && $product->provider_id == $e->id) selected="selected" @endif>{{ $e->businessName }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-row">
			<div class="md-form col-md-6 mb-3">
				<i class="fas fa-cubes prefix"></i>
				<label for="min_wholesale_quantity">Cant. Minima Mayoreo</label>
				<input type="text" class="form-control" id="min_wholesale_quantity" name="min_wholesale_quantity" @if(isset($product)) value="{{ $product->min_wholesale_quantity }}" @endif required>
			</div>
			<div class="md-form col-md-6 mb-3">
				<i class="fas fa-dollar-sign prefix"></i>
				<label for="wholesale_price">Precio mayoreo</label>
				<input type="text" class="form-control" id="wholesale_price" name="wholesale_price" @if(isset($product)) value="{{ $product->wholesale_price }}" @endif required>
			</div>
		</div>
		<br>
		<center>
			<button type="submit" class="btn btn-success">@if(isset($product)) GUARDAR CAMBIOS @else REGISTRAR @endif</button>
		</center>
		<p><br></p>

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
		$('[name="unit"]').select2(
		{
			placeholder				: 'Unidad',
			language				: "es",
			maximumSelectionLength	: 1
		});
		$('[name="provider_id"]').select2(
		{
			placeholder				: 'Proveedor',
			language				: "es",
			maximumSelectionLength	: 1
		});
		$('#code,#price,#wholesale_price,#net_content,#min_wholesale_quantity').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false });
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