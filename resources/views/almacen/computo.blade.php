@extends('layouts.layout')
@section('title', $title)
@section('content')
<div class="container-blocks-all">
	<div class="title-config">
		<h1>{{ $title }}</h1>
	</div>
	<center>
		<i style="color: #B1B1B1">{{ $details }}</i>
	</center>
	<br>
	<hr>
	<h4>Acciones: </h4>
	<div class="container-sub-blocks">
		@foreach(Auth::user()->module->where('father',41)->sortBy('created_at') as $key)
			<a
			
			@if(isset($option_id) && $option_id==$key['id'])
				class=" sub-block sub-block-active"
			@else
				class="sub-block"
			@endif
			href="{{ url($key['url']) }}">{{ $key['name'] }}</a>
		@endforeach
	</div>
</div>

{!! Form::open(['route' => 'warehouse.computer.store', 'method' => 'POST', 'id' => 'container-alta','files'=>true]) !!}
 
<center>
	<strong>DATOS GENERALES</strong>
</center>
<div class="divisor">
	<div class="gray-divisor"></div>
	<div class="orange-divisor"></div>
	<div class="gray-divisor"></div>
</div>
<div class="container-blocks" id="container-data">
	<div class="search-table-center">
		<div class="search-table-center-row">
			<div class="search-table-center-row">
				<p>
					<select class="js-enterprises removeselect form-control" name="enterprise_id" multiple="multiple" id="multiple-enterprises select2-selection--multiple" data-validation="required">
						@foreach(App\Enterprise::where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeEnt($option_id)->pluck('enterprise_id'))->orderBy('name','asc')->get() as $enterprise)
							<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
						@endforeach
					</select><br>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select class="js-accounts removeselect form-control" name="account_id" multiple="multiple" id="multiple-accounts select2-selection--multiple" data-validation="required">
					</select><br>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select class="js-places removeselect form-control" name="place_id" multiple="multiple" data-validation="required">
						@foreach(App\Place::where('status',1)->get() as $place)
						<option value="{{ $place->id }}">{{ $place->place }}</option>			
						@endforeach
					</select>
				</p>
			</div><br>
			<div class="search-table-center-row">
				<label class="label-form">Fecha</label>
				<input type="text" name="date" id="datepicker" placeholder="Fecha" class="new-input-text" data-validation="required" readonly="true">
			</div>
		</div>
	</div>
</div>
<br>
<center>
	<strong>DETALLES DE EQUIPO</strong>
</center>
<div class="divisor">
	<div class="gray-divisor"></div>
	<div class="orange-divisor"></div>
	<div class="gray-divisor"></div>
</div>
<div class="container-blocks" id="container-data">
	<div class="search-table-center">
		<div class="search-table-center-row">
			<p>
				<label class="label-form">Tipo</label><br><br>
				<input type="radio" name="type" id="smartphone" value="1" data-validation="checkbox_group" data-validation-qty="min1">
				<label for="smartphone">Smartphone</label>
				<input type="radio" name="type" id="tablet" value="2" data-validation="checkbox_group" data-validation-qty="min1">
				<label for="tablet">Tablet</label><br><br><br>
				<input type="radio" name="type" id="laptop" value="3" data-validation="checkbox_group" data-validation-qty="min1">
				<label for="laptop">Laptop</label>
				<input type="radio" name="type" id="desktop" value="4" data-validation="checkbox_group" data-validation-qty="min1">
				<label for="desktop">Desktop</label>
				<br><br>
			</p>
			<div>
				<label class="label-form">Marca</label>
			</div>
			<div>
				<input type="text" name="brand" class="new-input-text" placeholder="Marca">
			</div>
			<br>
			<div>
				<label class="label-form">Capacidad de Almacenamiento</label>
			</div>
			<div>
				<input type="text" name="storage" class="new-input-text" placeholder="Capacidad">
			</div>
			<br>
			<div>
				<label class="label-form">Procesador</label>
			</div>
			<div>
				<input type="text" name="processor" class="new-input-text" placeholder="Procesador">
			</div>
			<br>
			<div>
				<label class="label-form">Memoria RAM</label>				
			</div>
			<div>
				<input type="text" name="ram" class="new-input-text" placeholder="Memoria RAM">
			</div>
			<br>
			<div>
				<label class="label-form">SKU</label>				
			</div>
			<div>
				<input type="text" name="sku" class="new-input-text" placeholder="sku">
			</div>
			<br>
			<div>
				<label class="label-form">Cantidad</label>
			</div>
			<div>
				<input type="text" name="quantity" class="new-input-text quantity" placeholder="Cantidad">
			</div>
			<br>
			<div>
				<label class="label-form">Precio unitario</label>				
			</div>
			<div>
				<input type="text" name="amount" class="new-input-text amount" placeholder="$0.00">
			</div>
			<br>
			<div class="left">
				<b>Tipo de IVA:</b>
			</div>
			<div class="right">
				<input type="radio" name="iva_kind" class="iva_kind" id="iva_no" value="no" checked=""><label for="iva_no" title="No IVA" style="display: inline-block;margin: 5px 0 5px 5px;">No</label>
				<input type="radio" name="iva_kind" class="iva_kind" id="iva_a" value="a"><label for="iva_a" title="{{App\Parameter::where('parameter_name','IVA')->first()->parameter_value}}%" style="display: inline-block;">A</label>
				<input type="radio" name="iva_kind" class="iva_kind" id="iva_b" value="b"><label for="iva_b" title="{{App\Parameter::where('parameter_name','IVA2')->first()->parameter_value}}%" style="display: inline-block;">B</label>
			</div>
			<br>
			<br>
			<div>
				<label class="label-form">Importe</label>				
			</div>
			<div>
				<input readonly type="text" name="fimporte" class="new-input-text" placeholder="$0.00">
			</div>
			<br>
			<div>
				<label class="label-form">Comentario</label>				
			</div>
			<div>
				<textarea placeholder="Comentarios" class="new-input-text" name="commentaries" id="commentaries"></textarea> 
			</div>
			<br>
			<div class="left">
			</div>
			<div class="right">
				<center>
					<button class="add2" type="button" name="add" id="add"><div class="btn_plus">+</div> Agregar a lista</button>
				</center>
			</div>
			<br>
		</div>
	</div>
