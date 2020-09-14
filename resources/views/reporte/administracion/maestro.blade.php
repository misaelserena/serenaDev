@extends('layouts.child_module')
@section('data')
{!! Form::open(['route' => 'report.labels.excel', 'method' => 'get', 'id' => 'container-alta','files' => true]) !!}
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
					<label class="label-form">Folio:</label>
				</div>
				<div class="right">
					<p>
						<input type="text" name="folio" class="input-text-search" id="input-search" placeholder="Escribe aquí...">
					</p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Fecha de elaboración:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate" step="1" class="input-text-date datepicker" id="mindate" placeholder="Desde" readonly="readonly"> - <input title="Hasta" type="text" name="maxdate" step="1" id="maxdate" class="input-text-date datepicker" placeholder="Hasta" readonly="readonly"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Fecha de revisión:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate_review" step="1" class="input-text-date datepicker" id="mindate_review" placeholder="Desde" readonly="readonly"> - <input title="Hasta" type="text" name="maxdate_review" step="1" id="maxdate_review" class="input-text-date datepicker" placeholder="Hasta" readonly="readonly"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Fecha de autorización:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate_authorize" step="1" class="input-text-date datepicker" id="mindate_authorize" placeholder="Desde" readonly="readonly"> - <input title="Hasta" type="text" name="maxdate_authorize" step="1" id="maxdate_authorize" class="input-text-date datepicker" placeholder="Hasta" readonly="readonly"></p>
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
					<select title="Empresa" name="enterprise[]" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach(App\Enterprise::orderName()->where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeEnt($option_id)->pluck('enterprise_id'))->get() as $enterprise)
							<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Dirección" class="js-area" multiple="multiple" name="area[]" style="width: 98%; max-width: 150px;">
						@foreach(App\Area::orderName()->where('status','ACTIVE')->get() as $area)
							<option value="{{ $area->id }}">{{ $area->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Departamento" class="js-department" multiple="multiple" name="department[]" style="width: 98%; max-width: 150px;">
						@foreach(App\Departament::orderName()->where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeDep($option_id)->pluck('departament_id'))->get() as $department)
							<option value="{{ $department->id }}">{{ $department->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<select class="js-projects removeselect" name="project[]" multiple="multiple" style="width: 98%;" id="multiple-projects">
					@foreach(App\Project::orderName()->get() as $project)
							<option value="{{ $project->idproyect }}">{{ $project->proyectName }}</option>
					@endforeach
				</select><br>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Etiquetas" name="labels[]" class="js-labels" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach (App\Label::orderName()->get() as $l)
								<option value="{{ $l->idlabels }}">{{ $l->description }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select name="kind[]" class="js-kind" multiple="multiple" style="width: 98%; max-width: 350px;">
						@foreach(App\RequestKind::orderName()->whereIn('idrequestkind',[1,2,3,8,9,11,12,13,14,15,16,17])->get() as $k)
							<option value="{{ $k->idrequestkind }}">{{ $k->kind }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Estado de Solicitud" name="status[]" class="js-status" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach (App\StatusRequest::orderName()->whereIn('idrequestStatus',[4,5,6,7,10,11,12,13])->get() as $s)
								<option value="{{ $s->idrequestStatus }}">{{ $s->description }}</option>
						@endforeach
					</select>
				</p>
			</div>
		</div>
	</center>
	<center>
		<button class="btn 	btn-search send" type="submit" title="Exportar"><span class="icon-search"></span> Exportar</button> 
	</center>
	<br><br>
</div>
{!! Form::close() !!}
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
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('input[name="folio"]').numeric(false);
		$('.js-labels').select2(
		{
			placeholder : 'Seleccione una o varias etiquetas',
			language 	: 'es',
		});
		$('.js-kind').select2(
		{
			placeholder : 'Seleccione una o varias solicitudes',
			language 	: 'es',
		});
		$('.js-status').select2(
		{
			placeholder : 'Seleccione uno o varios estados',
			language 	: 'es',
		});
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione una o varias empresas',
			language 	: 'es',
		});
		$('.js-area').select2(
		{
			placeholder : 'Seleccione la dirección',
			language 	: 'es',
		});
		$('.js-department').select2(
		{
			placeholder : 'Seleccione el departamento',
			language 	: 'es',
		});
		$('.js-projects').select2(
		{
			placeholder : 'Seleccione el proyecto',
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
			url  : '{{ url("/report/administration/purchase/detail") }}',
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
	/*.on('click','.send', function()
	{
		idDepartment	= $('select[name="idDepartment"] option:selected').val();
		idArea			= $('select[name="idArea"] option:selected').val();
		idEnterprise	= $('select[name="idEnterprise"] option:selected').val();
		account			= $('select[name="account"] option:selected').val();
		stat			= $('.js-status').val();
		name			= $('input[name="name"]').val();
		mindate			= $('input[name="mindate"]').val();
		maxdate			= $('input[name="maxdate"]').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/purchase/table") }}',
			data : {'idEnterprise'	:idEnterprise,
					'idArea'		:idArea,
					'idDepartment'	:idDepartment,
					'account'		:account,
					'name'			:name,
					'stat' 			:stat,
					'mindate'		:mindate,
					'maxdate'		:maxdate},
			success : function(data)
			{
				$('#table-return').html(data);
			}
		})
	})*/
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


