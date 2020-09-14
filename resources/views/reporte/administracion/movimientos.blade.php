@extends('layouts.child_module')

@section('css')
	<style type="text/css">
		form
		{
			display	: inline-block;
		}
	</style>
@endsection

@section('data')
<div id="container-cambio" class="div-search">
	{!! Form::open(['route' => 'report.movements', 'method' => 'GET', 'id'=>'formsearch','style'=>'display:block']) !!}
			<center>
				<strong>BUSCAR MOVIMIENTOS</strong>
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
							<label class="label-form">Movimiento:</label>
						</div>
						<div class="right">
							<p><input type="text" name="mov" class="input-text-search name" id="input-search" placeholder="Descripción del movimiento..." value="{{ isset($mov) ? $mov : '' }}"></p>
						</div>
					</div>
					<div class="search-table-center-row">
						<div class="left">
							<label class="label-form">Rango de fechas:</label>
						</div>
						<div class="right-date">
							<p><input type="text" name="mindate" step="1" class="input-text-date datepicker" id="mindate" placeholder="Desde" value="{{ isset($mindate) ? $mindate : '' }}"> - <input type="text" name="maxdate" step="1" id="maxdate" class="input-text-date datepicker" placeholder="Hasta" value="{{ isset($maxdate) ? $maxdate : '' }}"></p>
						</div>
					</div>
					<div class="search-table-center-row">
						<div class="left">
							<label class="label-form">Conciliación:</label>
						</div>
						<div class="right-date">
							<select class="custom-select" name="conciliation">
								<option value="all">Todos</option>
								<option value="1" @if(isset($conciliation) && $conciliation == 1) selected @endif>Conciliados</option>
								<option value="0" @if(isset($conciliation) && $conciliation == 0) selected @endif>Sin conciliar</option>
							</select>
						</div>
					</div>
					<div class="search-table-center-row">
						<p>
							<select name="kind[]" class="js-kind" multiple="multiple" style="width: 98%; max-width: 150px;">
								<option value="undefined" @if(isset($kind) && in_array('undefined', $kind)) selected @endif>No definido</option>
								<option value="Devolución" @if(isset($kind) && in_array('Devolución', $kind)) selected @endif>Devolución</option>
								<option value="Egreso" @if(isset($kind) && in_array('Egreso', $kind)) selected @endif>Egreso</option>
								<option value="Ingreso" @if(isset($kind) && in_array('Ingreso', $kind)) selected @endif>Ingreso</option>
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select name="enterpriseid" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
								@foreach(App\Enterprise::orderName()->whereIn('id',Auth::user()->inChargeEnt(187)->pluck('enterprise_id'))->get() as $enterprise)
									@if(isset($enterpriseid) && $enterpriseid == $enterprise->id)
										<option value="{{ $enterprise->id }}" selected>{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
									@else
										<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
									@endif
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select class="js-account removeselect" multiple="multiple" name="account" style="width: 98%; max-width: 150px;">
								
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
@if(count($movements)>0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.movements.export') }}"><span class='icon-file-excel'></span></button></div>
	{!! Form::close() !!}
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<th width="16.6%">Empresa</th>
				<th width="16.6%">Cuenta</th>
				<th width="16.6%">Importe</th>
				<th width="16.6%">Descripción</th>
				<th width="16.6%">Fecha</th>
				<th width="16.6%">Acción</th>
			</thead>
			@foreach($movements as $movement)
			<tr>
				<td>
					{{ $movement->enterprise->name }} <input type="hidden" class="idmovement" value="{{ $movement->idmovement }}">
				</td>
				<td>
					{{ $movement->accounts->account }} - {{ $movement->accounts->description }}
				</td>				
				<td>
					{{ $movement->amount }}
				</td>
				<td>
					{{ $movement->description }}
				</td>
				<td>
					{{ date('d-m-Y',strtotime($movement->movementDate)) }}
				</td>
				<td>
					<button type="button" class="btn follow-btn btn-detail" title="Ver detalles"><span class="icon-search"></span></button>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	<center>
		{{ $movements->appends([
			'enterpriseid'	=> $enterpriseid,
			'account'		=> $account,
			'mov'			=> $mov,
			'mindate'		=> $mindate,
			'maxdate'		=> $maxdate,
			'kind'			=> $kind,
			'conciliation'	=> $conciliation
			])->render() }}
	</center><br><br><br>
	<div id="myModal" class="modal"></div>
@else
	<div id="not-found" style="display:block;">Resultado no encontrado</div>
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
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione la Empresa',
			language 	: 'es',
			maximumSelectionLength	: 1
		});
		$('.js-account').select2(
		{
			placeholder : 'Seleccione la Cuenta',
			language 	: 'es',
			maximumSelectionLength	: 1
		});
		$('.js-kind').select2(
		{
			placeholder : 'Seleccione el tipo',
			language 	: 'es',
		});
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});

		$(document).on('change','.js-enterprise',function()
		{
			$('.js-account').empty();
			$enterprise = $(this).val();
			$.ajax(
			{
				type	: 'get',
				url		: '{{ url("/administration/purchase/create/account") }}',
				data	: {'enterpriseid':$enterprise},
				success	: function(data)
				{
					$.each(data,function(i, d)
					{
						$('.js-account').append('<option value='+d.idAccAcc+'>'+d.account+' - '+d.description+' ('+d.content+')</option>');
					});
				}
			})
		})
		.on('click','.btn-detail',function()
		{
			idmovement = $(this).parent('td').parent('tr').find('.idmovement').val();
			swal({
					icon: '{{ url('images/load.gif') }}',
					button: false,
				});
			$.ajax(
			{
				type	: 'get',
				url		: '{{ url("report/administration/movements/detail") }}',
				data	: {'idmovement':idmovement},
				success : function(data) 
				{
					$('#myModal').show().html(data);
					swal.close();
				},
				error : function()
				{
					swal.close();
					swal('Error','Detalles de pago no encontrado','error');
				}
			})
		})
		.on('click','.exit',function()
		{
			$('#myModal').hide();
		})
		
	});
		
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection