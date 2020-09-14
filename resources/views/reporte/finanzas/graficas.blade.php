@extends('layouts.child_module')

@section('css')
	<style type="text/css">
		.height-auto
		{
			height: auto !important;
		}
		.profile-table-center-new
		{
			border: 1px solid #c6c6c6;
			margin: 2em auto;
			/* max-width: 600px; */
			width: 100%;
			border-radius: 5px;
		}
	</style>
@endsection

@section('data')
<div class="table-responsive">
	<table id="table" class="table" style="min-width: 100%;">
		<thead class="thead-dark">
			<th colspan="4">FILTROS APLICADOS</th>
		</thead>
		<tbody>
			<tr>
				<td colspan="1"><b>Empresa:</b></td>
				<td colspan="3">
					<p style="text-align: left;">
						<select class="js-enterprise-excel form-control" multiple="multiple" disabled="disabled">
							@foreach(App\Enterprise::where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeEnt($option_id)->pluck('enterprise_id'))->orderBy('name','asc')->get() as $ent)
								<option value="{{ $ent->id }}" @if(isset($enterprise) && $ent->id==$enterprise) selected="selected" @endif>{{ strlen($ent->name) >= 35 ? substr(strip_tags($ent->name),0,35).'...' : $ent->name }}</option>
							@endforeach
						</select><br>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="1"><b>Cuentas:</b></td>
				<td colspan="3">
					<p style="text-align: left;">
						<select class="js-account-excel form-control" multiple="multiple" disabled="disabled">
							@foreach(App\GroupingAccount::where('idEnterprise',$enterprise)->orderBy('name')->get() as $group)
								<option value="{{ $group->id }}" @if(isset($account) && in_array($group->id, $account)) selected="selected" @endif>{{ $group->name }}</option>
							@endforeach
						</select><br>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="1"><b>Proyecto:</b></td>
				<td colspan="3">
					<p style="text-align: left;">
						<select class="js-projects-excel form-control" multiple="multiple" disabled="disabled">
							@foreach(App\Project::whereIn('status',[1,2])->orderBy('proyectName','asc')->get() as $pro)
								<option value="{{ $pro->idproyect }}" @if(isset($project) && in_array($pro->idproyect, $project)) selected="selected" @endif>{{ strlen($pro->proyectName ) >= 25 ? substr(strip_tags($pro->proyectName),0,25).'...' : $pro->proyectName }}</option>
							@endforeach
						</select><br>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="1"><b>Años:</b></td>
				<td>
					<p style="text-align: left;">
						<select class="form-control year-excel" data-validation="required" multiple="multiple" disabled="disabled">
							@for($y = 2019; $y<= date("Y"); $y++)
								<option value="{{ $y }}" @if(isset($year) && in_array($y, $year)) selected="selected" @endif>{{ $y }}</option>
							@endfor
						</select>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="1"><b>Meses:</b></td>
				<td colspan="3">
					@php
						$months = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
					@endphp
					<p style="text-align: left;">
						<select class="form-control month-excel" data-validation="required" multiple="multiple" disabled="disabled">
							@for($m = 1; $m <= 12; $m++)
								<option value="{{ $m }}" @if(isset($month) && in_array($m, $month)) selected="selected" @endif>{{ $months[$m] }}</option>
							@endfor
						</select>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<p><br></p>
<div class="table-responsive">
	@foreach($year as $key=>$valYear)
		<div style="border: 8px solid #efefef; border-radius: 10px; padding: 15px;" id="accountsChartCircle_{{ $valYear }}"></div><br><br>
	@endforeach
