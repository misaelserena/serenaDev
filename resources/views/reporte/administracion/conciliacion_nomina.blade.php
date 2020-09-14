@extends('layouts.child_module')
@section('css')
	<style>
		.info-container
		{
			display			: flex;
			flex-wrap		: wrap;
			justify-content	: center;
			text-align		: left;
		}
		p
		{
			position	: relative;
		}
		table tr td .help-block.form-error
		{
			left		: 0;
			position	: absolute;
			white-space	: nowrap;
		}
		:not(.multichoice)+span.select2 ul.select2-selection__rendered li:not(:first-child)
		{
			height		: 0;
			overflow	: hidden;
		}
		.table-no-bordered 
		{
		    border: none !important;
		}
		.table-no-bordered td, .table-no-bordered th 
		{

			border-top		: none !important;
			padding			: .75rem;
			vertical-align	: middle;

		}
		.container 
		{
			display				: block;
			position			: relative;
			padding-left		: 35px;
			margin-bottom		: 12px;
			cursor				: pointer;
			font-size			: 22px;
			-webkit-user-select	: none;
			-moz-user-select	: none;
			-ms-user-select		: none;
			user-select			: none;
		}

		.container input 
		{
			opacity	: 0;
			cursor	: pointer;
			height	: 0;
			width	: 0;
		}

		.checkmark 
		{
			position			: absolute;
			top					: 0;
			left				: 0;
			height				: 25px;
			width				: 25px;
			background-color	: #eee;
		}

		.container:hover input ~ .checkmark 
		{
			background-color	: #ccc;
		}

		.container input:checked ~ .checkmark 
		{
			background-color	: #2196F3;
		}

		.checkmark:after 
		{
			content		: "";
			position	: absolute;
			display		: none;
		}

		.container input:checked ~ .checkmark:after 
		{
			display	: block;
		}

		.container .checkmark:after 
		{
			left				: 9px;
			top					: 5px;
			width				: 5px;
			height				: 10px;
			border				: solid white;
			border-width		: 0 3px 3px 0;
			-webkit-transform	: rotate(45deg);
			-ms-transform		: rotate(45deg);
			transform			: rotate(45deg);
		}
	</style>
@endsection
@section('data')
<center>
	<a class="sub-block" href="{{ url('report/administration/conciliation') }}">Conciliación normal</a>
	<a class="sub-block sub-block-active" href="{{ url('report/administration/conciliation-nomina') }}">Conciliación de nómina</a>
</center>
<br><br>
<div id="container-cambio" class="div-search">
	{!! Form::open(['route' => 'report.conciliation-nomina', 'method' => 'GET', 'id'=>'formsearch']) !!}
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
						<label class="label-form">Folio:</label>
					</div>
					<div class="right">
						<p><input type="text" name="folio" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($folio) ? $folio : '' }}"></p>
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
							@if(isset($enterpriseid) || isset($account))
								@foreach(App\Account::where('selectable',1)->where('idEnterprise',$enterpriseid)->get() as $acc)
									@if(isset($account) && $acc->idAccAcc==$account)
										<option value="{{ $acc->idAccAcc }}" selected>{{ $acc->account }} - {{ $acc->description }} ({{ $acc->content }})</option>
									@else
										<option value="{{ $acc->idAccAcc }}">{{ $acc->account }} - {{ $acc->description }} ({{ $acc->content }})</option>
									@endif
								@endforeach
							@endif
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
@if(count($payments)>0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.conciliation-nomina.export') }}"><span class='icon-file-excel'></span></button></div>
	{!! Form::close() !!}
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<tr style="border-bottom: 3px solid rgb(31, 93, 114);border-color: #000;">
					<th colspan="5">Datos del Pago</th>
					<th colspan="4">Datos del Movimiento</th>
				</tr>
				<tr>
					<th width="12.5%">Solicitud</th>
					<th width="12.5%">Empresa</th>
					<th width="12.5%">Empleado</th>
					<th width="12.5%">Importe del Pago</th>
					<th width="12.5%" style="border-right: 2px solid rgb(31, 93, 114);border-color: #000;">Clasificación del gasto</th>
					<th width="12.5%">Movimiento</th>
					<th width="12.5%">Importe del Movimiento</th>
					<th width="12.5%">Fecha de Conciliación</th>
					<th width="12.5%">Acción</th>
				</tr>
			</thead>
			@foreach($payments as $payment)
				<tr>
					<td>
						{{ $payment->idFolio }}
					</td>
					<td>
						{{ $payment->enterprise->name }}
					</td>
					<td>
						{{ $payment->nominaEmployee->employee->first()->name }} {{ $payment->nominaEmployee->employee->first()->last_name }} {{ $payment->nominaEmployee->employee->first()->scnd_last_name }}
					</td>
					<td>
						{{ $payment->amount }}
					</td>
					<td>
						{{ $payment->accounts->account }} - {{ $payment->accounts->description }} ({{ $payment->accounts->content }})
					</td>
					<td>
						{{ $payment->movement->description }}
					</td>
					<td>
						{{ $payment->movement->amount }}
					</td>
					<td>
						{{ date('d-m-Y',strtotime($payment->conciliationDate)) }}
					</td>
					<td>
						<input type="hidden" class="payment" value="{{ $payment->idpayment }}">
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
		{{ $payments->appends([
			'folio'			=> $folio,
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
		idpayment = $(this).parents('tr').find('.payment').val();
		$.ajax(
		{
			type 	: 'get',
			url 	: '{{ route('payments.conciliation-nomina.details') }}',
			data 	: {'idpayment':idpayment},
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