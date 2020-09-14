@extends('layouts.child_module')
@section('data')
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
					<label class="label-form">Rango de fechas:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate" step="1" class="input-text-date datepicker" id="mindate" placeholder="Desde"> - <input title="Hasta" type="text" name="maxdate" step="1" id="maxdate" class="input-text-date datepicker" placeholder="Hasta"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Solicitante:</label>
				</div>
				<div class="right">
					<p><input title="Solicitante" type="text" name="name" class="input-text-search name" id="input-search" placeholder="Nombre del solicitante..."></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Empresa" name="idEnterprise" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach(App\Enterprise::orderName()->get() as $enterprise)
						<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Proyecto" class="js-project" multiple="multiple" name="idArea" style="width: 98%; max-width: 150px;">
						@foreach(App\Project::orderName()->where('status',1)->get() as $project)
							<option value="{{ $project->idproyect }}">{{ $project->proyectName }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Estado de Solicitud" name="status" class="js-status" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach (App\StatusRequest::orderName()->whereIn('idrequestStatus',[4,5,10,11,12])->get() as $s)
								<option value="{{ $s->idrequestStatus }}">{{ $s->description }}</option>
						@endforeach
					</select>
				</p>
			</div>
		</div>
	</center>
	<center>
		<button class="btn 	btn-search send" type="button" title="Buscar"><span class="icon-search"></span> Buscar</button> 
	</center>
	<br><br>
</div>

<br>
<div id="table-return">
	
</div>

<div id="myModal" class="modal">

</div>
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
			placeholder : 'Seleccione la empresa',
			language 	: 'es',

		});
		$('.js-project').select2(
		{
			placeholder : 'Seleccione un proyecto',
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

		$folio = $(this).parents('tr').find('.folio').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/finance/income/detail") }}',
			data : {'folio':$folio},
			success : function(data)
			{
				$('#myModal').show().html(data);
				//$('#detail').slideDown().html(data);
				//$('#table-purchase').slideUp();
				$('.detail').attr('disabled','disabled');
			}
		})
	})
	.on('click','.send', function()
	{
		idProject			= $('.js-project').val();
		idEnterprise	= $('.js-enterprise').val();
		stat			= $('.js-status').val();
		name			= $('input[name="name"]').val();
		mindate			= $('input[name="mindate"]').val();
		maxdate			= $('input[name="maxdate"]').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/finance/income/table") }}',
			data : {'idEnterprise'	:idEnterprise,
					'idProject'		:idProject,
					'name'			:name,
					'stat' 			:stat,
					'mindate'		:mindate,
					'maxdate'		:maxdate},
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
	});
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


