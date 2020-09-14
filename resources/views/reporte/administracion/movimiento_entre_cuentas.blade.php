@extends('layouts.child_module')
@section('data')
{!! Form::open(['route' => 'report.movements-accounts', 'method' => 'GET', 'id'=>'container-alta','style'=>'display:block']) !!}
<div id="container-cambio" class="div-search">
	<center>
		<strong>BUSCAR GASTOS</strong>
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
					<p>
						<input type="text" name="folio" value="{{ isset($folio) ? $folio : '' }}" class="input-text-search" id="input-search folio" placeholder="Escribe aquí...">
					</p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Solicitante:</label>
				</div>
				<div class="right">
					<p>
						<input type="text" name="name" value="{{ isset($name) ? $name : '' }}" class="input-text-search" id="input-search name" placeholder="Escribe aquí...">
					</p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Rango de fechas:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate" step="1" class="input-text-date datepicker" id="mindate" placeholder="Desde" readonly="readonly" value="{{ isset($mindate) ? $mindate : '' }}"> - <input title="Hasta" type="text" name="maxdate" step="1" id="maxdate" class="input-text-date datepicker" placeholder="Hasta" readonly="readonly" value="{{ isset($maxdate) ? $maxdate : '' }}"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<p>
					<select name="kind[]" class="js-kind" multiple="multiple" style="width: 98%; max-width: 350px;">
						@foreach(App\RequestKind::orderName()->whereIn('idrequestkind',[11,12,13,14,15])->orderBy('kind','ASC')->get() as $k)
							<option value="{{ $k->idrequestkind }}" @if(isset($kind) && in_array($k->idrequestkind, $kind)) selected="selected" @endif>{{ $k->kind }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Estado de Solicitud" name="stat[]" class="js-status" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach (App\StatusRequest::orderName()->whereIn('idrequestStatus',[4,5,10,11,12])->get() as $s)
								<option value="{{ $s->idrequestStatus }}" @if(isset($stat) && in_array($s->idrequestStatus, $stat)) selected="selected" @endif>{{ $s->description }}</option>
						@endforeach
					</select>
				</p>
			</div>
		</div>
	</center>
	<center>
		<button class="btn btn-search send" type="submit" title="Buscar"><span class="icon-search"></span> Buscar</button> 
	</center>
	<br><br>
</div>
@if(count($requests) > 0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.movements-accounts.excel') }}"><span class='icon-file-excel'></span></button></div>
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<th width="14.28%">Folio</th>
				<th>Tipo</th>
				<th width="14.28%">Solicitante</th>
				<th width="14.28%">Elaborado por</th>
				<th width="14.28%">Estado</th>
				<th width="14.28%">Fecha de elaboración</th>
				<th>Empresa</th>
				<th width="14.28%">Clasificación del gasto</th>
				<th width="14.28%">Acción</th>
				
			</thead>
			@foreach($requests as $request)
				<tr>
					<td>{{ $request->folio }}</td>
					<td>{{ $request->requestkind->kind }}</td>
					<td>{{ $request->requestUser()->exists() ? $request->requestUser->name.' '.$request->requestUser->last_name.' '.$request->requestUser->scnd_last_name : 'No hay' }}</td>
					<td>{{ $request->elaborateUser->name.' '.$request->elaborateUser->last_name.' '.$request->elaborateUser->scnd_last_name }}</td>
					<td>
						{{ $request->statusrequest->description }}
					</td>
					@php	
						$time	= strtotime($request->fDate);
						$date	= date('d-m-Y H:i',$time);
					@endphp 
					<td>{{ $date  }}</td>
					<td>
						Varias
					</td>
					<td>
						Varias
					</td>
					<td>
						<a alt="Ver solicitud" title="Ver solicitud" class='btn follow-btn view-request'><span class='icon-search'></span></a>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@else
	<div id="not-found" style="display:block;">No hay solicitudes</div>
@endif
<center>
	{{ $requests->render() }}
</center>
{!! Form::close() !!}
<div id="myModal" class="modal"></div>
@endsection

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('input[name="folio"]').numeric(false);
		$('.js-status').select2(
		{
			placeholder : 'Seleccione un estado de solicitud',
			language 	: 'es',
		});
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione una o varias empresas',
			language 	: 'es',

		});
		$('.js-kind').select2(
		{
			placeholder : 'Seleccione uno o varios tipo de solicitud',
			language 	: 'es',
		});	
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});

	$(document).on('click','.exit',function()
	{
		$('#detail').slideUp();
		$('#myModal').hide();
		$('.detail').removeAttr('disabled');
	})
	.on('click','.view-request',function()
	{

		folio = $(this).parents('tr').children('td:first').text();

		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/movements-accounts/detail") }}',
			data : {'idmovement':folio},
			success : function(data)
			{
				$('#myModal').show().html(data);
				$('#detail').slideDown().html(data);
				$('#table-payroll').slideUp();
			}
		})
	})
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