</div>

<br><br>
<center>
	<strong>LISTA DE EQUIPOS A REGISTRAR</strong>
</center>
<div class="divisor">
<div class="gray-divisor"></div>
<div class="orange-divisor"></div>
<div class="gray-divisor"></div>
</div>


<div class="form-container">
	<div class="table-responsive">
		<table id="table" class="table-no-bordered">
			<thead>
				<th width="10%">Tipo</th>
				<th width="10%">Cantidad</th>
				<th width="10%">Marca</th>
				<th width="10%">Almacenamiento</th>
				<th width="10%">Procesador</th>
				<th width="10%">RAM</th>
				<th width="10%">SKU</th>
				<th width="10%">P. unitario</th>
				<th width="10%">IVA</th>
				<th width="10%">Importe</th>
				<th></th>
			</thead>
			<tbody id="body" class="request-validate"></tbody>
		</table>
	</div>
	<br>
</div>
<center>
	<p>
		<input class="btn btn-red enviar" type="submit"  name="enviar" value="ENVIAR"> 
		<input class="btn btn-delete-form" type="reset" name="borra" value="Borrar campos">
	</p>
</center>

{!! Form::close() !!}
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
	$.validate(
	{
		form: '#container-alta',
		modules		: 'security',
		onSuccess : function($form)
		{



			total = parseFloat($('input[name="total"]').val());
			total_articles = parseFloat($('input[name="total_articles"]').val());
			countbody = $('#body tr').length;
			if(total_articles == "" || countbody <= 0)
			{
				swal({
					title: "Error",
					text: "Debe agregar mínimo un artículo.",
					icon: "error",
					buttons: 
					{
						confirm: true,
					},
				});
				return false;
			}
			else if (total_articles > total)
			{
				swal({
					title: "Error",
					text: "La inversión de artículos es mayor a la inversión total.",
					icon: "error",
					buttons: 
					{
						confirm: true,
					},
				});
				return false;
			}
			else
			{
				return true;
			}
		}
	});
	$(document).ready(function() 
	{
		countbody = $('#body tr').length;
		if (countbody <= 0) 
		{
			$('#table').hide();
		}
		else
		{
			$('#table').show();
		}
		$('.js-enterprises').select2({
			placeholder: 'Seleccione la Empresa',
			language: "es",
			maximumSelectionLength: 1
		});
		$('.js-accounts').select2({
			placeholder: 'Seleccione la cuenta',
			language: "es",
			maximumSelectionLength: 1
		});
		$('.js-places').select2({
			placeholder: 'Seleccione la ubicación/sede',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-material').select2({
			placeholder: 'Seleccione el Artículo',
			language: "es",
			maximumSelectionLength: 1,
		});
	});
	$('.quantity').numeric({ negative : false, decimal : false });
	$('.inversion, .amount').numeric({ negative : false, altDecimal: ".", decimalPlaces: 2 });
	$(function()
	{
		$('#datepicker').datepicker({ dateFormat:'dd-mm-yy' });
	})
	$(document)
	.on('change','.quantity,.amount,.iva_kind',function()
		{

			cant	= $('input[name="quantity"]').val();
			precio	= $('input[name="amount"]').val();
			iva		= ({{ App\Parameter::where('parameter_name','IVA')->first()->parameter_value }})/100;
			iva2	= ({{ App\Parameter::where('parameter_name','IVA2')->first()->parameter_value }})/100;
			totalImporte    = cant * precio;

			switch($('input[name="iva_kind"]:checked').val())
			{
				case 'no':
					ivaCalc = 0;
					break;
				case 'a':
					ivaCalc = cant*precio*iva;
					break;
				case 'b':
					ivaCalc = cant*precio*iva2;
					break;
			}
			totalImporte    = ((cant * precio)+ivaCalc);
			$('input[name="fimporte"]').val(totalImporte.toFixed(2));

	})
	.on('click','#add',function()
	{
		cant		= $('input[name="quantity"]').val().trim();
		brand 		= $('input[name="brand"]').val().trim();
		storage 	= $('input[name="storage"]').val().trim();
		processor 	= $('input[name="processor"]').val().trim();
		ram  		= $('input[name="ram"]').val().trim();
		sku	 		= $('input[name="sku"]').val().trim();
		amountUnit 	= $('input[name="amount"]').val().trim();
		comm		= $('textarea[id="commentaries"]').val().trim();
		type 		= $('input[type="radio"]:checked').val();
		amount 		= $('input[name="fimporte"]').val();

		iva_kind = $('input[name="iva_kind"]:checked').val()


		ivaCalc = 0
		switch(iva_kind)
			{
				case 'no':
					ivaCalc = 0;
					break;
				case 'a':
					ivaCalc = cant*amountUnit*iva;
					break;
				case 'b':
					ivaCalc = cant*amountUnit*iva2;
					break;
			}
		sub_total = (Number(amountUnit) * Number(cant))

		nameType = "";
 		if (type == 1) 
 		{
 			nameType = "Smartphone";
 		}
 		if (type == 2) 
 		{
 			nameType = "Tablet";
 		}
 		if (type == 3) 
 		{
 			nameType = "Laptop";
 		}
 		if (type == 4) 
 		{
 			nameType = "Desktop";
 		}
		if (comm == "") 
		{
			comm = "Sin comentarios";
		}
		if (sku == "") 
		{
			sku = "Sin SKU";
		}
		if (cant == "" || brand == "" || storage == "" || processor == "" || ram == "" || amountUnit == "")
		{
			if (cant == "") 
			{
				$('input[name="quantity"]').addClass('error');
			} 
			if(brand == "")
			{
				$('input[name="brand"]').addClass('error');
			}
			if(storage == "")
			{
				$('input[name="storage"]').addClass('error');
			}
			if(processor == "")
			{
				$('input[name="processor"]').addClass('error');
			}
			if(ram == "")
			{
				$('input[name="ram"]').addClass('error');
			}
			if (amountUnit == "") 
			{
				$('input[name="amount"]').addClass('error');
			} 
			$('html, body').animate({scrollTop:0}, 'slow');
		}
		else
		{
			tr_table	= $('<tr></tr>')
						.append($('<td></td>')
							.append(nameType)
							.append($('<input readonly="true" class="input-table ttype" type="hidden" name="ttype[]"/>').val(type))
						)
						.append($('<td></td>')
							.append(cant)
							.append($('<input readonly="true" class="input-table tquanty" type="hidden" name="tquanty[]"/>').val(cant))
						)
						.append($('<td></td>')
							.append(brand)
							.append($('<input readonly="true" class="input-table tbrand" type="hidden" name="tbrand[]"/>').val(brand))
						)
						.append($('<td></td>')
							.append(storage)
							.append($('<input readonly="true" class="input-table tstorage" type="hidden" name="tstorage[]"/>').val(storage))
						)
						.append($('<td></td>')
							.append(processor)
							.append($('<input readonly="true" class="input-table tprocessor" type="hidden" name="tprocessor[]"/>').val(processor))
						)
						.append($('<td></td>')
							.append(ram)
							.append($('<input readonly="true" class="input-table tram" type="hidden" name="tram[]"/>').val(ram))
						)
						.append($('<td></td>')
							.append(sku)
							.append($('<input readonly="true" class="input-table tsku" type="hidden" name="tsku[]"/>').val(sku))
						)
						.append($('<td hidden></td>')
							.append(comm)
							.append($('<input readonly="true" class="input-table tdescr" type="hidden" name="tcommentaries[]"/>').val(comm))
						)
						.append($('<td></td>')
							.append('$ '+ Number(amountUnit).toFixed(2))
							.append($('<input readonly="true" class="input-table tunitatio" type="hidden" name="tamountunit[]"/>').val(amountUnit))
						)
						
						.append($('<td></td>')
							.append('$ '+ Number(ivaCalc).toFixed(2))
							.append($('<input readonly="true" class="input-table tiva" type="hidden" name="tiva[]"/>').val(Number(ivaCalc).toFixed(2)))
							.append($('<input readonly="true" class="input-table tiva_kind" type="hidden" name="tiva_kind[]"/>').val(iva_kind))
							.append($('<input readonly="true" class="input-table tsub_total" type="hidden" name="tsub_total[]"/>').val(sub_total))
						)

						.append($('<td></td>')
							.append('$ '+ Number(amount).toFixed(2))
							.append($('<input readonly="true" class="input-table timporte" type="hidden" name="tamount[]"/>').val(amount))
						)
						.append($('<td style="display: inline-table;"></td>')
								.append($('<button id="edit" class="btn btn-blue edit-item" type="button"></button>')
									.append($('<span class="icon-pencil"></span>'))
								)
								.append($('<button class="delete-item"></button>')
									.append($('<span class="icon-x delete-span"></span>'))
								)
							);
			$('#body').append(tr_table);
			$('input[name="quantity"]').val('');
			$('input[name="brand"]').val('');
			$('input[name="storage"]').val('');
			$('input[name="processor"]').val('');
			$('input[name="ram"]').val('');
			$('input[name="sku"]').val('');
			$('input[name="fimporte"]').val('');
			$('input[name="amount"]').val('');
			$('textarea[id="commentaries"]').val('');
			$('input[type="radio"]').prop('checked', false);;
			$('input[name="quantity"]').removeClass('error');
			$('input[name="brand"]').removeClass('error');
			$('input[name="storage"]').removeClass('error');
			$('input[name="processor"]').removeClass('error');
			$('input[name="ram"]').removeClass('error');
			$('input[name="amount"]').removeClass('error');
			
			countbody = $('#body tr').length;
			if (countbody <= 0) 
			{
				$('#table').hide();
			}
			else
			{
				$('#table').show();
			}
			totalArticles();
		}
	})
	.on('click','.delete-item',function()
	{
		$(this).parents('tr').remove();
		countbody = $('#body tr').length;
		if (countbody <= 0) 
		{
			$('#table').hide();
		}
		totalArticles();
	})
	.on('click','.edit-item',function()
		{
			$('input[name="quantity"]').removeClass('error');
			$('input[name="brand"]').removeClass('error');
			$('input[name="storage"]').removeClass('error');
			$('input[name="processor"]').removeClass('error');
			$('input[name="ram"]').removeClass('error');
			$('input[name="amount"]').removeClass('error');

			nameType = $(this).parents('tr').find('.ttype').val();
			cant = $(this).parents('tr').find('.tquanty').val();
			brand = $(this).parents('tr').find('.tbrand').val();
			storage = $(this).parents('tr').find('.tstorage').val();
			processor = $(this).parents('tr').find('.tprocessor').val();
			ram = $(this).parents('tr').find('.tram').val();
			sku = $(this).parents('tr').find('.tsku').val();
			amountUnit = $(this).parents('tr').find('.tunitatio').val();
			comm = $(this).parents('tr').find('.tdescr').val();

			$('input[name="quantity"]').val(cant);
			$('input[name="brand"]').val(brand);
			$('input[name="storage"]').val(storage);
			$('input[name="processor"]').val(processor);
			$('input[name="ram"]').val(ram);
			$('input[name="sku"]').val(sku);
			$('input[name="amount"]').val(amountUnit);
			$('input[name="fimporte"]').val(cant*amountUnit);
			$('textarea[id="commentaries"]').val( comm === "Sin comentarios" ? "" : comm );

			var radios = $('input:radio[name=type]');

			radios.filter('[value='+nameType+']').prop('checked', true);

			$(this).parents('tr').remove();

			
		})
	.on('change','.js-enterprises',function(){
		$enterprise = $(this).val();
		$('.js-accounts').empty();
		$.ajax(
		{
			type 	: 'get',
			url 	: '{{ url("/warehouse/stationery/accounts") }}',
			data 	: {'enterpriseid':$enterprise},
			success : function(data)
			{

				$.each(data,function(i, d) {
					option = '<option value='+d.idAccAcc+'>'+d.account+' - '+d.description+' ('+d.content+')</option>';
					$('.js-accounts').append(option);
				});
			}
		})
	});

	function totalArticles()
	{
		var sumatotal = 0;
	    $(".importe").each(function(i, v)
	    {
	    	valor = parseFloat($(this).val());
	    	sumatotal = sumatotal + valor ;
    	});
    	$('input[name="total_articles"]').val(sumatotal);
	}
</script>
@endsection