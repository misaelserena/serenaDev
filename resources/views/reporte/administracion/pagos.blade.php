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
			{!! Form::open(['route' => 'report.payments', 'method' => 'GET', 'id'=>'formsearch','style'=>'display:block']) !!}
			<center>
				<strong>BUSCAR PAGOS</strong>
			</center>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div>
			<center>
				<div class="search-table-center">
					<div class="search-table-center-row">
						<label class="label-form">Folio:</label>
						<p>
							<input type="text" name="folio" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($folio) ? $folio : '' }}">
						</p>
					</div>
					<div class="search-table-center-row">
						<label class="label-form">Rango de fechas:</label>
						<div class="right-date">
							<p>
								<input type="text" name="mindate" step="1" class="input-text-date datepicker" placeholder="Desde" value="{{ isset($mindate) ? $mindate : '' }}"> - <input type="text" name="maxdate" step="1" class="input-text-date datepicker" placeholder="Hasta" value="{{ isset($maxdate) ? $maxdate : '' }}">
							</p>
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
							<select name="kind" class="js-kind" multiple="multiple" style="width: 98%; max-width: 350px;">
								@foreach(App\RequestKind::orderName()->whereIn('idrequestkind',[1,2,3,5,8,9,11,12,13,14,15,16,17])->get() as $k)
									@if (isset($kind) && $kind == $k->idrequestkind)
										<option selected value="{{ $k->idrequestkind }}">{{ $k->kind }}</option>
									@else
										<option value="{{ $k->idrequestkind }}">{{ $k->kind }}</option>
									@endif
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select title="Empresa" name="enterpriseid" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
								@foreach(App\Enterprise::orderName()->where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeEnt($option_id)->pluck('enterprise_id'))->get() as $enterprise)
									@if(isset($enterpriseid) && $enterpriseid == $enterprise->id)
										<option value="{{ $enterprise->id }}" selected>{{ $enterprise->name }}</option>
									@else
										<option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
									@endif
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select title="Cuenta" class="js-account removeselect" multiple="multiple" name="account" style="width: 98%; max-width: 150px;">
								@if(isset($account) && isset($enterpriseid) && $account != null)
									@foreach(App\Account::where('idEnterprise',$enterpriseid)->where('selectable',1)->get() as $acc)
										@if($account == $acc->idAccAcc)
											<option value="{{ $acc->idAccAcc }}" selected>{{ $acc->account.' - '.$acc->description }} ({{ $acc->content }})</option>
										@else
											<option value="{{ $acc->idAccAcc }}">{{ $acc->account.' - '.$acc->description }} ({{ $acc->content }})</option>
										@endif
									@endforeach
								@elseif(isset($enterpriseid) && $enterpriseid != null)
									@foreach(App\Account::where('idEnterprise',$enterpriseid)->where('selectable',1)->get() as $acc)
											<option value="{{ $acc->idAccAcc }}">{{ $acc->account.' - '.$acc->description }} ({{ $acc->content }})</option>
									@endforeach
								@endif
							</select>
						</p>	
					</div>
				</div>
			</center>
			<center>
				<button class="btn 	btn-search" type="submit">
					<span class="icon-search"></span> Buscar
				</button>
			</center>
			<br><br>
		</div>
		<br>
@if(count($payments) > 0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.payments.export') }}"><span class='icon-file-excel'></span></button></div>
	{!! Form::close() !!}
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<th width="12.5%">Folio</th>
				<th width="12.5%">Tipo de solicitud</th>
				<th width="12.5%">Empresa</th>
				<th width="12.5%">Clasificación del gasto</th>
				<th width="12.5%">Fecha de pago</th>
				<th width="12.5%">Importe</th>
				<th width="12.5%">Acción</th>
			</thead>
			@foreach($payments as $payment)
			<tr>
				<td>{{ $payment->idFolio }}<input type="hidden" class="idpayment" value="{{ $payment->idpayment }}"></td>
				<td>{{ $payment->request->requestkind->kind }}</td>
				<td>{{ $payment->enterprise->name }}</td>
				<td>{{ $payment->accounts->account }} - {{ $payment->accounts->description }} ({{ $payment->accounts->content }})</td>
				<td>{{ date('d-m-Y',strtotime($payment->paymentDate)) }}</td>
				<td>{{ $payment->amount }}</td>
				<td>
					<button type="button" class="btn follow-btn btn-detail" title="Ver detalles"><span class="icon-search"></span></button>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	<center>
		{{ $payments->appends([
			'account'		=> $account,
			'folio'			=> $folio,
			'kind'			=> $kind,
			'mindate'		=> $mindate,
			'enterpriseid'	=> $enterpriseid,
			'conciliation'	=> $conciliation,
			'maxdate'		=> $maxdate])
			->render() }}
	</center><br><br><br>
	<div id="myModal" class="modal"></div>
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
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione la empresa',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$('.js-kind').select2(
		{
			placeholder : 'Tipo de Solicitud',
			language 	: 'es',
			maximumSelectionLength : 1,
		});
			$('.js-account').select2(
		{
			placeholder : 'Seleccione la cuenta',
			language 	: 'es',
			maximumSelectionLength : 1,
		});
		$(function()
		{
			$('.datepicker').datepicker(
			{
				dateFormat : 'dd-mm-yy',
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
		.on('click','.btn-detail',function()
		{
			idpayment = $(this).parent('td').parent('tr').find('.idpayment').val();
			swal({
					icon: '{{ url('images/load.gif') }}',
					button: false,
				});
			$.ajax(
			{
				type	: 'get',
				url		: '{{ url("report/administration/payments/detail") }}',
				data	: {'idpayment':idpayment},
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
	
	@if (isset($alert))
	{!! $alert !!}
	@endif
</script>
@endsection