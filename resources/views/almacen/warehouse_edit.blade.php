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
<br>

{!! Form::open(['route' => 'warehouse.edit_send', 'method' => 'POST', 'id' => 'container-alta','files'=>true]) !!}

<input name="idwarehouse" value="{{ $warehouse->idwarehouse }}" hidden>

<center>
	<strong>DETALLES DE LOTE</strong>
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
				<select class="js-enterprises removeselect" name="enterprise_id" multiple="multiple" id="multiple-enterprises select2-selection--multiple" style="width: 84%; border: 0px;" data-validation="required">
					@foreach(App\Enterprise::orderName()->get() as $enterprise)
					<option 
						@if ($warehouse->lot->idEnterprise == $enterprise->id)
							selected
						@endif
						value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 30 ? substr(strip_tags($enterprise->name),0,30).'...' : $enterprise->name }}</option>
					@endforeach
				</select><br>
			</p>
		</div>
		<div class="search-table-center-row">
			<p>

				<select class="js-accounts removeselect" name="account_id" multiple="multiple" id="multiple-accounts select2-selection--multiple" style="width: 84%; border: 0px;" data-validation="required">
					@if ($warehouse->lot->account)
							<option selected value="{{ $warehouse->lot->accounts->idAccAcc }}" id="current_account_id">
								{{ $warehouse->lot->accounts->account. ' - ' .$warehouse->lot->accounts->description . ' ('.$warehouse->lot->accounts->content.')' }}
							</option>
					@endif
				</select><br>
			</p>
		</div>
		<div class="search-table-center">
			<label class="label-form">Fecha</label>
			<input value="{{ $warehouse->lot->date }}" type="text" name="date" id="datepicker" placeholder="Fecha" class="input-text" data-validation="required" readonly="true">
		</div>

		<div class="search-table-center">
			<label class="label-form">Sub Total de Factura/Ticket</label>
			<input value={{ $warehouse->subtotal ? $warehouse->subtotal : 0 }} type="text" id="sub_total" name="sub_total_masiva" class="input-text remove inversion" data-validation="required" placeholder="$0.00">
		</div>
		<div class="search-table-center">
			<label class="label-form">Total de Factura/Ticket</label>
			<input value="{{ $warehouse->lot->total }}" type="text" name="total" class="input-text remove inversion" data-validation="required" placeholder="$0.00">
		</div>
		</div>
</div>
<br><br><br>
<center>
	<strong>CARGAR TICKET/FACTURA</strong>
</center>
<div class="divisor">
	<div class="gray-divisor"></div>
	<div class="orange-divisor"></div>
	<div class="gray-divisor"></div>
</div>
<center>
	<div id="delete_documents"></div>
	<div id="documents">
		@foreach ($warehouse->lot->documents()->where('status',1)->get() as $doc)
		<div class="docs-p">
			<div class="docs-p-l">
					<input class="id_doc" hidden value="{{ $doc->iddocumentsWarehouse }}"/>
					<a 
						target="_blank"
						href="{{ url('docs/warehouse/'.$doc->path) }}"
						style="text-decoration: none; color: black;">{{ $doc->path }}</a>
			</div>
			<div class="docs-p-r">
				<span class="icon-x delete-span old_delete"></span>
			</div>
		</div>
		@endforeach
	</div>
	<p>
		<button type="button" name="addDoc" id="addDoc"><div class="btn_plus">+</div> Agregar documento</button>
	</p>
</center>
<br>
 
<br><br>
<center>
	<strong>DETALLES DE ARTÍCULOS</strong>
</center>
<div class="divisor">
	<div class="gray-divisor"></div>
	<div class="orange-divisor"></div>
	<div class="gray-divisor"></div>
</div>

<br>
<center>

		<div id="container-cambio">
			<div class="container-search">
				<br>
				<label class="label-form">Buscar artículo</label>
				<br><br>
				<center>
					<input type="text" name="search" class="input-text" id="input-search" placeholder="Escribe un nombre..."> 
					<span class="icon-search"></span> 
				</center>
				<br><br>
			</div>
		</div>
		<br>
		<div class="table-responsive provider"></div>

</center>

<div id="table-return"></div>
<div id="pagination"></div>


