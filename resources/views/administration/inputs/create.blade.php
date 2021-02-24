@extends('layouts.child_module')

@section('data')
	@if(isset($inputs))
		{!! Form::open(['route' => ['administration.inputs.update', $inputs->id], 'method' => 'PUT', 'class' => 'needs-validation','novalidate']) !!}
	@else
		{!! Form::open(['route' => 'administration.inputs.store', 'method' => 'POST', 'class' => 'needs-validation','novalidate']) !!}
	@endif
		@csrf
		<div class="card" id="form_search_create">
			<div class="card-header text-white bg-green">
				DATOS DE PRODUCTO
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<select class="form-control" id="provider_id" name="provider_id" multiple="multiple" data-validation="required">
							@foreach(App\Provider::where('status',1)->get() as $e)
								<option value="{{ $e->id }}" @if(isset($inputs) && $inputs->provider_id == $e->id) selected="selected" @endif>{{ $e->businessName }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-bars prefix"></i>
						<label class="label-form" for="description">Descripción</label>
						<input type="text" class="form-control" id="description" name="description" @if(isset($inputs)) value="{{ $inputs->description }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-calendar prefix"></i>
						<label class="label-form" for="date">Fecha de Ingreso</label>
						<input type="text" class="form-control" id="date" name="date" @if(isset($inputs)) value="{{ $inputs->date }}" @endif required>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-cubes prefix"></i>
						<label class="label-form" for="quantity">Cantidad a Ingresar</label>
						<input type="text" class="form-control" id="quantity" name="quantity" @if(isset($inputs)) value="{{ $inputs->quantity }}" @endif required>
					</div>
					<div class="col-md-6 mb-3"><br>
						<select class="form-control" id="unit" name="unit" multiple="multiple" data-validation="required">
							@foreach(App\CatMeasurementTypes::whereNotNull('type')->get() as $m_types)
								@foreach ($m_types->childrens()->orderBy('child_order','asc')->get() as $child)
									<option value="{{ $child->description }}"  @if(isset($inputs) && $child->description == $inputs->unit) selected="selected" @endif>{{ $child->description }}</option>			
								@endforeach
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-dollar-sign prefix"></i>
						<label class="label-form" for="price_purchase">Precio Compra</label>
						<input type="text" class="form-control" id="price_purchase" name="price_purchase" @if(isset($inputs)) value="{{ $inputs->price_purchase }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-dollar-sign prefix"></i>
						<label for="total">Total</label>
						<input type="text" class="form-control" id="total" name="total" @if(isset($inputs)) value="{{ $inputs->total }}" @endif required>
					</div>
				</div>
				<p><br></p>
				<center>
					<button type="submit" class="btn btn-success">@if(isset($inputs)) GUARDAR CAMBIOS @else REGISTRAR @endif</button>
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
		$(function() 
		{
			$("#date").datepicker({ dateFormat: "yy-mm-dd" });
		});
		$('[name="provider_id"]').select2(
		{
			placeholder				: 'Proveedor',
			language				: "es",
			maximumSelectionLength	: 1,
		});
		$('[name="unit"]').select2(
		{
			placeholder				: 'Unidad',
			language				: "es",
			maximumSelectionLength	: 1,
		});
		$('#code').numeric(false);
		$('#price,#wholesale_price,#quantity,#quantity_ex').numeric({ altDecimal: ".", decimalPlaces: 2 });
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
		.on('change','#quantity,#price_purchase',function()
		{
			quantity 		= $('#quantity').val();
			price_purchase 	= $('#price_purchase').val();

			total = quantity * price_purchase;

			$('#total').val(total).trigger('change');
		})
	}); 	

</script>
@endsection