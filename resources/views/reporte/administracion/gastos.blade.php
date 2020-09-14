@extends('layouts.child_module')
@section('data')
{!! Form::open(['route' => 'report.expensesRequest', 'method' => 'get', 'id' => 'container-alta','files' => true]) !!}
<div id="container-cambio" class="div-search">
	<center>
		<strong>BUSCAR SOLICITUDES</strong>
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
					<p>
						<input type="text" name="folio" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($folio) ? $folio : '' }}">
					</p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Fecha de elaboración:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate" step="1" class="input-text-date datepicker" id="mindate" placeholder="Desde" readonly="readonly" value="{{ isset($mindate) ? date('d-m-Y',strtotime($mindate)) : '' }}"> - <input title="Hasta" type="text" name="maxdate" step="1" id="maxdate" class="input-text-date datepicker" placeholder="Hasta" readonly="readonly" value="{{ isset($maxdate) ? date('d-m-Y',strtotime($maxdate)) : '' }}"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Fecha de revisión:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate_review" step="1" class="input-text-date datepicker" id="mindate_review" placeholder="Desde" readonly="readonly" value="{{ isset($mindate_review) ? date('d-m-Y',strtotime($mindate_review)) : '' }}"> - <input title="Hasta" type="text" name="maxdate_review" step="1" id="maxdate_review" class="input-text-date datepicker" placeholder="Hasta" readonly="readonly" value="{{ isset($maxdate_review) ? date('d-m-Y',strtotime($maxdate_review)) : '' }}"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Fecha de autorización:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate_authorize" step="1" class="input-text-date datepicker" id="mindate_authorize" placeholder="Desde" readonly="readonly" value="{{ isset($mindate_authorize) ? date('d-m-Y',strtotime($mindate_authorize)) : '' }}"> - <input title="Hasta" type="text" name="maxdate_authorize" step="1" id="maxdate_authorize" class="input-text-date datepicker" placeholder="Hasta" readonly="readonly" value="{{ isset($maxdate_authorize) ? date('d-m-Y',strtotime($maxdate_authorize)) : '' }}"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Solicitante:</label>
				</div>
				<div class="right">
					<p><input title="Solicitante" type="text" name="name" class="input-text-search name" id="input-search" placeholder="Nombre del solicitante..." value="{{ isset($name) ? $name : '' }}"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<p>
					<select name="kind[]" class="js-kind" multiple="multiple" style="width: 98%; max-width: 350px;">
						@foreach(App\RequestKind::whereIn('idrequestkind',[1,2,3,8,9,11,12,13,14,15,16,17])->orderBy('kind','ASC')->get() as $k)
							<option value="{{ $k->idrequestkind }}" @if(isset($kind) && in_array($k->idrequestkind, $kind)) selected="selected" @endif >{{ $k->kind }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Empresa" name="enterprise[]" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach(App\Enterprise::orderName()->get() as $e)
							<option value="{{ $e->id }}" @if(isset($enterprise) && in_array($e->id, $enterprise)) selected="selected" @endif>{{ strlen($e->name) >= 35 ? substr(strip_tags($e->name),0,35).'...' : $e->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Dirección" class="js-area" multiple="multiple" name="direction[]" style="width: 98%; max-width: 150px;">
						@foreach(App\Area::orderName()->where('status','ACTIVE')->get() as $area)
							<option value="{{ $area->id }}" @if(isset($direction) && in_array($area->id, $direction)) selected="selected" @endif>{{ $area->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Departamento" class="js-department" multiple="multiple" name="department[]" style="width: 98%; max-width: 150px;">
						@foreach(App\Departament::orderName()->where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeDep($option_id)->pluck('departament_id'))->get() as $d)
							<option value="{{ $d->id }}" @if(isset($department) && in_array($d->id, $department)) selected="selected" @endif>{{ $d->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Estado de Solicitud" name="status[]" class="js-status" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach (App\StatusRequest::orderName()->whereIn('idrequestStatus',[4,5,6,7,10,11,12,13])->get() as $s)
								<option value="{{ $s->idrequestStatus }}" @if(isset($status) && in_array($s->idrequestStatus, $status)) selected="selected" @endif>{{ $s->description }}</option>
						@endforeach
					</select>
				</p>
			</div>
		</div>
	</center>
	<center>
		<button class="btn 	btn-search send" type="submit"><span class="icon-search"></span> Buscar</button>
	</center>

	@if (count($requests) > 0)
		<div style="display: block;">
			<div><label class='label-form'>Exportar a Excel (Agrupado): </label><button class='btn btn-green export' type='submit' formaction="{{ route('report.expensesRequest.excel') }}"><span class='icon-file-excel'></span></button></div>
			<div><label class='label-form'>Exportar a Excel (Sin agrupar): </label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.expensesRequest.excelwg') }}"><span class='icon-file-excel'></span></button></div>
		</div>
		{!! Form::close() !!}
		
		<div class='table-responsive'>
			<table class='table table-striped' id='table-expenses'>
				<thead class='thead-dark'>
					<th width="5%">Folio</th>
					<th width="10%">Estado</th>
					<th width="10%">Tipo de solicitud</th>
					<th width="10%">Solicitante</th>
					<th width="15%">Empresa</th>
					<th width="10%">Dirección</th>
					<th width="10%">Departamento</th>
					<th width="10%">Fecha</th>
					<th width="15%">Importe</th>
					<th width="5%">Acción</th>
				</thead>

				@foreach($requests as $request)
					@php
						$subtotalFinal = $ivaFinal = $totalFinal = $taxes = 0;
						switch ($request->kind) 
						{
							case 1:
								$totalFinal = $request->purchases->first()->amount;
								break;

							case 2:
								$totalFinal = $request->nominas->first()->amount;
								break;

							case 3:
								$totalFinal = $request->expenses->first()->total;
								break;

							case 8:
								$totalFinal = $request->resource->first()->total;
								break;

							case 9:
								$totalFinal = $request->refunds->first()->total;
								break;

							case 11:
								$totalFinal = $request->adjustment->first()->amount;
								break;

							case 12:
								$totalFinal = $request->loanEnterprise->first()->amount;
								break;

							case 13:
								$totalFinal = $request->purchaseEnterprise->first()->amount;
								break;

							case 14:
								$totalFinal = $request->groups->first()->amount;
								break;

							case 15:
								$totalFinal = $request->movementsEnterprise->first()->amount;
								break;

							case 16:
								$totalFinal = $request->nominasReal->first()->amount;
								break;

							case 17:
								$totalFinal = $request->purchaseRecord->total;
								break;
							
							default:
								# code...
								break;
						}
						$varias			= 'Varias';
						$enterpriseName	=  $request->reviewedEnterprise()->exists() ? $request->reviewedEnterprise->name : $varias;
						$directionName	=  $request->reviewedDirection()->exists() ? $request->reviewedDirection->name : $varias;
						$departmentName	= $request->reviewedDepartment()->exists() ? $request->reviewedDepartment->name : $varias;
					@endphp
					<tr>
						<td> {{ $request->folio }} <input type='hidden' class='folio' value='{{ $request->folio }}'></td>
						<td> {{ $request->statusrequest->description }}</td>
						<td> {{ $request->requestkind->kind }}</td>
						<td>{{ $request->requestUser->name ." ". $request->requestUser->last_name ." ". $request->requestUser->scnd_last_name }}</td>
						<td>{{ $enterpriseName }} </td>
						<td>{{ $directionName }} </td>
						<td>{{ $departmentName }} </td>
						<td> {{ date('d-m-Y',strtotime($request->fDate)) }} </td>
						<td>$ {{number_format($totalFinal,2)}} </td>
						<td><button type='button' class='btn follow-btn detail' title='Detalles'><span class='icon-search'></span></button></td>
					</tr>
				@endforeach
			</table>
		</div>
		<center>
		{{ $requests->appends([
			'enterprise'		=> $enterprise,
			'direction'			=> $direction,
			'department'		=> $department,
			'account'			=> $account,
			'name'				=> $name,
			'kind'				=> $kind,
			'status'			=> $status,
			'folio'				=> $folio,
			'mindate'			=> $mindate,
			'maxdate'			=> $maxdate,
			'mindate_review'	=> $mindate_review,
			'maxdate_review'	=> $maxdate_review,
			'mindate_authorize'	=> $mindate_authorize,
			'maxdate_authorize'	=> $maxdate_authorize,
		])->render() }}
	</center><br><br><br>
		<div id='detail' style='display: none;'></div>
	@else
		<div id='not-found' style='display:block;'>Resultado no encontrado</div>
	@endif

	<br><br>
</div>
<br>
<div id="table-return"></div>
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
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione la empresa',
			language 	: 'es',
		});
		$('.js-area').select2(
		{
			placeholder : 'Seleccione la dirección',
			language 	: 'es',
		});
		$('.js-kind').select2(
		{
			placeholder : 'Seleccione un tipo de solicitud',
			language 	: 'es',
		});
		$('.js-department').select2(
		{
			placeholder : 'Seleccione el departamento',
			language 	: 'es',
		});
		$('.js-status').select2(
		{
			placeholder : 'Seleccione un estado de solicitud',
			language 	: 'es',
		});
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});
	$(document).on('click','.detail', function()
	{
		folio = $(this).parents('tr').find('.folio').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/expenses-requests/detail") }}',
			data : {'folio':folio},
			success : function(data)
			{
				$('#myModal').show().html(data);
				$('.detail').attr('disabled','disabled');
			}
		})
	})
	.on('click','.exit',function()
	{
		$('#detail').slideUp();
		$('.detail').removeAttr('disabled');
		$('#myModal').hide();
	})
	.on('click','#ver',function()
		{
			nameEmp           = $(this).parent('td').parent('tr').find('.name').val();
			lastnameEmp       = $(this).parent('td').parent('tr').find('.last_name').val();
			scnd_last_nameEmp = $(this).parent('td').parent('tr').find('.scnd_last_name').val();
			bankEmp           = $(this).parent('td').parent('tr').find('.bank').val();
			cardEmp           = $(this).parent('td').parent('tr').find('.cardNumber').val();
			accountEmp        = $(this).parent('td').parent('tr').find('.account').val();
			clabeEmp          = $(this).parent('td').parent('tr').find('.clabe').val();
			referenceEmp      = $(this).parent('td').parent('tr').find('.reference').val();
			amountEmp         = $(this).parent('td').parent('tr').find('.importe').val();
			reason_paymentEmp = $(this).parent('td').parent('tr').find('.description').val();
			accounttext       = $(this).parent('td').parent('tr').find('.accounttext').val();
			enterprise    	  = $(this).parent('td').parent('tr').find('.enterprise').val();
			project           = $(this).parent('td').parent('tr').find('.project').val();
			area              = $(this).parent('td').parent('tr').find('.area').val();
			department        = $(this).parent('td').parent('tr').find('.department').val();
			if(accountEmp == '')
			{
				accountEmp = '-----';
			}

			if(cardEmp == '')
			{
				cardEmp = '-----';
			}

			if(clabeEmp == '')
			{
				clabeEmp = '-----';
			}			

			$('#nameEmp').html(nameEmp+' '+lastnameEmp+' '+scnd_last_nameEmp);
			$('#idBanksEmp').html(bankEmp);
			$('#card_numberEmp').html(cardEmp);
			$('#accountEmp').html(accountEmp);
			$('#clabeEmp').html(clabeEmp);
			$('#referenceEmp').html(referenceEmp);
			$('#amountEmp').html(amountEmp);
			$('#reason_paymentEmp').html(reason_paymentEmp);
			$('#accounttext').html(accounttext);
			$('#enterprise').html(enterprise);
			$('#project').html(project);
			$('#area').html(area);
			$('#department').html(department);
			$(".formulario").stop().slideToggle();
		})
		.on('click','#exit', function()
		{
			$(".formulario").slideToggle();
		})

    @if(isset($alert)) 
      {!! $alert !!} 
    @endif 
</script> 
@endsection




