@extends('layouts.child_module')

@section('data')
	@if(isset($warehouse))
		{!! Form::open(['route' => ['administration.warehouse.update', $warehouse->id], 'method' => 'PUT', 'class' => 'needs-validation','novalidate']) !!}
	@else
		{!! Form::open(['route' => 'administration.warehouse.store', 'method' => 'POST', 'class' => 'needs-validation','novalidate']) !!}
	@endif
		@csrf
		<div class="card" id="form_search_create">
			<div class="card-header text-white bg-green">
				DATOS DE PRODUCTO
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-cubes prefix"></i>
						<label class="label-form" for="product">Cantidad a Ingresar</label>
						<input type="text" class="form-control" id="product" name="product" @if(isset($warehouse)) value="{{ $warehouse->product }}" @endif required>
					</div>
					<div class="col-md-6 mb-3">
						<select class="form-control" id="provider_id" name="provider_id" multiple="multiple" data-validation="required">
							@foreach(App\Provider::where('status',1)->get() as $e)
								<option value="{{ $e->id }}" @if(isset($warehouse) && $warehouse->provider_id == $e->id) selected="selected" @endif>{{ $e->businessName }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-cubes prefix"></i>
						<label class="label-form" for="quantity">Cantidad a Ingresar</label>
						<input type="text" class="form-control" id="quantity" name="quantity" @if(isset($warehouse)) value="{{ $warehouse->quantity }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-calendar prefix"></i>
						<label class="label-form" for="date">Fecha</label>
						<input type="text" class="form-control" id="date" name="date" @if(isset($warehouse)) value="{{ $warehouse->date }}" @endif required>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-cubes prefix"></i>
						<label class="label-form" for="quantity_ex">Cantidad en existencia</label>
						<input type="text" class="form-control" id="quantity_ex" name="quantity_ex" @if(isset($warehouse)) value="{{ $warehouse->quantity_ex }}" @endif readonly="readonly" required>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-dollar-sign prefix"></i>
						<label class="label-form" for="price_purchase">Precio Compra</label>
						<input type="text" class="form-control" id="price_purchase" name="price_purchase" @if(isset($warehouse)) value="{{ $warehouse->price_purchase }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-dollar-sign prefix"></i>
						<label class="label-form" for="price">Precio Venta</label>
						<input type="text" class="form-control" id="price" name="price" @if(isset($warehouse)) value="{{ $warehouse->price }}" @endif required>
					</div>
				</div>
				<div class="form-row">
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-cubes prefix"></i>
						<label for="min_wholesale_quantity">Cant. Minima Mayoreo</label>
						<input type="text" class="form-control" id="min_wholesale_quantity" name="min_wholesale_quantity" @if(isset($warehouse)) value="{{ $warehouse->min_wholesale_quantity }}" @endif required>
					</div>
					<div class="md-form col-md-6 mb-3">
						<i class="fas fa-dollar-sign prefix"></i>
						<label class="label-form" for="wholesale_price">Precio Venta Mayoreo</label>
						<input type="text" class="form-control" id="wholesale_price" name="wholesale_price" @if(isset($warehouse)) value="{{ $warehouse->wholesale_price }}" @endif required>
					</div>
				</div>
				<p><br></p>
				<center>
					<button type="submit" class="btn btn-success">@if(isset($warehouse)) GUARDAR CAMBIOS @else REGISTRAR @endif</button>
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
		$('[name="product_id"]').select2(
		{
			placeholder				: 'Producto',
			language				: "es",
			maximumSelectionLength	: 1,
		});
		$('[name="unit"]').select2(
		{
			placeholder				: 'Unidad',
			language				: "es",
			maximumSelectionLength	: 1,
		});
		$('[name="provider_id"]').select2(
		{
			placeholder				: 'Proveedor',
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
		.on('change','[name="product_id"]',function()
		{
			idproduct = $(this).val();
			if (idproduct != "") 
			{
				swal({
					text: 'Cargando',
					html: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
					type: 'info',
					icon: '{{ url('images/load.gif') }}',
					button: false,
				  });
				$.ajax(
				{
					type 	: 'get',
					url 	: '{{ url("administration/warehouse/get-product") }}',
					data 	: {'idproduct':idproduct},
					success : function(data)
					{
						swal.close();
						$.each(data,function(i, d) 
						{
							$('[name="price"]').val(d.price).trigger('change');
							$('[name="wholesale_price"]').val(d.wholesale_price).trigger('change');
							$('[name="price_purchase"]').val(d.price_purchase).trigger('change');
						});
					}
				});

				$.ajax(
				{
					type 	: 'get',
					url 	: '{{ url("administration/warehouse/get-warehouse") }}',
					data 	: {'idproduct':idproduct},
					success : function(data)
					{
						swal.close();
						$.each(data,function(i, d) 
						{
							$('[name="quantity_ex"]').val(d.quantity_ex).trigger('change');
						});
					}
				});
			}
			else
			{
				$('[name="price"]').val(null).trigger('change');
				$('[name="wholesale_price"]').val(null).trigger('change');
				$('[name="price_purchase"]').val(null).trigger('change');
				$('[name="quantity_ex"]').val(null).trigger('change');
			}
		})

	}); 	

</script>
@endsection