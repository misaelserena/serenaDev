@extends('layouts.child_module')
@section('data')
<center>
	<a class="sub-block sub-block-active" href="{{ url('report/administration/conciliation') }}">Conciliación normal</a>
	<a class="sub-block" href="{{ url('report/administration/conciliation-nomina') }}">Conciliación de nómina</a>
</center>
<br><br>
<div id="container-cambio" class="div-search">
	{!! Form::open(['route' => 'report.conciliation', 'method' => 'GET', 'id'=>'formsearch']) !!}
		<center>
			<strong>BUSCAR CONCILIACIÓN</strong>
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
						<p><input type="text" name="mov" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($mov) ? $mov : '' }}"></p>
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
							@foreach(App\Enterprise::orderName()->whereIn('id',Auth::user()->inChargeEnt(189)->pluck('enterprise_id'))->get() as $enterprise)
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
						<select title="Cuenta" class="js-account removeselect" multiple="multiple" name="account" style="width: 98%; max-width: 150px;">
							
						</select>
					</p>
				</div>
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
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.conciliation.export') }}"><span class='icon-file-excel'></span></button></div>
	{!! Form::close() !!}
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<tr style="border-bottom: 3px solid rgb(31, 93, 114);border-color: #000;">
					<th colspan="3">Datos del Pago</th>
					<th colspan="5">Datos del Movimiento</th>
				</tr>
				<tr>
					<th width="12.5%">Empresa</th>
					<th width="12.5%">Solicitud</th>
					<th width="12.5%" style="border-right: 2px solid rgb(31, 93, 114);border-color: #000;">Importe del Pago</th>
					<th width="12.5%">Movimiento</th>
					<th width="12.5%">Importe del Movimiento</th>
					<th width="12.5%">Fecha de Conciliación</th>
					<th width="12.5%">Clasificación del gasto</th>
					<th width="12.5%">Acción</th>
				</tr>
			</thead>
			@foreach($movements as $movement)
			<tr>
				<td>
					{{ $movement->enterprise->name }}
				</td>
				<td>
					Solicitud de {{ App\RequestModel::find($movement->idFolio)->requestkind->kind }} #{{ $movement->idFolio }}
				</td>
				<td>
					${{ number_format($movement->amount_pay,2) }}
				</td>				
				<td>
					{{ $movement->description }}
				</td>
				<td>
					${{ number_format($movement->amount,2) }}
				</td>
				<td>
					{{ date('d-m-Y',strtotime($movement->conciliationDate)) }}
				</td>
				<td>
					{{ $movement->accounts->account.' - '.$movement->accounts->description }} ({{ $movement->accounts->content }})
				</td>
				<td>
					<input type="hidden" class="movement" value="{{ $movement->idmovement }}">
					<button class="btn follow-btn detailConciliation" type="button" title="Detalles de Conciliación">
						<span class="icon-search"></span>
					</button>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	<div id="myModal" class="modal"></div>
	<center>
		{{ $movements->appends([
			'mov'			=> $mov,
			'mindate'		=> $mindate,
			'maxdate'		=> $maxdate,
			'enterpriseid'	=> $enterpriseid,
			'account'		=> $account
			])->render() }}
	</center><br><br><br>
@else
	<div id="not-found" style="display:block;">Resultado no encontrado</div>
@endif
@endsection

@section('scripts')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
	<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('input[name="folio"]').numeric(false);
		$('.js-account').select2(
		{
			placeholder : 'Cuenta',
			language 	: 'es',
			maximumSelectionLength : 1,
		});
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione la empresa',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});
	$(document).on('change','.js-enterprise',function()
	{
		$('.js-account').empty();
		$enterprise = $(this).val();
		$.ajax(
		{
			type 	: 'get',
			url 	: '{{ url("/administration/purchase/create/account") }}',
			data 	: {'enterpriseid':$enterprise},
			success : function(data)
			{
				 $.each(data,function(i, d) {
			        $('.js-account').append('<option value='+d.idAccAcc+'>'+d.account+' - '+d.description+' ('+d.content+')</option>');
			     });
				
			}
		})
	})
	.on('click','.detailConciliation',function()
	{
		idmovement = $(this).parents('tr').find('.movement').val();
		$.ajax(
		{
			type 	: 'get',
			url 	: '{{ route('payments.conciliation.details') }}',
			data 	: {'idmovement':idmovement},
			success	: function(data)
			{
				$('#myModal').show().html(data);
				$('.detail').attr('disabled','disabled');
			}
		});
	})
	.on('click','.exit',function()
	{
		$('#detail').slideUp();
		$('#myModal').hide();
		$('.detail').removeAttr('disabled');
	})
		
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
    </script> 
@endsection