<div class="container-blocks" id="container-data">
	<div class="search-table-center">
		<div class="search-table-center-row">
			<p style="padding-left: 15px;">
				<select class="js-category removeselect" name="category_id" multiple="multiple" style="width: 84%; border: 0px; padding-left: 10px">
					
					@foreach (App\CatWarehouseType::all() as $w)
					<option @if ($warehouse->warehouseType == $w->id) selected @endif value="{{ $w->id }}">{{ $w->description }}</option>
					@endforeach
					
				</select>
			</p>
		</div>
	<div class="search-table-center-row">
		<p style="padding-left: 15px;">
			
			<select class="js-places removeselect" name="place_id" multiple="multiple" style="width: 84%; border: 0px; padding-left: 10px">
				@foreach(App\Place::where('status',1)->orWhere('id',$warehouse->place_location)->get() as $place)
					<option 
					@if ($place->id == $warehouse->place_location)
						selected
					@endif
					value="{{ $place->id }}">{{ $place->place }}</option>			
				@endforeach
			</select>
		</p>
	</div>
	<div class="search-table-center-row">
		<p style="padding-left: 15px;">
			
			<select class="js-measurement removeselect" name="measurement_id" multiple="multiple" style="width: 84%; border: 0px; padding-left: 10px">
				@foreach(App\CatMeasurementTypes::whereNotNull('type')->get() as $m_types)
					@foreach ($m_types->childrens()->orderBy('child_order','asc')->get() as $child)
						<option
						@if ($warehouse->measurement == $child->id)
							selected
						@endif
						value="{{ $child->id }}">{{ $child->description }}</option>			
					@endforeach
				@endforeach
			</select>
		</p>
	</div>
		<div class="search-table-center">
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Concepto</label>
				</div>
				<div class="right">
					<input value="{{ $warehouse->cat_c->description }}" type="text" name="concept_name" class="input-text input-text remove" placeholder="Concepto">
				</div>
				<br>
				<div class="left">
					<label class="label-form">Código corto (Opcional)</label>
				</div>
				<div class="right">
					<input value="{{ $warehouse->short_code }}" type="text" name="short_code" class="input-text input-text remove short_code disabled" placeholder="Ingrese el código corto">
				</div>
				<br>
				<div class="left">
					<label class="label-form">Código largo (Opcional)</label>
				</div>
				<div class="right">
					<input value="{{ $warehouse->long_code }}" type="text" name="long_code" class="input-text input-text remove long_code disabled" placeholder="Ingrese el código largo">
				</div>
				<br>
				<div class="left">
					<label class="label-form">Cantidad</label>
				</div>
				<div class="right">
					<input value="{{ $warehouse->quantity }}" type="text" name="quantity" class="input-text input-text remove quantity disabled" placeholder="0">
				</div>
				<br>
				<div class="left">
					<br><label class="label-form">Precio unitario</label>
				</div>
				<div class="right">
					<input value={{ ( $warehouse->subtotal ? $warehouse->subtotal : $warehouse->amount) / $warehouse->quantityReal }} type="text" name="uamount" class="input-text remove uamount disabled" placeholder="$0.00">
				</div>
				<br>
				<div class="left">
					<b>Tipo de IVA:</b>
				</div>
				<div class="right">
					<input @if ($warehouse->typeTax == null) checked @endif {{ $warehouse->typeTax == "no" ? 'checked' : '' }} type="radio" name="iva_kind" class="iva_kind" id="iva_no" value="no"><label for="iva_no" title="No IVA" style="display: inline-block;margin: 5px 0 5px 5px;">No</label>
					<input {{ $warehouse->typeTax == "a" ? 'checked' : '' }} type="radio" name="iva_kind" class="iva_kind" id="iva_a" value="a"><label for="iva_a" title="{{App\Parameter::where('parameter_name','IVA')->first()->parameter_value}}%" style="display: inline-block;">A</label>
					<input {{ $warehouse->typeTax == "b" ? 'checked' : '' }} type="radio" name="iva_kind" class="iva_kind" id="iva_b" value="b"><label for="iva_b" title="{{App\Parameter::where('parameter_name','IVA2')->first()->parameter_value}}%" style="display: inline-block;">B</label>
				</div>
				<br>
				<div class="left">
					<br><label class="label-form">Importe</label>
				</div>
				<div class="right">
					<input value="{{ $warehouse->amount }}" readonly type="text" name="amount" class="input-text remove amount disabled" placeholder="$0.00">
				</div>
				<br>
				<div class="left">
					<br><label class="label-form">Comentario (Opcional)</label>
				</div>
				<div class="right">
					<textarea id="commentaries" name="commentaries" cols="20" rows="4" placeholder="Ingrese el comentario" class="input-text">{{ $warehouse->commentaries }}</textarea>
				</div>
			</div>
		</div>
	</div>
</div>




<center>
	<p>
		<input class="btn btn-red enviar" type="submit"  name="enviar" value="ENVIAR"> 
	</p>
</center>

{!! Form::close() !!}






@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script>

$.ajaxSetup(
{
  headers:
  {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

</script>

@include('almacen.alta.scripts_alta')

<script>
	updateSelectsAlta();

	$(document).on('click','.old_delete',function(){
		id_doc = $(this).parent('.docs-p-r').siblings('.docs-p-l').children('.id_doc').val()
		$('#delete_documents').append('<input class="pathDelete" name="delete_documents[]" value="'+id_doc+'" hidden/>')
		$(this).parent('.docs-p-r').parent('.docs-p').remove();
	});

	$.validate(
{
  form: '#container-alta',
  modules		: 'security',
  onSuccess : function($form)
  {
    path = $('.path').val();

		d_documents = $('.pathDelete').val()
    
    if ( (path == undefined || path == "") && d_documents != undefined)
    {
      swal({
        title: "Error",
        text: "Debe agregar al menos un ticket de compra.",
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

</script>

@endsection

@endsection