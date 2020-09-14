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
	<strong>DETALLES DE HERRAMIENTA</strong>
</center>
<div class="divisor">
	<div class="gray-divisor"></div>
	<div class="orange-divisor"></div>
	<div class="gray-divisor"></div>
</div>

<div class="container-blocks" id="container-data">
	<div class="search-table-center">

		<div class="search-table-center-row">
      <div>
        <label class="label-form">Nombre</label>
      </div>
      <div>
        <input type="text" name="brand" class="input-text" placeholder="Nombre">
      </div>
      <br>
      <div>
        <label class="label-form">SKU</label>				
      </div>
      <div>
        <input type="text" name="sku" class="input-text" placeholder="sku">
      </div>
      <br>
			<div>
				<label class="label-form">Cantidad</label>
			</div>
			<div>
				<input type="text" name="quantity" class="input-text quantity" placeholder="Cantidad">
			</div>
			<br>
			<div>
				<label class="label-form">Precio unitario</label>				
			</div>
			<div>
				<input type="text" name="amount" class="input-text amount" placeholder="$0.00">
			</div>
			<br>
			<div>
				<label class="label-form">Importe</label>				
			</div>
			<div>
				<input readonly type="text" name="fimporte" class="input-text" placeholder="$0.00">
			</div>
			<br>
			<div>
				<label class="label-form">Comentario</label>				
			</div>
			<div>
				<textarea placeholder="Comentarios" class="input-text" name="commentaries" id="commentaries"></textarea> 
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
	<strong>LISTA DE HERRAMIENTAS A REGISTRAR</strong>
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
				<th>Nombre</th>
				<th>SKU</th>
				<th>Cantidad</th>
				<th>Precio unitario</th>
				<th>Importe</th>
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
