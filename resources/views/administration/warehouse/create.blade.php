@extends('layouts.child_module')

@section('data')
	@if(isset($warehouse))
		{!! Form::open(['route' => ['administration.warehouse.update', $warehouse->id], 'method' => 'PUT', 'class' => 'needs-validation','novalidate']) !!}
	@else
		{!! Form::open(['route' => 'administration.warehouse.store', 'method' => 'POST', 'class' => 'needs-validation','novalidate']) !!}
	@endif
		@csrf
		<div class="form-row">
			<div class="col-md-6 mb-3">
				<label class="label-form" for="product_id">Producto</label>
				<select class="form-control" id="product_id" name="product_id" multiple="multiple" data-validation="required">
					@foreach(App\Products::where('products.status',1)->orderDescription()->get() as $cat)
						<option value="{{ $cat->id }}" @if(isset($warehouse) && $warehouse->product_id ==$cat->id) selected="selected" @endif>{{ $cat->code }} - {{ $cat->description }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-row">
			<div class="md-form col-md-6 mb-3">
				<label class="label-form" for="quantity">Cantidad</label>
				<input type="text" class="form-control" id="quantity" name="quantity" @if(isset($warehouse)) value="{{ $warehouse->quantity }}" @endif placeholder="Cantidad" required>
			</div>
			<div class="md-form col-md-6 mb-3">
				<label class="label-form" for="date">Fecha</label>
				<input type="text" class="form-control" id="date" name="date" @if(isset($warehouse)) value="{{ $warehouse->date }}" @endif placeholder="yyyy-mm-dd" required>
			</div>
		</div>
		<div class="form-row">
			<div class="md-form col-md-6 mb-3">
				<label class="label-form" for="quantity_ex">Cantidad en existencia</label>
				<input type="text" class="form-control" id="quantity_ex" name="quantity_ex" @if(isset($warehouse)) value="{{ $warehouse->quantity_ex }}" @else value="0" @endif readonly="readonly" placeholder="Cantidad" required>
			</div>
			<div class="md-form col-md-6 mb-3">
				<label class="label-form" for="price">Precio</label>
				<input type="text" class="form-control" id="price" name="price" @if(isset($warehouse)) value="{{ $warehouse->price }}" @endif placeholder="0.00" required>
			</div>
		</div>
		<div class="form-row">
			<div class="md-form col-md-6 mb-3">
				<label class="label-form" for="wholesale_price">Precio Mayoreo</label>
				<input type="text" class="form-control" id="wholesale_price" name="wholesale_price" @if(isset($warehouse)) value="{{ $warehouse->wholesale_price }}" @endif placeholder="0.00" required>
			</div>
		</div>
		<p><br></p>
		<center>
			<button type="submit" class="btn btn-success">@if(isset($warehouse)) GUARDAR CAMBIOS @else REGISTRAR @endif</button>
		</center>
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
		.on('change','[name="product_id"]',function()
		{
			$('[name="wholesale_price"],[name="price"],[name="quantity_ex"]').val('0');
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
							$('[name="wholesale_price"]').val(d.wholesale_price);
							$('[name="price"]').val(d.price);
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
							$('[name="quantity_ex"]').val(d.quantity_ex);
						});
					}
				});
			}
		})

	}); 	

</script>
@endsection