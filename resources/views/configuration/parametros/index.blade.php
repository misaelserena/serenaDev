@extends('layouts.child_module')
@section('css')
	<style type="text/css">
		.container-blocks-category-parameter
		{
			text-align	: center;
			width		: 100%;
		}
		.container-blocks-category-parameter h2
		{
			background	: -moz-linear-gradient(left,  rgba(23,50,63,1) 0%, rgba(23,50,63,0.9) 56%, rgba(23,50,63,0) 100%);
			background	: -webkit-linear-gradient(left,  rgba(23,50,63,1) 0%,rgba(23,50,63,0.9) 56%,rgba(23,50,63,0) 100%);
			background	: linear-gradient(to right,  rgba(23,50,63,1) 0%,rgba(23,50,63,0.9) 56%,rgba(23,50,63,0) 100%);
			color		: #fff;
			display		: block;
			filter		: progid:DXImageTransform.Microsoft.gradient( startColorstr='#17323f', endColorstr='#0017323f',GradientType=1 );
			font-size	: 1.2rem;
			font-weight	: 600;
			line-height	: 2;
			margin		: 1.5rem 0;
			padding		: 0 .3rem 0 1rem;
			text-align	: left;
			width		: 100%;
		}
		.container-blocks-category-parameter hr
		{
			background-color	: #d7d7d7;
			margin				: 0 auto 0 1rem;
			width				: 90%;
		}
		.form-group
		{
			padding		: .5rem 1rem .5rem 3rem;
			text-align	: left;
		}
		.help-block.form-error
		{
			position	: absolute;
			right		: 0;
			top			: -19px;
		}
		.divisor
		{
			margin-bottom	: 1rem;
		}
	</style>
@endsection
@section('data')
	@php
		$categoryParam		= '';
		$subCategoryParam	= '';
	@endphp
	<form id="parameter_form" action="{{route('parameter.update')}}" method="POST">
		@csrf
		<div class="container-blocks-category-parameter">
			@foreach(App\Parameter::all()->sortBy(function($item) {return $item->category.'-'.$item->sub_category.'-'.$item->parameter_name;}) as $categItem)
				@if($categoryParam != $categItem['category'])
					@php
						$categoryParam	= $categItem['category'];
					@endphp
					<p><br></p>
					<center>
						<strong>{{$categoryParam}}</strong>
					</center>
					<div class="divisor">
						<div class="gray-divisor"></div>
						<div class="orange-divisor"></div>
						<div class="gray-divisor"></div>
					</div>
				@endif
				@if($subCategoryParam != $categItem['sub_category'] && $categItem['sub_category'] != '')
					@php
						$subCategoryParam	= $categItem['sub_category'];
					@endphp
					<h2>{{$subCategoryParam}}</h2>
				@endif
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>{{ $categItem['description'] }}</strong></span>
					</div>
					@if($categItem['prefix'] != '')
						<div class="input-group-prepend">
							<span class="input-group-text">{{$categItem['prefix']}}</span>
						</div>
					@endif
					<input type="text" class="form-control" name="parameter[{{$categItem['parameter_name']}}]" value="{{ $categItem['parameter_value'] }}" @if($categItem['validation'] != ''){!!$categItem['validation']!!}@endif>
					@if($categItem['suffix'] != '')
						<div class="input-group-append">
							<span class="input-group-text">{{$categItem['suffix']}}</span>
						</div>
					@endif
				</div>
			@endforeach
			<p><br></p>
			<center>
				<strong>Tablas de vacaciones</strong>
			</center>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th>Años de servicio</th>
							<th>Días de vacaciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach(App\ParameterVacation::all() as $vac)
							<tr>
								<td>{{$vac->text}}</td>
								<td><input class="input-text" type="text" name="paramVac[{{$vac->id}}]" value="{{$vac->days}}" data-validation="number required"></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<p><br></p>
			<center>
				<strong>LIMITES PARA CALCULO DE ISR</strong>
			</center>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div>
			@php
				$isrArr = [
					['Semanal -7 días','2. Tarifa aplicable cuando hagan pagos que correspondan a un periodo de 7 días.',7],
					['Quincenal','4. Tarifa aplicable cuando hagan pagos que correspondan a un periodo de 15 días.',15],
					['Mensual','5. Tarifa aplicable para el cálculo de los pagos provisionales mensuales.',30]
				];
				$subsidyArr = [
					['Semanal -7 días','2. Subsidio aplicable cuando hagan pagos que correspondan a un periodo de 7 días.',7],
					['Quincenal','4. Subsidio aplicable cuando hagan pagos que correspondan a un periodo de 15 días.',15],
					['Mensual','5. Subsidio aplicable cuando hagan pagos que correspondan a un periodo Mensual.',30]
				];
			@endphp
			@foreach($isrArr as $i)
				<h2>{{$i[0]}}</h2>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th colspan="4">{{$i[1]}}</th>
							</tr>
							<tr>
								<th>Límite inferior</th>
								<th>Límite superior (vacío significa que es «En adelante»)</th>
								<th>Cuota fija</th>
								<th>% SobreExcedente</th>
							</tr>
						</thead>
						<tbody>
							@foreach(App\ParameterISR::where('lapse',$i[2])->get() as $isr)
								<tr>
									<td><input class="input-text" type="text" name="paramIsrInf[{{$isr->id}}]" value="{{$isr->inferior}}" data-validation="number required" data-validation-allowing="float"></td>
									<td><input class="input-text" type="text" name="paramIsrSup[{{$isr->id}}]" value="{{$isr->superior}}" data-validation="number" data-validation-allowing="float" data-validation-optional="true"></td>
									<td><input class="input-text" type="text" name="paramIsrQuo[{{$isr->id}}]" value="{{$isr->quota}}" data-validation="number required" data-validation-allowing="float"></td>
									<td><input class="input-text" type="text" name="paramIsrExc[{{$isr->id}}]" value="{{$isr->excess}}" data-validation="number required" data-validation-allowing="float"></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endforeach
			<p><br></p>
			<center>
				<strong>LIMITES PARA SUBSIDIO</strong>
			</center>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div>
			@foreach($subsidyArr as $i)
				<h2>{{$i[0]}}</h2>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th colspan="4">{{$i[1]}}</th>
							</tr>
							<tr>
								<th>Límite inferior</th>
								<th>Límite superior (vacío significa que es «En adelante»)</th>
								<th>Subsidio</th>
							</tr>
						</thead>
						<tbody>
							@foreach(App\ParameterSubsidy::where('lapse',$i[2])->get() as $sub)
								<tr>
									<td><input class="input-text" type="text" name="paramSubInf[{{$sub->id}}]" value="{{$sub->inferior}}" data-validation="number required" data-validation-allowing="float"></td>
									<td><input class="input-text" type="text" name="paramSubSup[{{$sub->id}}]" value="{{$sub->superior}}" data-validation="number" data-validation-allowing="float" data-validation-optional="true"></td>
									<td><input class="input-text" type="text" name="paramSubSub[{{$sub->id}}]" value="{{$sub->subsidy}}" data-validation="number required" data-validation-allowing="float"></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endforeach
		</div>
		<p><br></p>
		<center>
			<button class="btn btn-green">Actualizar parámetros</button>
		</center>
	</form>
@endsection

@section('scripts')


<script src="{{ asset('js/jquery.numeric.js') }}"></script>

<script>
	$(document).ready(function()
	{
		$("form#parameter_form :input").each(function(){
 			var input = $(this);
		 	
		 	if(input.attr('name') && input.attr('name') !== '_token')
		 		$('input[name="'+input.attr('name')+'"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		});
	});

</script>

@endsection