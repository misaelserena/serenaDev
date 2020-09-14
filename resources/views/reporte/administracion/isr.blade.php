@extends('layouts.child_module')

@section('css')
	<style type="text/css">
		svg
		{
			fill: currentColor;
			width: 1.4em;
		}
	</style>
@endsection

@section('data')
{!! Form::open(['route' => 'report.isr', 'method' => 'GET', 'id'=>'formsearch','style'=>'display:block']) !!}
	<div id="container-cambio" class="div-search">
		<center>
			<strong>BUSCAR</strong>
		</center>
		<div class="divisor">
			<div class="gray-divisor"></div>
			<div class="orange-divisor"></div>
			<div class="gray-divisor"></div>
		</div>
		<center>
			<div class="search-table-center">
				<div class="search-table-center-row">
					<p>
						<select title="Empleado" name="employee[]" class="js-employee" multiple="multiple" style="width: 98%; max-width: 150px;">
							@foreach(App\RealEmployee::orderName()->get() as $emp)
								<option value="{{ $emp->id }}" @if(isset($employee) && in_array($emp->id, $employee)) selected="selected" @endif>{{ $emp->name }} {{ $emp->last_name }} {{ $emp->scnd_last_name }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Empresa" name="enterprise[]" class="js-enterprise" multiple="multiple" style="width: 98%;">
							@foreach(App\Enterprise::orderName()->get() as $ent)
								<option value="{{ $ent->id }}" @if(isset($enterprise) && in_array($ent->id, $enterprise)) selected="selected" @endif>{{ $ent->name }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Folio:</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="folio" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($folio) ? $folio : '' }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Título:</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="title_request" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($title_request) ? $title_request : '' }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Periodo:</label>
					</div>
					<div class="right-date">
						<p>
							<input type="text" name="mindate" value="{{ isset($mindate) ? date('d-m-Y',strtotime($mindate)) : '' }}" step="1" class="input-text-date datepicker" placeholder="Desde"> - <input type="text" name="maxdate" value="{{ isset($maxdate) ? date('d-m-Y',strtotime($maxdate)) : '' }}" step="1" class="input-text-date datepicker" placeholder="Hasta">
						</p>
					</div>
				</div>
			</div>
		</center>
		<center>
			<button class="btn 	btn-search send" type="submit" title="Buscar"><span class="icon-search"></span> Buscar</button> 
		</center>
		<br><br>
	</div>

@if(isset($requests) && count($requests)>0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.isr.excel') }}"><span class='icon-file-excel'></span></button></div>
	{!! Form::close() !!}
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<th width="5%">Folio</th>
				<th width="25%">Título</th>
				<th width="20%">Empleado</th>
				<th width="20%">Empresa</th>
				<th width="25%">Periodo</th>
				<th width="5%">Acción</th>
			</thead>
			<tbody>
				@foreach($requests as $req)
					<tr>
						<td>
							{{ $req->folio }}
							<input type="hidden" class="idnominaEmployee" value="{{ $req->idnominaEmployee }}">  
							<input type="hidden" class="idnomina" value="{{ $req->idnomina }}">
						</td>
						<td>
							{{ $req->title }}
						</td>
						<td>
							{{ $req->name_emp }} {{ $req->last_name_emp }} {{ $req->scnd_last_name_emp }}
						</td>
						<td>
							{{ App\WorkerData::find($req->idworkingData)->enterprises->name }}
						</td>
						<td>
							{{ $req->from_date }} - {{ $req->to_date }}
						</td>
						<td>
							<button class="btn btn-blue detail" type="button"><span class="icon-search"></span></button>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<center>
		{{ $requests->appends([
				'mindate'		=> $mindate,
				'maxdate'		=> $maxdate,
				'employee'		=> $employee,
				'title_request'	=> $title_request,
				'type'			=> $type,
				'folio'			=> $folio,
				'enterprise'	=> $enterprise
			])->render() }}
	</center><br><br><br>
@else
	<div id="not-found" style="display:block;">Resultado no encontrado</div>
@endif

<div id="myModal" class="modal">

</div>
{!! Form::close() !!}
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
		$('.js-employee').select2(
		{
			placeholder : 'Seleccione un empleado',
			language 	: 'es',
		});
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione la empresa',
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
	.on('click','.detail',function()
	{
		idnominaEmployee = $(this).parents('tr').find('.idnominaEmployee').val();
		idnomina = $(this).parents('tr').find('.idnomina').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/nomina-employee/detail") }}',
			data : {
				'idnominaEmployee'	:idnominaEmployee,
				'idnomina'			:idnomina,
			},
			success : function(data)
			{
				$('#myModal').show().html(data);
			}
		});
	});
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


