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
	<form action="{{route('report.finance.global.export')}}" method="POST">
		@csrf
		<center>
			<div class="search-table-center">
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
						<p><input title="Solicitante" type="text" name="name" class="input-text-search name" id="input-search" placeholder="Nombre del solicitante..."></p>
					</div>
				</div>
				<div class="search-table-center-row">
					<p>
						<select name="kind[]" class="js-kind" multiple="multiple" style="width: 98%; max-width: 350px;">
							@foreach(App\RequestKind::orderName()->whereIn('idrequestkind',[1,8,9,16,17,18])->get() as $k)
								<option value="{{ $k->idrequestkind }}" @if(isset($kind) && in_array($k->idrequestkind, $kind)) selected="selected" @endif >{{ $k->kind }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Empresa" name="idEnterprise[]" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
							@foreach(App\Enterprise::orderName()->whereIn('id',Auth::user()->inChargeEnt($option_id)->pluck('enterprise_id'))->get() as $e)
								<option value="{{ $e->id }}" @if(isset($enterprise) && in_array($e->id, $enterprise)) selected="selected" @endif>{{ strlen($e->name) >= 35 ? substr(strip_tags($e->name),0,35).'...' : $e->name }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Dirección" class="js-area" multiple="multiple" name="idArea[]" style="width: 98%; max-width: 150px;">
							@foreach(App\Area::orderName()->where('status','ACTIVE')->get() as $area)
								<option value="{{ $area->id }}" @if(isset($direction) && in_array($area->id, $direction)) selected="selected" @endif>{{ $area->name }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Departamento" class="js-department" multiple="multiple" name="idDepartment[]" style="width: 98%; max-width: 150px;">
							@foreach(App\Departament::orderName()->where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeDep($option_id)->pluck('departament_id'))->get() as $d)
								<option value="{{ $d->id }}" @if(isset($department) && in_array($d->id, $department)) selected="selected" @endif>{{ $d->name }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Estado de Solicitud" name="status[]" class="js-status" multiple="multiple" style="width: 98%; max-width: 150px;">
							@foreach (App\StatusRequest::orderName()->whereIn('idrequestStatus',[5,10,11,12])->get() as $s)
									<option value="{{ $s->idrequestStatus }}">{{ $s->description }}</option>
							@endforeach
						</select>
					</p>
				</div>
			</div>
		</center>
		<center>
			<button class="btn btn-search" type="submit" title="Exportar"><span class="icon-search"></span> Exportar</button> 
		</center>
	</form>
	<br><br>
</div>

<br>
<div id="table-return">
	
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
		$('.js-status').select2(
		{
			placeholder : 'Seleccione un estado de solicitud',
			language 	: 'es',
		});
		$('.js-kind').select2(
		{
			placeholder : 'Seleccione un tipo de solicitud',
			language 	: 'es',
		});
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


