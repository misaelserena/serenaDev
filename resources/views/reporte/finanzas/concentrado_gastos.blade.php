@extends('layouts.child_module')
@section('css')
	<style type="text/css">
		.all-select
		{
			display	: block;
			margin	: 0 0 0 auto;
		}
		.all-select.select:before
		{
			content: 'Seleccionar';
		}
		.all-select:before
		{
			content: 'Deseleccionar';
		}
		.group
		{
			border			: 3px solid #17323f;
			border-radius	: 10px;
			padding			: 10px;
			background		: #ffffff;
		}
		.group-account
		{
			padding	: 12px;
			margin	: 10px;
			width 	: 150px;
			max-width: 100%;
		}
		.group-year
		{
			display			: flex;
			flex-wrap		: wrap;
			padding			: 15px;
		}
	</style>
@endsection
@section('data')
	@php
		$months = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$containers = '';
	@endphp
	@if(isset($arrayChart))
		<form method="get">
			<div class="group">
				@php
					$nameEnterprise = App\Enterprise::find($enterprise)->name;
				@endphp
				<b>{{ mb_strtoupper($nameEnterprise,'UTF-8') }}</b><br>
				<b>{{ $months[reset($month)] }} - {{$months[end($month)] }}</b>
				<div class="group-year">
					<div class="group-account">
						<label><b>GRÁFICA DE ÁREA</b></label><br>
						<a class="btn follow-btn" id="graph_area" href="#container_graph_area"><img src="{{ asset('images/charts/area.svg') }}" class="img-responsive" width="100"></a>
					</div>
					<div class="group-account">
						<label><b>GRÁFICA DE BARRAS</b></label><br>
						<a class="btn follow-btn" id="graph_bar" href="#container_graph_bar"><img src="{{ asset('images/charts/graph_bar.svg') }}" class="img-responsive" width="100"></a>
					</div>
					<div class="group-account">
						<label><b>ARCHIVO DE EXCEL</b></label><br>
						<button type="submit" class="btn follow-btn" id="export_excel" formaction="{{ route('report.download.excel',$fileName) }}"><img src="{{ asset('images/charts/excel.svg') }}" class="img-responsive" width="100"></button>
					</div>
				</div>
			</div>
		</form>
		<p><br></p>
		@foreach($year as $y)
			<div class="group" id="group_graph">
				@php
					$nameEnterprise = App\Enterprise::find($enterprise)->name;
				@endphp
				<b>{{ mb_strtoupper($nameEnterprise,'UTF-8') }}</b><br>
				<b>{{ $months[reset($month)] }} - {{$months[end($month)] }} {{ $y }}</b>
				<div class="group-year">
					@foreach($account as $acc)
						@php
							$nameAccount = App\Account::where('idEnterprise',$enterprise)->where('account',$acc)->first()->description;
							$containers .= '<div class="hide" id="container_graph_'.$acc.'_'.$y.'"></div><br>';
						@endphp
						<div class="group-account">
							<label><b>{{ mb_strtoupper($nameAccount,'UTF-8') }}</b></label><br>
							<a class="btn follow-btn" id="graph_{{ $acc }}_{{ $y }}" href="#container_graph_{{ $acc }}_{{ $y }}"><img src="{{ asset('images/charts/graphic_circle.svg') }}" class="img-responsive" width="100"></a>
						</div>
					@endforeach
				</div>
			</div>
			<p><br></p>
		@endforeach
		{!! $containers !!}
		<div class="hide" id="container_graph_area"></div><br>
		<div class="hide" id="container_graph_bar"></div><br>
	@else
		<div id="container-cambio" class="div-search">
			<form method='get' action='{{ route('report.expenses-concentrated.result') }}' accept-charset='UTF-8' id='formsearch'>
				<center>
					<strong>BUSCAR</strong>
				</center>
				<div class="divisor">
					<div class="gray-divisor"></div>
					<div class="orange-divisor"></div>
					<div class="gray-divisor"></div>
				</div>
				<center>
					<div class="search-table-center">
						<div>
							<div class="search-table-center-row">
								<p>
									<select title="Empresa" name="enterprise" class="js-enterprise form-control" multiple="multiple" data-validation="required">
										@foreach(App\Enterprise::orderName()->get() as $enterprise)
											<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
										@endforeach
									</select>
								</p>
							</div>
							<div class="search-table-center-row">
								<p>
									<button class="btn btn-green all-select select" type="button" data-target="js-account" disabled="true" id="select_accounts"> todas las cuentas</button>
									<select title="Cuenta" name="account[]" data-validation="required" class="js-account form-control" multiple="multiple">
									</select>
								</p>
							</div>
							<div class="search-table-center-row">
								<p>
									<select title="Proyecto" name="project[]" class="js-projects" multiple="multiple" style="width: 98%; max-width: 150px;">
										@foreach(App\Project::orderName()->where('status',1)->get() as $project)
											<option value="{{ $project->idproyect }}">{{ $project->proyectName }}</option>
										@endforeach
									</select>
								</p>
							</div>
							<div class="search-table-center-row">
								<p>
									<select class="form-control year" data-validation="required" multiple="multiple" name="year[]">
										@for($year = 2019; $year<= date("Y"); $year++)
											<option value="{{ $year }}">{{ $year }}</option>
										@endfor
									</select>
								</p>
							</div>
							<div class="search-table-center-row">
								<p>
									<button class="btn btn-green all-select select" type="button" data-target="month"> todos los meses</button>
									<select class="form-control month" data-validation="required" multiple="multiple" name="month[]">
										@for($month = 1; $month <= 12; $month++)
											<option value="{{ $month }}">{{ $months[$month] }}</option>
										@endfor
									</select>
								</p>
							</div>
							<br>
							<div>
								<center>
									<button class="btn btn-blue" type="submit">OBTENER RESULTADOS</button>
								</center>
							</div>
						</div>
					</div>
				</center>
			</form>
		</div>
	@endif
	<br><br>
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
		$('.js-enterprise').select2(
		{
			placeholder				: 'Seleccione la empresa',
			language				: 'es',
			maximumSelectionLength	: 1,

		});
		$('.js-projects').select2(
		{
			placeholder : 'Seleccione uno o varios proyectos (Opcional)',
			language 	: 'es',
		});
		$('.year').select2(
		{
			placeholder : 'Seleccione uno o varios años',
			language 	: 'es',
		});
		$('.month').select2(
		{
			placeholder : 'Seleccione uno o varios meses',
			language 	: 'es',
		});
		$('.js-account').select2(
		{
			placeholder : 'Seleccione la cuenta',
			language 	: 'es',
		});

		$(document).on('change','.js-enterprise',function()
		{
			$('#select_accounts').prop('disabled',false);
			$('.js-account').empty();
			enterprise	= $(this).val();
			$.ajax(
			{
				type 	: 'get',
				url 	: '{{ url("/report/finance/expenses-concentrated/get-account") }}',
				data 	: {'enterpriseid':enterprise},
				success : function(data)
				{
					$.each(data,function(i, d) 
					{
							$('.js-account').append('<option value='+d.account+'>'+d.description+'</option>');
					});
				},
				error 	: function()
				{
					swal('Error','No se encontraron cuentas','error');
				}
			});
		})
		.on('select2:unselecting','.js-enterprise',function(e)
		{
			e.preventDefault();
			$(this).val(null).trigger('change');
			$('#select_accounts').prop('disabled',true);
		})
		.on('click','.all-select',function()
		{
			target	= '.'+$(this).attr('data-target');
			if($(this).hasClass('select'))
			{
				$(this).removeClass('select');
				$(target+' option').each(function(i,v)
				{
					$(this).prop('selected',true);
					$(target).trigger('change');
				});
			}
			else
			{
				$(this).addClass('select');
				$(target+' option').each(function(i,v)
				{
					$(this).prop('selected',false);
					$(target).trigger('change');
				});
			}
		})
		@if(isset($arrayChart))
			@php
				$arrayDataArea 	= [];
				$count 			= 0;
			@endphp
			@foreach($year as $y)
				@php
					$nameEnterprise				= App\Enterprise::find($enterprise)->name;
					$arrayDataArea['total_'.$y]	= [];
					$arrayDataArea['account']	= [];
				@endphp
				@foreach($account as $acc)
					@php
						$totalAccount 	= 0;
						$nameAccount 	= App\Account::where('idEnterprise',$enterprise)->where('account',$acc)->first()->description;
					@endphp
					.on('click','#graph_{{ $acc }}_{{ $y }}',function()
					{
						$('.hide').hide();
						$('#container_graph_{{ $acc }}_{{ $y }}').empty();
						var options = 
						{
							series	: [
								@foreach ($accountRegister as $a)
									@if ($a['selectable_'.$y] == 0 && $a['level_'.$y] == 3 && ($a['father_'.$y]==$acc || $a['account_'.$y]==$acc))
										{{ round($total[$a['account_'.$y].'_'.$y],2) }},
										@php
											$totalAccount += round($total[$a['account_'.$y].'_'.$y],2);
										@endphp
									@endif
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
														return '${{ number_format($totalAccount,2) }}'
													}, 0)
												}
											}
										}
									}
								}
							},
							labels 	: [
								@foreach ($accountRegister as $a)
									@if ($a['selectable_'.$y] == 0 && $a['level_'.$y] == 3 && ($a['father_'.$y]==$acc || $a['account_'.$y]==$acc))
										'{{ mb_strtoupper($a['description_'.$y], 'UTF-8') }} - ${{ number_format($total[$a['account_'.$y].'_'.$y],2) }}',
									@endif
								@endforeach
							],
							title: 
							{
								text		: '{{ $nameEnterprise }}',
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
								text		: '{{ $nameAccount }} - Periodo {{ $months[reset($month)] }} a {{$months[end($month)] }} {{ $y }}',
								align		: 'left',
								style 		:
								{
									fontSize	:  '16px',
									fontWeight	:  'bold',
									fontFamily	:  undefined,
									color		:  '#263238'
								},
							},
							tooltip: 
							{
								y: 
								{
									formatter: function (val) 
									{
										return "$" + new Intl.NumberFormat().format(val) + ""
									}
								}
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

						$('#container_graph_{{ $acc }}_{{ $y }}').show();
						chart = new ApexCharts(document.querySelector("#container_graph_{{ $acc }}_{{ $y }}"), options);
						chart.render();
					})
					@php
						array_push($arrayDataArea['total_'.$y], round($totalAccount,2));
						array_push($arrayDataArea['account'], $nameAccount);
						$count++;
					@endphp
				@endforeach
			@endforeach
			.on('click','#graph_area',function()
			{
				$('.hide').hide();
				var options = 
				{
					series: [
						@foreach($year as $y)
							{
								name: '{{ $y }}',
								data: [
									@foreach($arrayDataArea['total_'.$y] as $data)
										{{ $data }},
									@endforeach
								],
							},
						@endforeach
					],
					chart: 
					{
						height: 350,
						type: 'area'
					},
					dataLabels: 
					{
						enabled: false
					},
					stroke: 
					{
						curve: 'smooth'
					},
					xaxis: 
					{
						categories: [
							@foreach($arrayDataArea['account'] as $data)
								"{{ $data }}",
							@endforeach
						]
					},
					yaxis: 
					{
						title: 
						{
							text: 'Monto'
						},
						labels: 
						{
							formatter: function(val, index) 
							{
								return new Intl.NumberFormat().format(val);
							}
						}
					},
					tooltip: 
					{
						y: 
						{
							formatter: function (val) 
							{
								return "$" + new Intl.NumberFormat().format(val) + ""
							}
						}
					},
					title: 
					{
						text		: '{{ $nameEnterprise }}',
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
					markers: 
					{
						size: [4]
					}
				};
				$('#container_graph_area').show();
				var chart = new ApexCharts(document.querySelector("#container_graph_area"), options);
				chart.render();
			})
			.on('click','#graph_bar',function()
			{
				$('.hide').hide();
				var options = 
				{
					series: 
					[
						@foreach($year as $y)
							{
								name: '{{ $y }}',
								data: [
									@foreach($arrayDataArea['total_'.$y] as $data)
										{{ $data }},
									@endforeach
								],
							},
						@endforeach
					],
					chart: 
					{
						type: 'bar',
						height: 350
					},
					plotOptions: 
					{
						bar: 
						{
							horizontal: false,
							columnWidth: '55%',
							endingShape: 'flat'
						},
					},
					dataLabels: 
					{
						enabled: false
					},
					stroke: 
					{
						show: true,
						width: 2,
						colors: ['transparent']
					},
					xaxis: 
					{
						categories: [
							@foreach($arrayDataArea['account'] as $data)
								"{{ $data }}",
							@endforeach
						]
					},
					yaxis: 
					{
						title: 
						{
							text: 'Monto'
						},
						labels: 
						{
							formatter: function(val, index) 
							{
								return new Intl.NumberFormat().format(val);
							}
						}
					},
					fill: 
					{
						opacity: 1
					},
					tooltip: 
					{
						y: 
						{
							formatter: function (val) 
							{
								return "$" + new Intl.NumberFormat().format(val) + ""
							}
						}
					},
					title: 
					{
						text		: '{{ $nameEnterprise }}',
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
				};

				$('#container_graph_bar').show();
				var chart = new ApexCharts(document.querySelector("#container_graph_bar"), options);
				chart.render();
			})
		@endif
	});
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


