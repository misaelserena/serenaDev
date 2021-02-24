@extends('layouts.child_module')

@section('css')
	<style type="text/css">
		.content-chart
		{
			display			: flex;
			flex-wrap		: wrap;
			max-width		: 100%;
			flex-direction	: row;
		}
		.chart
		{
			padding		: 10px;
			width		: 495px;
			max-width	: 100%;
		}
	</style>
@endsection
@section('data')
	@php
		$listMonths = [
			1	=> 'Enero',
			2	=> 'Febrero',
			3	=> 'Marzo',
			4	=> 'Abril',
			5	=> 'Mayo',
			6	=> 'Junio',
			7	=> 'Julio',
			8	=> 'Agosto',
			9	=> 'Septiembre',
			10	=> 'Octubre',
			11	=> 'Noviembre',
			12	=> 'Diciembre'
 		]
	@endphp
	{!! Form::open(['route' => 'reports.administration.inputs-outputs', 'method' => 'GET']) !!}	
		<div class="card">
			<div class="card-header">
				BÚSQUEDA DE VENTAS
			</div>
			<div class="card-body">
				<div class="form-group">
					<div class="md-form">
						<label class="label-form" for="year">Año</label>
						<select class="form-control" id="year" name="year[]" multiple="multiple">
							<option value="2021">2021</option>
						</select>
					</div>
					<div class="md-form">
						<label class="label-form" for="month">Mes</label>
						<select class="form-control" id="month" name="month[]" multiple="multiple">
							@for($i=1; $i<13;$i++)
								<option value="{{ $i }}">{{ $listMonths[$i] }}</option>
							@endfor
						</select>
					</div>
				</div>
				<button class="btn btn-warning" type="submit">
					<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#download") }}"></use></svg> Exportar
				</button>
				<button class="btn btn-success" type="submit">
					<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
				</button>
			</div>
		</div>
	{!! Form::close() !!}
	<p><br></p>
	<div class="input_output">
		
	</div>
@endsection
@section('scripts')
	<script type="text/javascript">
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function()
		{
			inputsOutputs();
			$(function() 
			{
				$("#mindate,#maxdate").datepicker({ dateFormat: "yy-mm-dd" });
			});
			$('#month').select2(
			{
				placeholder				: 'Mes',
				language				: "es",
				width 					: "100%"
			});
			$('#year').select2(
			{
				placeholder				: 'Año',
				language				: "es",
				width 					: "100%"
			});
		});

		function inputsOutputs()
		{
			var options = 
			{
			  	series: 
			  	[
					{
						name: "Salidas",
						data: 
						[
							@foreach($dataIntOut['outputs'] as $output)
								{{ $output }},
							@endforeach
						]
					},
					{
						name: "Entradas",
						data: 
						[
							@foreach($dataIntOut['inputs'] as $input)
								{{ $input }},
							@endforeach
						]
					},
					{
						name: "Utilidad",
						data: 
						[
							@foreach($dataIntOut['utility'] as $utility)
								{{ $utility }},
							@endforeach
						]
					}
				],
			  	chart: 
			  	{
				  	height: 350,
				  	type: 'line',
				  	zoom: 
				  	{
						enabled: false
				 	}
				},
				dataLabels: 
				{
			  		enabled: false
				},
				stroke: 
				{
			  		curve: 'straight'
				},
				markers: 
				{
					size: 4,
				},
				title: 
				{
			  		text: 'Entradas vs Salidas',
			  		align: 'left'
				},
				grid: 
				{
				  	row: 
				  	{
						colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
						opacity: 0.5
				  	},
				},
				xaxis: 
				{
			  		categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep','Oct','Nov','Dic'],
				}
			};

			var chart = new ApexCharts(document.querySelector(".input_output"), options);
			chart.render();
		}

		
	</script>
@endsection