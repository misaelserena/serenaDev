{!! Form::open(['route' => 'warehouse.stationery.store', 'method' => 'POST', 'id' => 'container-alta','files'=>true]) !!}

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
			<p style="padding-left: 15px; width: 97%;">
				<select class="js-enterprises removeselect form-control" name="enterprise_id" multiple="multiple" id="multiple-enterprises select2-selection--multiple" data-validation="required">
					@foreach(App\Enterprise::where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeEnt( $option_id	)->pluck('enterprise_id'))->orderBy('name','asc')->get() as $enterprise)
						<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
					@endforeach
				</select><br>
			</p>
		</div>
		<div class="search-table-center-row">
			<p style="padding-left: 15px; width: 97%;">
				<select class="js-accounts removeselect form-control" name="account_id" multiple="multiple" id="multiple-accounts select2-selection--multiple" data-validation="required">
				</select><br>
			</p>
		</div>
		<div class="search-table-center">
			<label class="label-form">Fecha</label>
			<input type="text" name="date" id="datepicker" placeholder="Fecha" class="new-input-text" data-validation="required" readonly="true">
			<br>
			<label class="label-form">Total de Factura/Ticket</label>
			<input type="text" name="total" class="new-input-text remove inversion" data-validation="required" placeholder="$0.00">
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
	<div id="documents"></div>
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

<div id="table-search-container" style="display: none;">
	<div id="table-return"></div>
	<div id="pagination"></div>
</div>


<div class="container-blocks" id="container-data">
	<div class="search-table-center">
		<div @if ( count($category_id) == 1 ) hidden  @endif class="search-table-center-row">
			<p style="padding-left: 15px; width: 97%;">
				<select class="js-category removeselect form-control" name="category_id" multiple="multiple">
					@foreach (App\CatWarehouseType::whereIn('id',$category_id)->get() as $w)
						@if ( count($category_id) == 1 ) 
							<option selected value="{{ $w->id }}">{{ $w->description }}</option>
						@else
							<option value="{{ $w->id }}">{{ $w->description }}</option>
						@endif
					@endforeach
				</select>
			</p>
		</div>
		<div class="search-table-center-row">
			<p style="padding-left: 15px; width: 97%;">
				<select class="js-places removeselect form-control" name="place_id" multiple="multiple">
					@foreach(App\Place::where('status',1)->get() as $place)
						<option value="{{ $place->id }}">{{ $place->place }}</option>			
					@endforeach
				</select>
			</p>
		</div>
		<div class="search-table-center-row">
			<p style="padding-left: 15px; width: 97%;">
				<select class="js-measurement removeselect form-control" name="measurement_id" multiple="multiple">
					@foreach(App\CatMeasurementTypes::whereNotNull('type')->get() as $m_types)
						@foreach ($m_types->childrens()->orderBy('child_order','asc')->get() as $child)
							<option value="{{ $child->id }}">{{ $child->description }}</option>			
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
					<input type="text" name="concept_name" class="new-input-text remove" placeholder="Concepto">
					<input type="hidden" name="concept_name_id" class="disabled">
				</div>
				<br>
				<div class="left">
					<label class="label-form">Código corto (Opcional)</label>
				</div>
				<div class="right">
					<input type="text" name="short_code" class="new-input-text remove short_code disabled" placeholder="Ingrese el código corto">
				</div>
				<br>
				<div class="left">
					<label class="label-form">Código largo (Opcional)</label>
				</div>
				<div class="right">
					<input type="text" name="long_code" class="new-input-text remove long_code disabled" placeholder="Ingrese el código largo">
				</div>
				<br>
				<div class="left">
					<label class="label-form">Cantidad</label>
				</div>
				<div class="right">
					<input type="text" name="quantity" class="new-input-text remove quantity disabled" placeholder="0">
				</div>
				<br>
				<div class="left">
					<label class="label-form">Precio unitario</label>
				</div>
				<div class="right">
					<input type="text" name="uamount" class="new-input-text remove uamount disabled" placeholder="$0.00">
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
				<br><br>
				<div class="left">
					<label class="label-form">Importe</label>
				</div>
				<div class="right">
					<input readonly type="text" name="amount" class="new-input-text remove amount disabled" placeholder="$0.00">
				</div>
				<br>
				<div class="left">
					<label class="label-form">Comentario (Opcional)</label>
				</div>
				<div class="right">
					<textarea id="commentaries" name="commentaries" cols="20" rows="4" placeholder="Ingrese el comentario" class="new-input-text"></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
<center>
	<button class="add2" type="button" name="add" id="add"><div class="btn_plus">+</div> Agregar artículo</button>
	<button class="btn btn-green"  id="edit_button" style="display: none;" type="button" value="Editar" onclick="edit_material_button()">Editar</button>
	<button class="btn btn-delete-form" type="button" value="Limpiar" onclick="clean_button()">Limpiar</button>
</center>

<div class="form-container">
	<div class="table-responsive">
		<table id="table" class="table-no-bordered">
			<thead>
				<th width="10%">Categoría</th>
				<th width="10%">Concepto</th>
				<th width="5%">Unidad</th>
				<th width="10%">Cód. corto</th>
				<th width="10%">Cód. largo</th>
				<th width="10%">Ubicación/sede</th>
				<th width="10%">Cantidad</th>
				<th width="10%">P. unitario</th>
				<th width="10%">IVA</th>
				<th width="10%">Importe</th>
				<th width="5%"></th>
			</thead>
			<tbody id="body" class="request-validate"></tbody>
			<tfoot>
				<th></th>
			</tfoot>
		</table>
	</div>
	<br>
	
</div>

<div class="totales2">
	<div class="totales">
	</div>
	<div class="totales" style="margin-left: 10px;"> 
		<table id="table2">
			<tr>
				<td><label class="label-form">Sub total:</label></td>
				<td><input placeholder="$0.00" readonly class="input-table" type="text" name="sub_total_articles"></td>
			</tr>
			<tr>
				<td><label class="label-form">IVA:</label></td>
				<td><input placeholder="$0.00" readonly class="input-table" type="text" name="iva_articles"></td>
			</tr>
			<tr>
				<td><label class="label-form">TOTAL:</label></td>
				<td><input placeholder="$0.00" readonly class="input-table" type="text" name="total_articles"></td>
			</tr>
		</table>
		
	</div> 
</div>

<center>
	<p>
		<input class="btn btn-red enviar" type="submit"  name="enviar" value="ENVIAR"> 
	</p>
</center>

{!! Form::close() !!}