</div>
<div id="chart-container"></div>
@endsection

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/apexcharts.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript"> 
	$(document).ready(function()
	{
		@foreach($year as $key=>$valYear)
			accountsChartCircle{{ $valYear }}();
		@endforeach
		$('.js-enterprise-excel').select2(
		{
			placeholder				: 'Seleccione la empresa',
			language				: 'es',
			maximumSelectionLength	: 1,

		});
		$('.js-projects-excel').select2(
		{
			placeholder : 'Seleccione uno o varios proyectos (Opcional)',
			language 	: 'es',
		});
		$('.year-excel').select2(
		{
			placeholder : 'Seleccione uno o varios años',
			language 	: 'es',
		});
		$('.month-excel').select2(
		{
			placeholder : 'Seleccione uno o varios meses',
			language 	: 'es',
		});
		$('.js-account-excel').select2(
		{
			placeholder : 'Seleccione la cuenta',
			language 	: 'es',
		});
	});


	@foreach($year as $key=>$valYear)
		@php
			$data = [];
			$count = 0;
			$total = 0;
		@endphp
		@foreach($groupingDesg as $key=>$valGroup)
			@php
				$data[$count]['name']				= $valGroup['name'];
				$data[$count]['total_'.$valYear]	= round($valGroup['total_'.$valYear],2);
				$total += round($valGroup['total_'.$valYear],2);
				$count++;
			@endphp
		@endforeach
		function accountsChartCircle{{ $valYear }}() 
		{
			var options = 
			{
				series	: [
					@foreach($data as $d)
						{{ round($d['total_'.$valYear],2) }},
					@endforeach
				],
				colors:
				[
					'#f44336','#b02466','#9c27b0','#673ab7','#3f51b5','#2196f3','#34418e','#00bcd4','#009688','#4caf50','#18aa71','#cddc39','#feb300','#ffc107','#ff9800','#ff5722','#795548','#9e9e9e','#607d8b'
				],
				chart	: 
				{
					type	: 'donut',
					toolbar: 
					{
						show			: true,
						offsetX			: 0,
						offsetY			: 0,
						tools			: 
						{
							download		: '<img src="{{ asset('images/charts/download.png') }}" class="ico-download" width="20">'

						},
			     	},
		        },
		        plotOptions: 
		        {
			        pie: 
			        {
			            donut: 
			            {
							size	: '60%',
							labels	: 
			              	{
			                	show: true,
			                	total: 
								{
									show		: true,
									showAlways	: true,
									label		: 'Total',
									fontSize	: '22px',
									fontFamily	: 'Helvetica, Arial, sans-serif',
									fontWeight	: 600,
									color		: '#373d3f',
									formatter	: function (w) 
						          	{
						            	return w.globals.seriesTotals.reduce((a, b) => 
						            	{
						              		return '${{ number_format($total,2) }}'
						            	}, 0)
						          	}
						        }
			              	}
			            }
			        }
			    },
	       		labels 	: [
					@foreach($data as $d)
						'{{ $d['name'] }} - ${{ number_format($d['total_'.$valYear],2) }}',
					@endforeach
				],
	       		title: 
	       		{
					text		: '{{ App\Enterprise::find($enterprise)->name }}',
					align		: 'left',
					margin		: 10,
					offsetX		: 0,
					offsetY		: 0,
					floating	: false,
				    style 		: 
				    {
						fontSize	:  '18px',
						fontWeight	:  'bold',
						fontFamily	:  undefined,
						color		:  '#263238'
				    },
				},
				subtitle:
				{
					text		: 'Año {{ $valYear }}',
					align		: 'left',
					style 		:
					{
						fontSize	:  '16px',
						fontWeight	:  'bold',
						fontFamily	:  undefined,
						color		:  '#263238'
				    },
				},
	        	responsive 	: 
	        	[{
	          		breakpoint	: 480,
	          		options 	: 
	          		{
	            		chart: 
	            		{
	             			width: 200
	            		},
	            		legend: 
	            		{
	              			position: 'bottom'
	            		}
	          		}
	        	}]
	        };

	        chart = new ApexCharts(document.querySelector("#accountsChartCircle_{{ $valYear }}"), options);
	        chart.render();
		}
	@endforeach

	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


