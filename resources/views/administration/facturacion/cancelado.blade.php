@extends('layouts.child_module')
  
@section('data')
<div id="container-cambio" class="div-search">
	<form action="">
		<center>
			<strong>BUSCAR CFDIs CANCELADOS Y PENDIENTES DE CANCELACIÓN</strong>
		</center>
		<div class="divisor">
			<div class="gray-divisor"></div>
			<div class="orange-divisor"></div>
			<div class="gray-divisor"></div>
		</div>
		<center>
			<div class="search-table-center">
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Folio:</label>
					</div>
					<div class="right">
						<input type="text" name="folio" class="input-text-search" value="{{ isset($folio) ? $folio : '' }}">
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Tipo:</label>
					</div>
					<div class="right">
						<div class="div-form-group modules" style="display: block;">
							@foreach(App\CatTypeBill::all() as $type)
								<input type="checkbox" name="kind[]" value="{{$type->typeVoucher}}" id="{{$type->description}}" @if(isset($kind) && in_array($type->typeVoucher, $kind)) checked @elseif(!isset($kind)) checked @endif>
								<label for="{{$type->description}}" class="switch">
									<span class="slider round"></span>
									{{$type->description}}
								</label>
								<br>
							@endforeach
						</div>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Estatus:</label>
					</div>
					<div class="right">
						<div class="div-form-group modules" style="display: block;">
							<input type="checkbox" name="status[]" value="3" id="pendiente" @if(isset($status) && in_array('3', $status)) checked @elseif(!isset($status)) checked @endif>
							<label for="pendiente" class="switch">
								<span class="slider round"></span>
								Pendiente
							</label>
							&nbsp;&nbsp;&nbsp;
							<input type="checkbox" name="status[]" value="4" id="cancelado" @if(isset($status) && in_array('4', $status)) checked @elseif(!isset($status)) checked @endif>
							<label for="cancelado" class="switch">
								<span class="slider round"></span>
								Cancelado
							</label>
						</div>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Rango de fechas:</label>
					</div>
					<div class="right-date">
						<p>
							<input type="text" name="mindate" value="{{ isset($mindate) ? date('d-m-Y',strtotime($mindate)) : '' }}" step="1" class="input-text-date datepicker" placeholder="Desde"> - <input type="text" name="maxdate" value="{{ isset($maxdate) ? date('d-m-Y',strtotime($maxdate)) : '' }}" step="1" class="input-text-date datepicker" placeholder="Hasta">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Empresa" name="enterpriseid" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
							@foreach(App\Enterprise::orderName()->whereIn('id',Auth::user()->inChargeEnt($option_id)->pluck('enterprise_id'))->get() as $enterprise)
								@if(isset($enterpriseid) && $enterpriseid == $enterprise->id)
									<option value="{{ $enterprise->id }}" selected>{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
								@else
									<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
								@endif
							@endforeach
						</select>
					</p>
				</div>
			</div>
		</center>
		<center>
			<button class="btn 	btn-search" type="submit"><span class="icon-search"></span> Buscar</button>
		</center>
	</form>
<br><br>
</div>
<br>
@if(count($pending) > 0)
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<th>Tipo</th>
				<th>Folio</th>
				<th>Serie</th>
				<th>Emisor</th>
				<th>Receptor</th>
				<th>Monto</th>
				<th>Estatus</th>
				<th>Estatus CFDI</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($pending as $bill)
					<tr>
						<td class="align-middle">
							{{$bill->cfdiType->description}}
						</td>
						<td class="align-middle">{{$bill->folio}}</td>
						<td class="align-middle">{{$bill->serie}}</td>
						<td class="align-middle">{{$bill->businessName}}</td>
						<td class="align-middle">{{$bill->clientBusinessName}}</td>
						<td class="align-middle">{{ number_format($bill->total,2) }}</td>
						<td class="align-middle">
							@if($bill->status == 3)
								En proceso de cancelación
							@elseif($bill->status == 4)
								Cancelado
							@endif
						</td>
						<td class="align-middle">
							@if($bill->status == 4)
								{{$bill->statusCancelCFDI}}
							@endif
						</td>
						<td class="align-middle"><a href="{{route('bill.cancelled.view',$bill->idBill)}}" class="btn btn-blue"><span class="icon-search"></span></a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{ $pending->appends(['folio'=> $folio, 'kind' => $kind, 'status' => $status, 'mindate' => $mindate,'maxdate' => $maxdate,'enterpriseid'=>$enterpriseid])->render() }}
@else
	<div id="not-found" style="display:block;">No hay solicitudes</div>
@endif
@endsection

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript"> 
	$(document).ready(function()
	{
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione la empresa',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$(document).on('change','[name="kind[]"]',function()
		{
			if($('[name="kind[]"]:checked').length==0)
			{
				$(this).prop('checked',true);
			}
		})
		.on('change','[name="status[]"]',function()
		{
			if($('[name="status[]"]:checked').length==0)
			{
				$(this).siblings('[name="status[]"]').prop('checked',true);
			}
		});
	});
	@if(isset($alert))
		{!! $alert !!}
	@endif
</script>
@endsection