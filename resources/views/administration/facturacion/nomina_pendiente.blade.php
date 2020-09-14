@extends('layouts.child_module')
  
@section('data')
<div id="container-cambio" class="div-search">
	<form action="">
		<center>
			<strong>BUSCAR PENDIENTES DE TIMBRADO</strong>
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
						<br><label class="label-form">Empleado:</label>
					</div>
					<div class="right">
						<input type="text" name="employee" class="input-text-search" value="{{ isset($employee) ? $employee : '' }}">
					</div>
					<p></p>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Estatus:</label>
					</div>
					<div class="right">
						<div class="div-form-group modules" style="display: block;">
							<input type="checkbox" name="status[]" value="0" id="Pendiente" @if(isset($status) && in_array(0, $status)) checked @elseif(!isset($status)) checked @endif>
							<label for="Pendiente" class="switch">
								<span class="slider round"></span>
								Pendiente
							</label>
							<br>
							<input type="checkbox" name="status[]" value="6" id="Cola" @if(isset($status) && in_array(6, $status)) checked @elseif(!isset($status)) checked @endif>
							<label for="Cola" class="switch">
								<span class="slider round"></span>
								En cola
							</label>
							<br>
							<input type="checkbox" name="status[]" value="7" id="Error" @if(isset($status) && in_array(7, $status)) checked @elseif(!isset($status)) checked @endif>
							<label for="Error" class="switch">
								<span class="slider round"></span>
								Error al timbrar
							</label>
							<br>
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
<br><br>
</div>
<br>
@if(count($pending) > 0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit' formaction="{{route('bill.nomina.export')}}"><span class='icon-file-excel'></span></button>&nbsp;</div>
	<div style='float: left'><button class='btn btn-green select-all' type='button'>Seleccionar todos (página actual)</button><button class='btn btn-blue stamp-queue' type='button' disabled>Enviar seleccionados a cola de timbrado</button></div>
	</form>
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<th></th>
				<th>Folio</th>
				<th>Serie</th>
				<th>Emisor</th>
				<th>Receptor</th>
				<th>Monto</th>
				<th>Estatus</th>
				<th></th>
				<th></th>
			</thead>
			<tbody>
				@foreach($pending as $bill)
					<tr>
						<td class="align-middle"><input type="checkbox" name="idBill[]" value="{{$bill->idBill}}"></td>
						<td class="align-middle">{{$bill->folio}}</td>
						<td class="align-middle">{{$bill->serie}}</td>
						<td class="align-middle">{{$bill->businessName}}</td>
						<td class="align-middle">{{$bill->clientBusinessName}}</td>
						<td class="align-middle">{{ number_format($bill->total,2) }}</td>
						<td class="align-middle">
							@if($bill->status == 0)
								Pendiente
							@elseif($bill->status == 6)
								En cola
							@elseif($bill->status == 7)
								Error al timbrar
							@endif
						</td>
						<td class="align-middle">
							@if($bill->status==0)
								<a class="btn btn-red" href="{{route('income.prefactura',$bill->idBill)}}" alt="Descargar pre-factura" title="Descargar pre-factura"><span class="icon-pdf"></span></a>
							@endif
						</td>
						<td class="align-middle"><a href="{{route('bill.nomina.pending.stamp',$bill->idBill)}}" class="btn btn-blue"><span class="icon-pencil"></span></a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{ $pending->appends(['employee' => $employee, 'mindate' => $mindate,'maxdate' => $maxdate,'enterpriseid' => $enterpriseid,'status' => $status])->render() }}
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
	$.ajaxSetup(
	{
		headers:
		{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
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
		$(document).on('click','[name="idBill[]"]',function()
		{
			if($('[name="idBill[]"]:checked').length > 0)
			{
				$('.stamp-queue').prop('disabled',false);
			}
			else
			{
				$('.stamp-queue').prop('disabled',true);
			}
		})
		.on('click','.stamp-queue',function()
		{
			id = [];
			$('[name="idBill[]"]:checked').each(function(i,v)
			{
				id.push($(this).val());
			});
			swal({
				icon				: "{{asset('/images/load.gif')}}",
				button				: false,
				closeOnEsc			: false,
				closeOnClickOutside	: false,
			});
			$.ajax(
			{
				type	: 'post',
				url		: '{{ route("bill.nomina.add.queue.massive") }}',
				data	: {'id':id},
				success	: function(data)
				{
					window.location.reload(true);
				}
			});
		})
		.on('click','.select-all',function()
		{
			$('[name="idBill[]"]').prop('checked',true);
			$('.stamp-queue').prop('disabled',false);
		})
		.on('change','[name="status[]"]',function()
		{
			if($('[name="status[]"]:checked').length==0)
			{
				$(this).prop('checked',true);
			}
		});
	});
	@if(isset($alert))
		{!! $alert !!}
	@endif
</script>
@endsection