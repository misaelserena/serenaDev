@extends('layouts.child_module')

@section('data')
	@if(isset($sale))
		{!! Form::open(['route' => ['sales.product.update', $sale->id], 'method' => 'PUT', 'class' => 'needs-validation','novalidate']) !!}
	@else
		{!! Form::open(['route' => 'sales.product.store', 'method' => 'POST', 'class' => 'needs-validation','novalidate']) !!}
	@endif
		@csrf
		<div class="card" id="form_search_create">
			<div class="card-header text-white bg-green">
				BUSQUEDA/ALTA DE CLIENTES
			</div>
			<div class="card-body">
				<div class="form-container">
					<div>
						<label class="label-form" class="label-form" for="client_id">Selccione uno</label>
						<br>
						<input type="radio" class="check-radio" name="new_exist" id="new" value="0">
						<label for="new" class="check-small">Nuevo cliente</label>
						<input type="radio" class="check-radio" name="new_exist" id="exist" value="1">
						<label for="exist" class="check-small">Cliente existente</label>
					</div>
				</div>
				<div style="display: none;" id="searchClient" class="container">
					 <div class="row">
						<div class="col align-self-center">
							<div class="form-group">
								<div class="md-form">
									<i class="fas fa-search prefix" aria-hidden="true"></i>
									<label for="search">Escriba aquí para buscar un cliente</label>
									<input type="text" class="form-control my-0 py-1" id="search" name="search">
								</div>
							</div>
							<center>
								<button type="button" class="btn btn-info" id="getClients">
									<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
								</button>
							</center>
							<br>
						</div>
					</div>
					<div class="table-responsive" id="result-clients">
						
					</div>
				</div>
				<div style="display: none;" id="newClient" class="container">
					<div class="form-row">
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-user prefix"></i>
							<label class="label-form" for="name">Nombre</label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-user prefix"></i>
							<label class="label-form" for="last_name">Apellido Paterno</label>
							<input type="text" class="form-control" id="last_name" name="last_name" required>
						</div>
					</div>
					<div class="form-row">
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-user prefix"></i>
							<label class="label-form" for="scnd_last_name">Apellido Materno</label>
							<input type="text" class="form-control" id="scnd_last_name" name="scnd_last_name" required>
						</div>
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-phone prefix"></i>
							<label class="label-form" for="phone">Télefono</label>
							<input type="text" class="form-control" id="phone" name="phone">
						</div>
					</div>
					<div class="form-row">
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-user prefix"></i>
							<label class="label-form" for="rfc">RFC</label>
							<input type="text" class="form-control" id="rfc" name="rfc">
						</div>
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-address-card prefix"></i>
							<label class="label-form" for="address">Dirección</label>
							<input type="text" class="form-control" id="address" name="address" required>
						</div>
					</div>
					<div class="form-row">
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-hashtag prefix"></i>
							<label class="label-form" for="number">Número</label>
							<input type="text" class="form-control" id="number" name="number" required>
						</div>
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-building prefix"></i>
							<label class="label-form" for="colony">Colonia</label>
							<input type="text" class="form-control" id="colony" name="colony" required>
						</div>
					</div>
					<div class="form-row">
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-mail-bulk prefix"></i>
							<label class="label-form" for="postalCode">Código Postal</label>
							<input type="text" class="form-control" id="postalCode" name="postalCode" required>
						</div>
						<div class="md-form col-md-6 mb-3">
							<i class="fas fa-city prefix"></i>
							<label class="label-form" for="city">Ciudad</label>
							<input type="text" class="form-control" id="city" name="city" required>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-3">
							<label class="label-form" for="code">Estado</label>
							<select class="form-control" id="state_idstate" name="state_idstate" multiple="multiple" data-validation="required">
								@foreach(App\State::orderName()->get() as $state)
									<option value="{{ $state->idstate }}">{{ $state->description }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<center>
						<button class="btn btn-success" name="register" type="button">Registrar Cliente</button>
					</center>
				</div>
			</div>
		</div>
		<br>
		<div class="card">
			<div class="card-header text-white bg-green">
				DATOS DEL CLIENTE
			</div>
			<div class="card-body">
				<table class="table">
					<thead class="text-align-center thead-dark">
						<th>ID</th>
						<TH>Nombre</TH>
					</thead>
					<tbody class="text-align-center" id="clientSelected"></tbody>
				</table>
			</div>
		</div>
		<br>
		<div class="card">
			<div class="card-header text-white bg-green">
				DATOS DE LA VENTA
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<label class="label-form" for="product_id">Producto</label>
						<select class="form-control product_id" id="product_id" multiple="multiple" data-validation="required">
							@foreach(App\Products::where('products.status',1)->orderDescription()->get() as $cat)
								<option value="{{ $cat->id }}">{{ $cat->code }} - {{ $cat->description }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label class="label-form" for="type_price">Precio normal/mayoreo</label>
						<select class="form-control type_price" id="type_price" multiple="multiple" data-validation="required">
							<option value="1">Normal</option>
							<option value="2">Mayoreo</option>
						</select>
					</div>
					<div class="col-md-2 mb-3 cont-price-normal" style="display: none;">
						<label class="label-form" for="price">Precio Unitario</label>
						<input type="text" class="form-control price" id="price" placeholder="$0.00" readonly="readonly">
					</div>
					<div class="col-md-2 mb-3 cont-price-wholesale" style="display: none;">
						<label class="label-form" for="wholesale_price">Precio Mayoreo</label>
						<input type="text" class="form-control wholesale_price" id="wholesale_price" placeholder="$0.00" readonly="readonly">
					</div>
					<div class="col-md-2 mb-3">
						<label class="label-form" for="quantity">Cantidad</label>
						<input type="text" class="form-control quantity" id="quantity" placeholder="0">
						<input type="hidden" class="form-control quantity_ex" id="quantity_ex" placeholder="0">
					</div>
					<div class="col-md-2 mb-3">
						<label class="label-form" for="subtotal">Subtotal</label>
						<input type="text" class="form-control subtotal" id="subtotal" placeholder="$0.00">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-2 mb-3">
						<label class="label-form" for="iva">IVA</label>
						<select class="form-control iva" id="iva" multiple="multiple" data-validation="required">
							<option value="0">No</option>
							<option value="1">Sí</option>
						</select>
					</div>
					<div class="col-md-2 mb-3">
						<label class="label-form" for="ivaCalc">IVA</label>
						<input type="text" class="form-control ivaCalc" id="ivaCalc" placeholder="$0.00" readonly="readonly">
					</div>
					<div class="col-md-2 mb-3">
						<label class="label-form" for="discount">Descuento</label>
						<input type="text" class="form-control discount" id="discount" placeholder="$0.00">
					</div>
					<div class="col-md-2 mb-3">
						<label class="label-form" for="total">Total</label>
						<input type="text" class="form-control total" id="total" placeholder="$0.00">
					</div>
					<div class="col-md-1 mb-3">
						<label class="label-form" for="addProduct">Acción</label>
						<button type="button" class='btn btn-success' id="addProduct" alt="Agregar producto" title="Agregar producto">
							<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#cart-plus") }}"></use></svg>
						</button> 
					</div>
				</div>
				<div class="table-responsive">
					<table class="table">
						<thead class="text-align-center thead-dark">
							<th>Producto</th>
							<TH>Cantidad</TH>
							<th>Precio</th>
							<th>Subtotal</th>
							<th>IVA</th>
							<th>Descuento</th>
							<th>Total</th>
							<th>Acción</th>
						</thead>
						<tbody class="text-align-center" id="productSelected"></tbody>
					</table>
				</div>
			    <div class="row justify-content-end">
			    	<div class="md-form col-4">
			      		<label class="label-form" for="subtotal_all">Subtotal</label>
						<input type="text" name="subtotal_all" class="form-control subtotal_all" id="subtotal_all" placeholder="$0.00">
			    	</div>
			  	</div>
			  	<div class="row justify-content-end">
			    	<div class="md-form col-4">
			      		<label class="label-form" for="iva_all">IVA</label>
						<input type="text" name="iva_all" class="form-control iva_all" id="iva_all" placeholder="$0.00">
			    	</div>
			  	</div>
			  	<div class="row justify-content-end">
			    	<div class="md-form col-4">
			      		<label class="label-form" for="discount_all">Descuento</label>
						<input type="text" name="discount_all" class="form-control discount_all" id="discount_all" placeholder="$0.00">
			    	</div>
			    </div>
			    <div class="row justify-content-end">
			    	<div class="md-form col-4">
			      		<label class="label-form" for="total_all">Total</label>
						<input type="text" name="total_all" class="form-control total_all" id="total_all" placeholder="$0.00">
			    	</div>
			  	</div>
			</div>
		</div>
		<p><br></p>
		<center>
			<button type="submit" name="sendForm" class="btn btn-success">@if(isset($sale)) GUARDAR CAMBIOS @else REGISTRAR @endif</button>
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
	$(document).ready(function()
	{
		$('[name="client_id"],#product_id,#type_price,[name="state_idstate"],#iva').select2(
		{
			placeholder				: 'Seleccione uno',
			language				: "es",
			maximumSelectionLength	: 1,
			width 					: "100%"
		});
		$('#price,#total,#discount,#quantity,#quantity_ex').numeric({ altDecimal: ".", decimalPlaces: 2, negative:true });

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
		.on('click','[name="new_exist"]',function()
		{
			if ($(this).val() == 0) 
			{
				$('#newClient').stop(true,true).fadeIn();
				$('#searchClient').stop(true,true).fadeOut();
				$('[name="state_idstate"]').select2(
				{
					placeholder				: 'Seleccione uno',
					language				: "es",
					maximumSelectionLength	: 1,
					width 					: "100%"
				});
			}
			else
			{
				$('#searchClient').stop(true,true).fadeIn();
				$('#newClient').stop(true,true).fadeOut();
			}
		})
		.on('click','#getClients',function()
		{
			name = $('[name="search"]').val().trim();
			$.ajax(
			{
				type 	: 'get',
				url 	: '{{ url("sales/product/get-client") }}',
				data 	: {'name':name},
				success : function(data)
				{
					$('#result-clients').html(data);
				}
			});
		})
		.on('click','#addClientExists',function()
		{
			id_client_table		= $(this).parents('tr').find('.id_client_table').val();
			name_client_table	= $(this).parents('tr').find('.name_client_table').val();

			tr = $('<tr></tr>')
					.append($('<td></td>')
						.append(''+id_client_table+'')
						.append($('<input type="hidden" name="idClient" value="'+id_client_table+'">')))
					.append($('<td></td>')
						.append(''+name_client_table+'')
						.append($('<input type="hidden" name="nameClient" value="'+name_client_table+'">')));

			$('#clientSelected').append(tr);
			$('#form_search_create').fadeOut();
			swal('','Cliente agregado','success');

		})
		.on('change','#product_id',function()
		{
			$('.price').val('');
			idproduct = $(this).val();
			if (idproduct != "") 
			{
				swal({
					title: 'Cargando',
					type: 'info',
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
							$('.price').val(d.price);
							$('.wholesale_price').val(d.wholesale_price);
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
							$('.quantity_ex').val(d.quantity_ex);
						});
					}
				});
			}
		})
		.on('click','#addProduct',function()
		{
			quantity		= $(this).parents('div.card-body').find('.quantity').val();
			quantity_ex		= $(this).parents('div.card-body').find('.quantity_ex').val();
			if (type_price == 1) 
			{
				price = $(this).parents('div.card-body').find('.price').val();
			}
			if (type_price == 2) 
			{
				price = $(this).parents('div.card-body').find('.wholesale_price').val();
			}
			discount		= $(this).parents('div.card-body').find('.discount').val();
			iva				= $(this).parents('div.card-body').find('.ivaCalc').val();
			subtotal		= $(this).parents('div.card-body').find('.subtotal').val();
			total			= $(this).parents('div.card-body').find('.total').val();
			product_id		= $(this).parents('div.card-body').find('.product_id option:selected').val();
			product_name	= $(this).parents('div.card-body').find('.product_id option:selected').text();

			if (quantity != "" && price != "" && total != "" && product_id != "") 
			{
				if (quantity_ex < quantity) 
				{
					swal('Error','La cantidad existente en inventario es menor a lo que esta comprando','error');
				}
				else if (total <= 0) 
				{
					$('#discount').val(0);
					$('#quantity').val(0);
					$('#total').val(0);
					swal('Error','El importe no puede ser negativo o cero.','error');
				}
				else
				{
					tr = $('<tr></tr>')
							.append($('<td></td>')
								.append(''+product_name+'')
								.append($('<input type="hidden" name="product_id[]" value="'+product_id+'">'))
								.append($('<input type="hidden" name="type_price[]" value="'+type_price+'">')))
							.append($('<td></td>')
								.append(''+quantity+'')
								.append($('<input type="hidden" name="quantity[]" value="'+quantity+'">')))
							.append($('<td></td>')
								.append(''+price+'')
								.append($('<input type="hidden" name="price[]" value="'+price+'">')))
							.append($('<td></td>')
								.append(''+subtotal+'')
								.append($('<input type="hidden" class="subtotal_table" name="subtotal[]" value="'+subtotal+'">')))
							.append($('<td></td>')
								.append(''+iva+'')
								.append($('<input type="hidden" class="iva_table" name="iva[]" value="'+iva+'">')))
							.append($('<td></td>')
								.append(''+discount+'')
								.append($('<input type="hidden" class="discount_table" name="discount[]" value="'+discount+'">')))
							.append($('<td></td>')
								.append(''+total+'')
								.append($('<input type="hidden" class="total_table" name="total[]" value="'+total+'">')))
							.append($('<td></td>')
								.append($('<button type="button" class="btn btn-danger deleteProduct"><svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#cart-dash") }}"></use></svg></button>')));

					$('#productSelected').append(tr);

					$('.quantity,.quantity_ex,.price,.discount,.total,.subtotal,.ivaCalc').val(null);
					$('.product_id,.iva').val(null).trigger('change');

					product_id = [];
					$('[name="product_id[]"]').each(function()
					{
						product_id.push(Number($(this).val()));
					});

					$('#product_id').empty();
					$.ajax(
					{
						type: 'get',
						url : '{{ url("sales/product/update-list") }}',
						data : {'product_id':product_id},
						success: function(data)
						{
							$.each(data,function(i, d) 
							{
								$('#product_id').append('<option value='+d.id+'>'+d.code+' - '+d.description+'</option>');
							});
						}
					});


					tempDiscount	= 0;
					tempSubtotal 	= 0;
					tempIva 		= 0;
					tempTotal		= 0;
					//descuento	= Number($('input[name="descuento"]').val());
					$("#productSelected tr").each(function(i, v)
					{
						tempDiscount	+= Number($(this).find('.discount_table').val());
						tempIva  		+= Number($(this).find('.iva_table').val());
						tempSubtotal	+= Number($(this).find('.subtotal_table').val());
						tempTotal		+= Number($(this).find('.total_table').val());
					});
					
					$('[name="total_all"]').val(tempTotal);
					$('[name="discount_all"]').val(tempDiscount);
					$('[name="subtotal_all"]').val(tempSubtotal);
					$('[name="iva_all"]').val(tempIva);

					swal('','Producto agregado','success');
				}
			}
			else
			{
				swal('Error','Faltan campos','error');
			}
		})
		.on('click','.deleteProduct',function()
		{
			$(this).parents('tr').remove();

			product_id = [];
			if ($('[name="product_id[]"]').val() != undefined) 
			{
				$('[name="product_id[]"]').each(function()
				{
					product_id.push(Number($(this).val()));
				});
			}
			else
			{
				product_id.push('0');
			}

			$('#product_id').empty();
			$.ajax(
			{
				type: 'get',
				url : '{{ url("sales/product/update-list") }}',
				data : {'product_id':product_id},
				success: function(data)
				{
					$.each(data,function(i, d) 
					{
						$('#product_id').append('<option value='+d.id+'>'+d.code+' - '+d.description+'</option>');
					});
				}
			});

			tempDiscount	= 0;
			tempSubtotal 	= 0;
			tempIva 		= 0;
			tempTotal		= 0;
			//descuento	= Number($('input[name="descuento"]').val());
			$("#productSelected tr").each(function(i, v)
			{
				tempDiscount	+= Number($(this).find('.discount_table').val());
				tempIva  		+= Number($(this).find('.iva_table').val());
				tempSubtotal	+= Number($(this).find('.subtotal_table').val());
				tempTotal		+= Number($(this).find('.total_table').val());
			});
			
			$('[name="total_all"]').val(tempTotal);
			$('[name="discount_all"]').val(tempDiscount);
			$('[name="subtotal_all"]').val(tempSubtotal);
			$('[name="iva_all"]').val(tempIva);

			swal('','Producto eliminado','success');
		})
		.on('change','#type_price',function()
		{
			value = $('#type_price option:selected').val();
			if (value != undefined) 
			{
				if (value == 1) 
				{
					$('.cont-price-normal').fadeIn();
					$('.cont-price-wholesale').fadeOut();
				}
				else
				{
					$('.cont-price-normal').fadeOut();
					$('.cont-price-wholesale').fadeIn();
				}
			}
			else
			{
				$('.cont-price-normal').fadeOut();
				$('.cont-price-wholesale').fadeOut();
			}
		})
		.on('change','#quantity,#type_price,#discount,#iva',function()
		{
			type_price	= $('#type_price option:selected').val();
			discount	= Number($('#discount').val()).toFixed(2);
			quantity	= Number($('#quantity').val()).toFixed(2);

			if ($('#iva option:selected').val() == 1) 
			{
				iva = 0.15;
			}
			else
			{
				iva = 0;
			}

			if (type_price != undefined) 
			{
				if (type_price == 1) 
				{
					price = Number($('#price').val()).toFixed(2);
				}
				if (type_price == 2) 
				{
					price = Number($('#wholesale_price').val()).toFixed(2);
				}

				subtotal	= quantity * price;
				ivaCalc 	= subtotal * iva;
				total		= (subtotal + ivaCalc) - discount;

				$('#ivaCalc').val(Number(ivaCalc).toFixed(2));
				$('#subtotal').val(Number(subtotal).toFixed(2));
				$('#total').val(Number(total).toFixed(2));

			}
		})
		.on('click','[name="register"]',function()
		{
			name			= $('[name="name"]').val();
			last_name		= $('[name="last_name"]').val();
			scnd_last_name	= $('[name="scnd_last_name"]').val();
			phone			= $('[name="phone"]').val();
			rfc				= $('[name="rfc"]').val();
			address			= $('[name="address"]').val();
			number			= $('[name="number"]').val();
			colony			= $('[name="colony"]').val();
			postalCode		= $('[name="postalCode"]').val();
			city			= $('[name="city"]').val();
			state_idstate	= $('[name="state_idstate"] option:selected').val();

			$.ajax({
				type 	: 'POST',
				url 	: '{{ url('/sales/product/store-client') }}',
				data 	: {
					'name'				: name,
					'last_name'			: last_name,
					'scnd_last_name'	: scnd_last_name,
					'phone'				: phone,
					'rfc'				: rfc,
					'address'			: address,
					'number'			: number,
					'colony'			: colony,
					'postalCode'		: postalCode,
					'city'				: city,
					'state_idstate'		: state_idstate,
				},
				success: function(data)
				{

					id_client_table		= data.id;
					name_client_table	= data.name;

					tr = $('<tr></tr>')
							.append($('<td></td>')
								.append(''+id_client_table+'')
								.append($('<input type="hidden" name="idClient" value="'+id_client_table+'">')))
							.append($('<td></td>')
								.append(''+name_client_table+'')
								.append($('<input type="hidden" name="nameClient" value="'+name_client_table+'">')));

					$('#clientSelected').append(tr);
					$('#form_search_create').fadeOut();
					swal('','Cliente registrado y agregado','success');
				}
			})

		})
		.on('click','[name="sendForm"]',function(e)
		{
			clientSelected 		= $('#clientSelected tr').length;
			productSelected 	= $('#productSelected tr').length;

			if (clientSelected > 0 && productSelected > 0) 
			{
				form = $(this).parents('form');
				form.submit();
			}
			else
			{
				e.preventDefault();

				if (clientSelected == 0)
				{
					swal('Error','Debe agregar un cliente','error');
				} 
				if (productSelected == 0)
				{
					swal('Error','Debe agregar al menos un producto','error');
				} 
			}
		})
	}); 	

</script>
@endsection