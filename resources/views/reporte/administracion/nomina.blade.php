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
{!! Form::open(['route' => 'report.nomina','method' => 'get', 'id' => 'container-alta','files' => true]) !!}
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
					<label class="label-form">Tipo de reporte</label>
				</div>
				<div class="right">
					<p>
						<input type="radio" class="checkbox" name="type_report" value="1" id="normal" checked>
						<label for="normal">Normal</label>
						<input type="radio" class="checkbox" name="type_report" value="2" id="reducido">
						<label for="reducido">Reducido</label>
					</p>
				</div>
			</div><br>
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
						<input type="text" name="titleRequest" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($titleRequest) ? $titleRequest : '' }}">
					</p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Solicitante:</label>
				</div>
				<div class="right">
					<p>
						<input type="text" name="name" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($name) ? $name : '' }}">
					</p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Rango de fechas:</label>
				</div>
				<div class="right-date">
					<p>
						<input type="text" name="mindate" value="{{ isset($mindate) ? $mindate : '' }}" step="1" class="input-text-date datepicker" placeholder="Desde"> - <input type="text" name="maxdate" value="{{ isset($maxdate) ? $maxdate : '' }}" step="1" class="input-text-date datepicker" placeholder="Hasta">
					</p>
				</div>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Tipo de nómina" name="type_payroll[]" class="js-typepayroll" multiple="multiple" style="width: 98%;">
						@foreach(App\CatTypePayroll::orderName()->get() as $t)
							<option value="{{ $t->id }}" @if(isset($typePayroll) && in_array($t->id, $typePayroll)) selected="selected" @endif>{{ $t->description }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Departamento" name="department[]" class="js-department" multiple="multiple" style="width: 98%; max-width: 150px;">
						<option value="4" @if(isset($department) && in_array(4,$department)) selected="selected" @endif>Administrativa</option>
						<option value="11" @if(isset($department) && in_array(11,$department)) selected="selected" @endif>Obra</option>
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Fiscal/No Fiscal" class="js-fiscal" multiple="multiple" name="fiscal[]" style="width: 98%; max-width: 150px;">
						<option @if(isset($fiscal) && in_array(1, $fiscal)) selected="selected" @endif value="1">Fiscal</option>
						<option @if(isset($fiscal) && in_array(0, $fiscal)) selected="selected" @endif value="0">No Fiscal</option>	
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
		<button class="btn 	btn-search send" type="submit" title="Buscar"><span class="icon-search"></span> Buscar</button> 
	</center>
	<br><br>
</div>
@if(count($requests)>0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.nomina.excel') }}"><span class='icon-file-excel'></span></button></div>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="thead-dark">
				<th width="5%">Folio</th>
				<th width="10%">Estado</th>
				<th width="15%">Título</th>
				<th width="10%">Categoria</th>
				<th width="5%">Tipo</th>
				<th width="20%">Solicitante</th>
				<th width="10%">Fecha de elaboración</th>
				<th width="8%">Acción</th>
				<th width="9%">Comprobantes</th>
				<th width="9%">Timbres</th>
				
			</thead>
			@foreach($requests as $request)
				<tr>
					<td><input type="hidden" class="folio" value="{{ $request->folio }}">{{ $request->folio }}</td>
					<td>{{ $request->statusrequest->description }}</td>
					<td>{{ $request->nominasReal->first()->title != null ? $request->nominasReal->first()->title : 'No hay' }}</td>
					<td>{{ $request->idDepartment == 4 ? 'Administrativa' : 'Obra' }} - {{ $request->taxPayment == 1 ? 'Fiscal' : 'No fiscal' }}</td>
					<td>{{ $request->nominasReal->first()->typePayroll->description }}</td>
					<td>{{ $request->requestUser()->exists() ? $request->requestUser->name.' '.$request->requestUser->last_name : 'No hay' }}</td>
					@php	
						$time	= strtotime($request->fDate);
						$date	= date('d-m-Y H:i',$time);
					@endphp 
					<td>{{ $date  }}</td>
					<td>
						<a alt="Ver nómina" title="Ver nómina" class='btn follow-btn view-nomina'><span class='icon-search'></span></a>
					</td>
					<td>
						<a alt="Descargar comprobantes de pago" title="Descargar comprobantes de pago" class="btn follow-btn" href="{{route('report.nomina.payments',$request->folio)}}">
							<svg viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
								<path d="M456,88L240,88L240,80C239.975,58.066 221.934,40.025 200,40L56,40C34.066,40.025 16.025,58.066 16,80L16,432C16.025,453.934 34.066,471.975 56,472L456,472C477.934,471.975 495.975,453.934 496,432L496,128C495.975,106.066 477.934,88.025 456,88ZM456,104C469.16,104.015 479.985,114.84 480,128L480,144.022C473.087,138.808 464.658,135.991 456,136L240,136L240,104L456,104ZM480,432C479.985,445.16 469.16,455.985 456,456L56,456C42.84,455.985 32.015,445.16 32,432L32,80C32.015,66.84 42.84,56.015 56,56L120,56L120,88L104,88C99.611,88 96,91.611 96,96C96,100.389 99.611,104 104,104L120,104L120,136L104,136C99.611,136 96,139.611 96,144C96,148.389 99.611,152 104,152L120,152L120,184L104,184C99.611,184 96,187.611 96,192C96,196.389 99.611,200 104,200L120,200L120,232L104,232C99.611,232 96,235.611 96,240C96,244.389 99.611,248 104,248L120,248L120,280L104,280C99.611,280 96,283.611 96,288C96,292.389 99.611,296 104,296L120,296L120,328L116,328C112.427,328.001 109.267,330.395 108.3,333.834L99.386,365.527C97.175,369.554 96.011,374.073 96,378.667C96,394.841 110.355,408 128,408C145.645,408 160,394.841 160,378.667C159.989,374.073 158.825,369.554 156.615,365.527L147.7,333.834C146.733,330.395 143.573,328.001 140,328L136,328L136,296L152,296C156.389,296 160,292.389 160,288C160,283.611 156.389,280 152,280L136,280L136,248L152,248C156.389,248 160,244.389 160,240C160,235.611 156.389,232 152,232L136,232L136,200L152,200C156.389,200 160,196.389 160,192C160,187.611 156.389,184 152,184L136,184L136,152L152,152C156.389,152 160,148.389 160,144C160,139.611 156.389,136 152,136L136,136L136,104L152,104C156.389,104 160,100.389 160,96C160,91.611 156.389,88 152,88L136,88L136,56L200,56C213.16,56.015 223.985,66.84 224,80L224,144C224,148.389 227.611,152 232,152L456,152C469.16,152.015 479.985,162.84 480,176L480,432ZM122.061,344L133.939,344L141.479,370.805C141.672,371.49 141.955,372.147 142.321,372.757C143.413,374.535 143.994,376.58 144,378.667C144,386.019 136.822,392 128,392C119.178,392 112,386.019 112,378.667C112.006,376.58 112.587,374.535 113.679,372.757C114.045,372.147 114.328,371.49 114.521,370.805L122.061,344Z" style="fill-rule:nonzero;"/>
							</svg>
						</a>
					</td>
					<td>
						@if($request->taxPayment == 1)
							<a alt="Descargar comprobantes de pago" title="Descargar comprobantes de pago" class="btn follow-btn" href="{{route('report.nomina.cfdi',$request->folio)}}">
								<svg viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
									<path d="M456,88L240,88L240,80C239.975,58.066 221.934,40.025 200,40L56,40C34.066,40.025 16.025,58.066 16,80L16,432C16.025,453.934 34.066,471.975 56,472L456,472C477.934,471.975 495.975,453.934 496,432L496,128C495.975,106.066 477.934,88.025 456,88ZM456,104C469.16,104.015 479.985,114.84 480,128L480,144.022C473.087,138.808 464.658,135.991 456,136L240,136L240,104L456,104ZM480,432C479.985,445.16 469.16,455.985 456,456L56,456C42.84,455.985 32.015,445.16 32,432L32,80C32.015,66.84 42.84,56.015 56,56L120,56L120,88L104,88C99.611,88 96,91.611 96,96C96,100.389 99.611,104 104,104L120,104L120,136L104,136C99.611,136 96,139.611 96,144C96,148.389 99.611,152 104,152L120,152L120,184L104,184C99.611,184 96,187.611 96,192C96,196.389 99.611,200 104,200L120,200L120,232L104,232C99.611,232 96,235.611 96,240C96,244.389 99.611,248 104,248L120,248L120,280L104,280C99.611,280 96,283.611 96,288C96,292.389 99.611,296 104,296L120,296L120,328L116,328C112.427,328.001 109.267,330.395 108.3,333.834L99.386,365.527C97.175,369.554 96.011,374.073 96,378.667C96,394.841 110.355,408 128,408C145.645,408 160,394.841 160,378.667C159.989,374.073 158.825,369.554 156.615,365.527L147.7,333.834C146.733,330.395 143.573,328.001 140,328L136,328L136,296L152,296C156.389,296 160,292.389 160,288C160,283.611 156.389,280 152,280L136,280L136,248L152,248C156.389,248 160,244.389 160,240C160,235.611 156.389,232 152,232L136,232L136,200L152,200C156.389,200 160,196.389 160,192C160,187.611 156.389,184 152,184L136,184L136,152L152,152C156.389,152 160,148.389 160,144C160,139.611 156.389,136 152,136L136,136L136,104L152,104C156.389,104 160,100.389 160,96C160,91.611 156.389,88 152,88L136,88L136,56L200,56C213.16,56.015 223.985,66.84 224,80L224,144C224,148.389 227.611,152 232,152L456,152C469.16,152.015 479.985,162.84 480,176L480,432ZM122.061,344L133.939,344L141.479,370.805C141.672,371.49 141.955,372.147 142.321,372.757C143.413,374.535 143.994,376.58 144,378.667C144,386.019 136.822,392 128,392C119.178,392 112,386.019 112,378.667C112.006,376.58 112.587,374.535 113.679,372.757C114.045,372.147 114.328,371.49 114.521,370.805L122.061,344Z" style="fill-rule:nonzero;"/>
								</svg>
							</a>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	</div>
	<center>
		{{ $requests->appends([
			'titleRequest'	=> $titleRequest,
			'name'			=> $name,
			'folio'			=> $folio,
			'department'	=> $department,
			'mindate'		=> $mindate,
			'maxdate'		=> $maxdate,
			'fiscal'		=> $fiscal,
			'stat'			=> $stat,
			'typePayroll'	=> $typePayroll,
		])->render() }}
	</center><br><br><br>
	<div id='detail' style='display: none;'></div>
@else
	<div id='not-found' style='display:block;'>Resultado no encontrado</div>
@endif

<br>
<div id="table-return">
	
</div>

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
		$('.js-status').select2(
		{
			placeholder : 'Seleccione un estado de solicitud',
			language 	: 'es',
		});
		$('.js-department').select2(
		{
			placeholder : 'Seleccione la categoria',
			language 	: 'es',

		});
		$('.js-fiscal').select2(
		{
			placeholder : 'Seleccione fiscal/no fiscal',
			language 	: 'es',
		});	
		$('.js-typepayroll').select2(
		{
			placeholder : 'Seleccione el tipo',
			language 	: 'es',
		});	
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "yy-mm-dd" });
		});
	});

	$(document).on('click','.detail', function()
	{

		$folio = $(this).parents('tr').find('.folio').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/nomina/detail") }}',
			data : {'folio':$folio},
			success : function(data)
			{
				$('#myModal').show().html(data);
				//$('#detail').slideDown().html(data);
				//$('#table-payroll').slideUp();
				$('.detail').attr('disabled','disabled');
			}
		})
	})
	.on('click','.send', function()
	{
		titleRequest	= $('input[name="titleRequest"]').val();
		name			= $('input[name="name"]').val();
		folio			= $('input[name="folio"]').val();
		department		= $('.js-department').val();
		fiscal			= $('.js-fiscal').val();
		stat			= $('.js-status').val();
		mindate			= $('input[name="mindate"]').val();
		maxdate			= $('input[name="maxdate"]').val();
		type_payroll 	= $('.js-typepayroll').val();
		type_report 	= $('input[name="type_report"]').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/nomina/table") }}',
			data : {
					'titleRequest'	:titleRequest,
					'name'			:name,
					'folio'			:folio,
					'department'	:department,
					'fiscal'		:fiscal,
					'stat'			:stat,
					'mindate'		:mindate,
					'maxdate'		:maxdate,
					'type_payroll'	:type_payroll,
					'type_report'	:type_report
				},
			success : function(data)
			{
				$('#table-return').html(data);
			}
		})
	})
	.on('click','.exit',function()
	{
		$('#detail').slideUp();
		$('#myModal').hide();
		$('.detail').removeAttr('disabled');
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
		.on('click','.view-nomina',function()
		{
			folio = $(this).parents('tr').find('.folio').val();
			$.ajax(
			{
				type : 'get',
				url  : '{{ url("/report/administration/nomina/detail") }}',
				data : {'folio':folio},
				success : function(data)
				{
					$('#myModal').show().html(data);
					//$('#detail').slideDown().html(data);
					//$('#table-payroll').slideUp();
				}
			})
		})
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


