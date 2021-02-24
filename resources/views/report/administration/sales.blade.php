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
	{!! Form::open(['route' => 'reports.administration.sales', 'method' => 'GET']) !!}	
		<div class="card">
			<div class="card-header">
				BÚSQUEDA DE VENTAS
			</div>
			<div class="card-body">
				<div class="form-group">
					<div class="md-form">
						<label class="label-form" for="client_id">Cliente</label>
						<select class="form-control" id="client_id" name="client_id[]" multiple="multiple">
							@foreach(App\Client::orderName()->get() as $client)
								<option value="{{ $client->id }}" @if(isset($client_id) && in_array($client->id, $client_id)) selected="selected" @endif>{{ $client->fullName() }}</option>
							@endforeach
						</select>
					</div>
					<div class="md-form">
						<label class="label-form" for="product_id">Producto</label>
						<select class="form-control" id="product_id" name="product_id[]" multiple="multiple">
							@foreach(App\Products::where('products.status',1)->orderDescription()->get() as $cat)
								<option value="{{ $cat->id }}" @if(isset($product_id) && in_array($cat->id, $product_id)) selected="selected" @endif>{{ $cat->nameProduct() }}</option>
							@endforeach
						</select>
					</div>
					<div class="md-form">
						<input type="text" class="input-text" id="mindate" name="mindate" @if(isset($mindate)) value="{{ $mindate }}" @endif placeholder="Fecha Inicial"> -
						<input type="text" class="input-text" id="maxdate" name="maxdate" @if(isset($maxdate)) value="{{ $maxdate }}" @endif placeholder="Fecha Final">
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
	@if(count($sales) > 0)
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="text-align-center thead-dark">
					<tr>
						<th>No. venta</th>
						<th>Cliente</th>
						<th>Total de Productos</th>
						<th>Total</th>
						<th>Fecha</th>
					</tr>
				</thead>
				<tbody class="text-align-center">
					@foreach($sales as $sale)
						<tr>
							<td>
								{{ $sale->id }}
							</td>
							<td>
								{{ $sale->clientData->fullName() }}
							</td>
							<td>
								{{ $sale->detail->sum('quantity') }}
							</td>
							<td>
								${{ number_format($sale->total,2) }}
							</td>
							<td>
								{{ $sale->created_at }}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
		<center>
			{{ $sales->appends([
				'mindate' 		=> $mindate,
				'maxdate' 		=> $maxdate,
				'product_id' 	=> $product_id,
				'client_id' 	=> $client_id
				])->render() }}
		</center>
		<p><br></p>	
		<div class="card">
			<div class="card-header text-white bg-green">
				GRÁFICAS
				<p>A continuación se muestra un resumen de las ventas del año y la cantidad de producto vendidos</p>
			</div>
		</div>
		<div class="content-chart">
			<div class="chart chart_sales_year"></div>
			<div class="chart chart_sales_product"></div>
			<div class="chart chart_total_month"></div>
		</div>
	@else
		<div class="alert alert-danger" role="alert">Resultado no encontrado</div>
	@endif
	<br><br>
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
			salesForMonth();
			chartTotalProductSold();
			chartTotalSold();
			$(function() 
			{
				$("#mindate,#maxdate").datepicker({ dateFormat: "yy-mm-dd" });
			});
			$('#client_id').select2(
			{
				placeholder				: 'Cliente',
				language				: "es",
				width 					: "100%"
			});
			$('#product_id').select2(
			{
				placeholder				: 'Producto',
				language				: "es",
				width 					: "100%"
			});
		});

		function chartTotalProductSold()
		{
			var options = 
			{
			  	series: [{
				  	name: 'Total',
				  	data: 
					[
						@foreach($productSold['total'] as $total)
							{{ $total }},
						@endforeach
					]
				}],
				chart: 
				{
				  	height: 350,
				  	type: 'bar',
				},
				plotOptions: 
				{
				  	bar: 
				  	{
						dataLabels: 
						{
					  		position: 'center', // top, center, bottom
						},
				  	}
				},
				dataLabels: 
				{
				  	enabled: true,
				  	offsetY: 0,
				  	style: 
				  	{
						fontSize: '12px',
						colors: ["#fff"]
				  	}
				},
			
				xaxis: 
				{
				  	categories: [
						@foreach($productSold['name'] as $name)
							'{{ $name }}',
						@endforeach
				  	],
				  	axisBorder: 
				  	{
						show: false
				  	},
				  	axisTicks: 
				  	{
						show: false
				  	},
				  	crosshairs: 
				  	{
						fill: 
						{
						  	type: 'gradient',
						  	gradient: 
						  	{
								colorFrom: '#D8E3F0',
								colorTo: '#BED1E6',
								stops: [0, 100],
								opacityFrom: 0.4,
								opacityTo: 0.5,
						  	}
						}
				  	},
				  	tooltip: 
				  	{
						enabled: true,
				  	}
				},
				yaxis: 
				{
					axisBorder: 
					{
						show: false
					},
					axisTicks: 
					{
						show: false,
					},
				
				},
				title: 
				{
					text: 'Total de Productos Vendidos',
					floating: true,
					offsetY: 0,
					style: 
					{
						color: '#444'
					}
				}
			};

			var chart = new ApexCharts(document.querySelector(".chart_sales_product"), options);
			chart.render();
		}

		function salesForMonth()
		{
			var options = 
			{
			  	series: 
			  	[
					{
						name: "Ventas",
						data: 
						[
							@foreach($salesForMonth['month'] as $countSale)
								{{ $countSale }},
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
			  		text: 'Ventas Por Mes',
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

			var chart = new ApexCharts(document.querySelector(".chart_sales_year"), options);
			chart.render();
		}

		function chartTotalSold()
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
				}
			};

			var chart = new ApexCharts(document.querySelector(".chart_total_month"), options);
			chart.render();
		}
	</script>
@endsection