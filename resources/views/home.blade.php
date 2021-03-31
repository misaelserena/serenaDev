@extends('layouts.layout')

@section('title', 'Inicio')
@section('css')
	<style type="text/css">
		body
		{
			background-color: rgba(176, 176, 176, 0.15) !important;
		}
	</style>
@endsection

@section('content')
	
		<div class="container-icon-dashboard">
			<div class="icon-dashboard-blue">
				<div class="icon-dashboard">
					<i class="fas fa-money-bill-alt"></i>
				</div>
				<div class="text-dashboard">
					<label>Total Vendido <br> ${{ number_format($dashboard['total_month']) }}</label>
				</div>
				<br>
			</div>

			<div class="icon-dashboard-brown">
				<div class="icon-dashboard">
					<i class="fas fa-box"></i>
				</div>
				<div class="text-dashboard">
					<label><a style="text-decoration: none !important; color: white;" href="{{ url('sales/product/edit?shipping_status=0') }}">Envío Pendiente <br> {{ $dashboard['shipping_pend'] }}</a></label>
				</div>
				<br>
			</div>
		</div>
		<hr>
		<section class="background-white-border-radius-p15">
			Somos un negocio dedicado a la venta de café.
			<br><br>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			<br><br>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</section>
		<p><br></p>
		<div class="container-charts">
			<div class="row">
				<div class="sales_month col charts-dashboard"></div>
				<div class="total_sold_month col charts-dashboard"></div>
				<div class="utility_year col charts-dashboard"></div>
				<div class="chart_total_year col charts-dashboard"></div>
			</div>
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
			product();
			circleSold();
			chartTotalSoldYear();
			utilityYear();
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
		function product()
		{
			var options = 
			{
				series: 
				[
					@foreach($product as $prod)
						{
							name: "{{ $prod['description'] }}",
							data: 
							[
								{{ $prod['quantity'] }},
							]
						},
					@endforeach
				],
				chart: 
				{
					height: 350,
					width: 460,
					type: 'bar',
					zoom: 
					{
						enabled: false
					}
				},
				dataLabels: 
				{
					enabled: true
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
					text: 'Productos vendidos del mes',
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
					categories: [
						''
					]
				},
				yaxis: 
				{
					title: 
					{
						text: 'Cantidad de productos'
					},
				}
			};

			var chart = new ApexCharts(document.querySelector(".sales_month"), options);
			chart.render();
		}

		function circleSold() 
		{
			var options = 
			{
				series: 
				[
					@foreach($product as $prod)
						{
							name: "{{ $prod['description'] }}",
							data: 
							[
								{{ $prod['totalSold'] }},
							]
						},
					@endforeach
				],
				chart: 
				{
					height: 350,
					width: 460,
					type: 'bar',
					zoom: 
					{
						enabled: false
					}
				},
				dataLabels: 
				{
					enabled: true
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
					text: 'Total vendido por producto',
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
					categories: [
						''
					]
				},
				yaxis: 
				{
					title: 
					{
						text: 'Pesos'
					},
				}
			};

			var chart = new ApexCharts(document.querySelector(".total_sold_month"), options);
			chart.render();
		}

		function chartTotalSoldYear()
		{
			var options = 
			{
				series: 
				[
					{
						name: "Total",
						data: 
						[
							@foreach($salesForMonth['totalSold'] as $countSale)
								{{ $countSale }},
							@endforeach
						]
					}
				],
				chart: 
				{
					height: 350,
					width: 460,
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
					text: 'Total Vendido Por Mes',
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
				},
				yaxis: 
				{
					title: 
					{
						text: 'Pesos'
					},
				}
			};

			var chart = new ApexCharts(document.querySelector(".chart_total_year"), options);
			chart.render();
		}

		function utilityYear() 
		{
			var options = 
			{
				series: 
				[
					{
						name: "Entradas",
						data: 
						[
							{{ $dataYear['entradas'] }},
						]
					},
					{
						name: "Salidas",
						data: 
						[
							{{ $dataYear['salidas'] }},
						]
					},
					{
						name: "Utilidad",
						data: 
						[
							{{ $dataYear['utilidad'] }},
						]
					},
				],
				chart: 
				{
					height: 350,
					width: 460,
					type: 'bar',
					zoom: 
					{
						enabled: false
					}
				},
				dataLabels: 
				{
					enabled: true
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
					text: 'Entradas vs Salidas Anuales',
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
					categories: [
						''
					]
				},
				yaxis: 
				{
					title: 
					{
						text: 'Pesos'
					},
				}
			};

			var chart = new ApexCharts(document.querySelector(".utility_year"), options);
			chart.render();
		}
	</script>
@endsection	