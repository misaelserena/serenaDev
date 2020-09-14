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

{!! Form::open(['route' => 'warehouse.computer.edit_send', 'method' => 'POST', 'id' => 'container-alta','files'=>true]) !!}
<input value="{{ $equipment->id }}" hidden name="computer_id">
<center>
	<strong>DETALLES DE EQUIPO</strong>
</center>
<div class="divisor">
	<div class="gray-divisor"></div>
	<div class="orange-divisor"></div>
	<div class="gray-divisor"></div>
</div>

<div class="container-blocks" name="container-data">
	<div class="search-table-center">
		<div class="search-table-center-row">
			<div class="search-table-center-row">
				<p>
					<select class="js-enterprises removeselect" name="enterprise_id" multiple="multiple" id="multiple-enterprises select2-selection--multiple" style="width: 84%; border: 0px;" data-validation="required">
						@foreach(App\Enterprise::orderName()->get() as $enterprise)
						<option @if ($equipment->idEnterprise == $enterprise->id) selected @endif value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 30 ? substr(strip_tags($enterprise->name),0,30).'...' : $enterprise->name }}</option>
						@endforeach
					</select><br>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
          <select class="js-accounts removeselect" name="account_id" multiple="multiple" id="multiple-accounts select2-selection--multiple" style="width: 84%; border: 0px;" data-validation="required">
            @if ($equipment->account)
							<option selected value="{{ $equipment->accounts->idAccAcc }}" id="current_account_id">
								{{ $equipment->accounts->account. ' - ' .$equipment->accounts->description . ' ('.$equipment->accounts->content.')' }}
							</option>
					@endif
					</select><br>
				</p>
			</div>
			<div class="search-table-center-row">
				<label class="label-form">Fecha</label>
				<input value="{{ $equipment->date ? $equipment->date : ''  }}" type="text" name="date" id="datepicker" placeholder="Fecha" class="input-text" data-validation="required" readonly="true">
			</div>
			<div class="search-table-center-row">
				<p>
					<select class="js-places removeselect" name="place_id" multiple="multiple" style="width: 84%; border: 0px; padding-left: 10px" data-validation="required">
						@foreach(App\Place::where('status',1)->get() as $place)
							<option @if ($equipment->place_location == $place->id) selected @endif value="{{ $place->id }}">{{ $place->place }}</option>			
						@endforeach
					</select>
				</p>
			</div>
			<p>
				<label class="label-form">Tipo</label><br><br>
				<input @if ($equipment->type == 1 ) checked @endif type="radio" name="type" id="smartphone" value="1" data-validation="checkbox_group" data-validation-qty="min1">
				<label for="smartphone">Smartphone</label>
				<input @if ($equipment->type == 2 ) checked @endif type="radio" name="type" id="tablet" value="2" data-validation="checkbox_group" data-validation-qty="min1">
				<label for="tablet">Tablet</label><br><br><br>
				<input @if ($equipment->type == 3 ) checked @endif type="radio" name="type" id="laptop" value="3" data-validation="checkbox_group" data-validation-qty="min1">
				<label for="laptop">Laptop</label>
				<input @if ($equipment->type == 4 ) checked @endif type="radio" name="type" id="desktop" value="4" data-validation="checkbox_group" data-validation-qty="min1">
				<label for="desktop">Desktop</label>
				<br><br>
			</p>
		</div>
		<div class="search-table-center-row">
			<div>
				<label class="label-form">Marca</label>
			</div>
			<div>
				<input data-validation="required" type="text" name="brand" class="input-text" placeholder="Marca" value="{{ $equipment->brand }}">
			</div>
			<br>
			<div>
				<label class="label-form">Capacidad de Almacenamiento</label>
			</div>
			<div>
				<input data-validation="required" type="text" name="storage" class="input-text" placeholder="Capacidad" value="{{ $equipment->storage }}">
			</div>
			<br>
			<div>
				<label class="label-form">Procesador</label>
			</div>
			<div>
				<input data-validation="required" type="text" name="processor" class="input-text" placeholder="Procesador" value="{{ $equipment->processor }}">
			</div>
			<br>
			<div>
				<label class="label-form">Memoria RAM</label>				
			</div>
			<div>
				<input data-validation="required" type="text" name="ram" class="input-text" placeholder="Memoria RAM" value="{{ $equipment->ram }}">
			</div>
			<br>
			<div>
				<label class="label-form">SKU</label>				
			</div>
			<div>
				<input data-validation="required" type="text" name="sku" class="input-text" placeholder="sku" value="{{ $equipment->sku }}">
			</div>
			<br>
			<div>
				<label class="label-form">Cantidad</label>
			</div>
			<div>
				<input data-validation="required" type="text" name="quantity" class="input-text quantity" placeholder="Cantidad" value="{{ $equipment->quantity }}" >
			</div>
			<br>
			<div>
				<label class="label-form">Precio unitario</label>				
			</div>
			<div>
				<input data-validation="required" type="text" name="amountunit" class="input-text amount" placeholder="$0.00" value="{{ $equipment->amountUnit }}">
			</div>
			<br>
			<div class="left">
				<b>Tipo de IVA:</b>
			</div>
			<div class="right">
				<input @if ($equipment->typeTax == null) checked @endif {{ $equipment->typeTax == "no" ? 'checked' : '' }} type="radio" name="iva_kind" class="iva_kind" id="iva_no" value="no" checked=""><label for="iva_no" title="No IVA" style="display: inline-block;margin: 5px 0 5px 5px;">No</label>
				<input {{ $equipment->typeTax == "a" ? 'checked' : '' }} type="radio" name="iva_kind" class="iva_kind" id="iva_a" value="a"><label for="iva_a" title="{{App\Parameter::where('parameter_name','IVA')->first()->parameter_value}}%" style="display: inline-block;">A</label>
				<input {{ $equipment->typeTax == "b" ? 'checked' : '' }} type="radio" name="iva_kind" class="iva_kind" id="iva_b" value="b"><label for="iva_b" title="{{App\Parameter::where('parameter_name','IVA2')->first()->parameter_value}}%" style="display: inline-block;">B</label>
			</div>
			<br>
			<div>
				<label class="label-form">Importe</label>				
			</div>
			<div>
				<input data-validation="required" readonly type="text" name="amount" class="input-text" placeholder="$0.00" value="{{ $equipment->amountTotal }}">
			</div>
			<br>
			<div>
				<label class="label-form">Comentario</label>				
			</div>
			<div>
				<textarea placeholder="Comentarios" class="input-text" name="commentaries" id="commentaries">{{ $equipment->commentaries }}</textarea> 
			</div>
			<br>
		</div>
	</div>
</div>

<center>
	<p>
		<input class="btn btn-red enviar" type="submit"  name="enviar" value="ENVIAR"> 
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


      if ($('.quantity').val() <= 0)
			{
        $('.quantity').removeClass('valid');
        $('.quantity').addClass('error');
				swal({
					title: "Error",
					text: "Debes ingresar la cantidad.",
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

    $enterprise = $('select[name="enterprise_id"] option:selected').val();
		if($enterprise)
		{
			search_accounts($enterprise,true)
		}
    
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
			precio	= $('input[name="amountunit"]').val();
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
			$('input[name="amount"]').val(totalImporte.toFixed(2));

	})
	.on('change','.js-enterprises',function(){

    search_accounts($(this).val())
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

  function search_accounts($enterprise,first = false)
  {
    idAccAcc = Number($('#current_account_id').val());

    if(!first)
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
          if(idAccAcc !== d.idAccAcc)
            $('.js-accounts').append(option);
				});
			}
		})
  }
</script>
@endsection