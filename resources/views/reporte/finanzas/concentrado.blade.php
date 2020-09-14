@extends('layouts.child_module')
@section('data')
<div id="container-cambio" class="div-search">
	<form method='get' action='{{ route('report.concentrated.excel') }}' accept-charset='UTF-8' id='formsearch'>
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
				<div class="search-table-center-row">
					<p>
						<label class="label-form">¿Que desea descargar?</label><br><br>
						<input type="radio" name="options" id="excelfile" value="0">
						<label for="excelfile">Archivo Excel</label> 
						<input type="radio" name="options" id="charts" value="1">
						<label for="charts">Gráfica</label>
						<br><br>
					</p>
				</div>
				<div id="form-excel">
					<div class="search-table-center-row">
						<p>
							<select title="Empresa" name="idEnterprise[]" class="js-enterprise-excel" multiple="multiple" style="width: 98%; max-width: 150px;">
								@foreach(App\Enterprise::orderName()->get() as $enterprise)
									<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select title="Proyecto" name="idProject[]" class="js-projects-excel" multiple="multiple" style="width: 98%; max-width: 150px;">
								@foreach(App\Project::orderName()->where('status',1)->get() as $project)
									<option value="{{ $project->idproyect }}">{{ $project->proyectName }}</option>
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<div class="left">
							<label class="label-form">Rango de fechas:</label>
						</div>
						<div class="right-date">
							<p>
								<input type="text" name="mindate" step="1" class="input-text-date datepicker" placeholder="Desde" data-validation="required" readonly="readonly"> - <input type="text" name="maxdate" step="1" class="input-text-date datepicker" placeholder="Hasta" data-validation="required" readonly="readonly">
							</p>
						</div>
					</div>
					<center>
						<button class="btn 	btn-search" type="submit" title="Buscar"><span class="icon-search"></span> Exportar</button> 
					</center>
				</div>
				<div id="form-charts">
					<div class="search-table-center-row">
						<p>
							<select title="Empresa" class="js-enterprise-charts" multiple="multiple" style="width: 98%; max-width: 150px;">
								@foreach(App\Enterprise::orderName()->get() as $enterprise)
								<option value="{{ $enterprise->id }}">{{ $enterprise->name.',  '  }}</option>
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select title="Proyecto" class="js-projects-charts" multiple="multiple" style="width: 98%; max-width: 150px;">
								@foreach(App\Project::orderName()->where('status',1)->get() as $project)
									<option value="{{ $project->idproyect }}">{{ $project->proyectName.', ' }}</option>
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select title="Empresa" class="js-account" multiple="multiple" style="width: 98%; max-width: 150px;">
								
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<div class="left">
							<label class="label-form">Rango de fechas:</label>
						</div>
						<div class="right-date">
							<p>
								<input type="text" name="mindatecharts" step="1" class="input-text-date datepicker" placeholder="Desde" data-validation="required"> - <input type="text" name="maxdatecharts" step="1" class="input-text-date datepicker" placeholder="Hasta" data-validation="required">
							</p>
						</div>
					</div>
					<div class="search-table-center-row">
						<div class="left">
							<label class="label-form">Seleccione el tipo de gráfica que desea:</label>
						</div>
						<div class="right-date">
							<p>
								<button type="button" class="btn follow-btn" id="showChartCircle"><img src="{{ asset('images/charts/graphic_circle.svg') }}" class="img-responsive" width="100"></button>
								<button type="button" class="btn follow-btn" id="showChartBar"><img src="{{ asset('images/charts/graph_bar.svg') }}" class="img-responsive" width="100"></button>
							</p>
						</div>
					</div>
					
				</div>
			</div>
		</center>
		<br><br>
	</form>
</div>
<div id="accountsChartCircle"></div>
<div id="accountsChartBar"></div>	
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
	function accountsChartCircle($labels,$series) 
	{
		var options = 
		{
			series	: $series,
			chart	: 
			{
				width	: 780,
				type	: 'donut',
	        },
       		labels 		: $labels,
        	responsive 	: [{
          		breakpoint: 480,
          		options: 
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

        chart = new ApexCharts(document.querySelector("#accountsChartCircle"), options);
        chart.render();
	}

	function accountsChartBar($labels,$series) 
	{
        var options = 
        {
          	series: 
          	[{
          		name: 'Total:',
          		data: $series
        	}],
          	chart: 
          	{
	          	height: 650,
	          	type: 'bar',
	          	events: 
	          	{
	            	click: function(chart, w, e) 
	            	{
	              		// console.log(chart, w, e)
	            	}
	          	}
        	},
       		theme: 
       		{
			 	palette: 'palette1'
			},
        	plotOptions: 
        	{
          		bar: 
          		{
            		columnWidth: '60%',
            		distributed: true
          		}
        	},
	        dataLabels: 
	        {
	          	enabled: false
	        },
	        legend: 
	        {
	         	show: false
	        },
	        xaxis: 
	        {
	          	categories: $labels,
	          	labels: 
	          	{
	            	style: 
	            	{
	              		fontSize: '12px'
	            	}
	          	}
	        },
	        tooltip: 
	        {
	          	y: 
	          	{
	            	formatter: function (val) 
	            	{
	              		return "$" +val+ ""
	            	}
	          	}
	        }
        };

        chart = new ApexCharts(document.querySelector("#accountsChartBar"), options);
        chart.render();
	    
	}

	$(document).on('change','input[name="options"]',function()
	{
		if ($('input[name="options"]:checked').val() == "0") 
		{
			$('#form-excel').stop(true,true).fadeIn();
			$('#form-charts').stop(true,true).fadeOut();
			$('.js-enterprise-excel').select2(
			{
				placeholder : 'Seleccione la empresa',
				language 	: 'es',

			});
			$('.js-projects-excel').select2(
			{
				placeholder : 'Seleccione uno o varios proyectos (Opcional)',
				language 	: 'es',
			});
			$(function() 
			{
				$( ".datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
			});
		}
		else if ($('input[name="options"]:checked').val() == "1") 
		{
			$('#form-charts').stop(true,true).fadeIn();
			$('#form-excel').stop(true,true).fadeOut();
			$('.js-enterprise-charts').select2(
			{
				placeholder : 'Seleccione la empresa',
				language 	: 'es',

			});
			$('.js-projects-charts').select2(
			{
				placeholder : 'Seleccione uno o varios proyectos (Opcional)',
				language 	: 'es',
			});
			$('.js-account').select2(
			{
				placeholder : 'Seleccione la cuenta',
				language 	: 'es',
				maximumSelectionLength : 1,
			});
			$(function() 
			{
				$( ".datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
			});
		}
	})
	.on('click','#showChartBar',function()
	{
		$('#accountsChartCircle').hide();
		$('#accountsChartBar,#accountsChartCircle').empty();
		$('#accountsChartBar,#accountsChartCircle').html('');
		idProject		= $('.js-projects-charts').val();
		projectname		= $('.js-projects-charts option:selected').text();
		idEnterprise	= $('.js-enterprise-charts').val();
		enterprisename	= $('.js-enterprise-charts option:selected').text();
		father			= $('.js-account').val();
		account			= $('.js-account option:selected').text();
		mindate			= $('input[name="mindatecharts"]').val();
		maxdate			= $('input[name="maxdatecharts"]').val();
		labels 			= [];
		series 			= [];
		type 			= 2;
		if ($('.js-projects-charts option:selected').length == 0) 
		{
			tit = 'Empresa(s): '+enterprisename+' \n'+'Cuenta: '+account.substring(8,50)+'\n De: '+mindate+' \n Hasta: '+maxdate;
		}
		else
		{
			tit = 'Empresa: '+enterprisename+' \n'+'Proyecto(s): '+projectname+' \n'+ 'Cuenta: '+account.substring(8,50)+'\n De: '+mindate+' \n Hasta: '+maxdate;
		}

		if (idEnterprise == '' || father == '' || mindate == '' || maxdate == '')
		{
			swal('', 'Favor de llenar todos los campos', 'error');
		}
		else
		{
			swal({
					icon: '{{ url('images/load.gif') }}',
					button: false,
					closeOnClickOutside: false,
					closeOnEsc: false
				});

			$.ajax(
			{
				type  : 'get',
				url   : '{{ url("/report/finance/concentrated/charts") }}',
				data  : {'idEnterprise':idEnterprise,'mindate':mindate,'maxdate':maxdate,'father':father[0],'idProject':idProject,'type':type},
				success : function(data)
				{
					$.each(data,function(i, d) 
					{
						labels.push(d.description);
						series.push(d.total);
					});
					accountsChartBar(labels,series);
					$('#accountsChartBar').show();
					swal.close();
				},
				error	: function()
				{
					swal.close();
					swal('', 'Error al generar la gráfica', 'error');
				}
			});
		}
		
	})
	.on('click','#showChartCircle',function()
	{
		$('#accountsChartBar').hide();
		$('#accountsChartCircle,#accountsChartBar').empty();
		$('#accountsChartCircle,#accountsChartBar').html('');
		idProject		= $('.js-projects-charts').val();
		projectname		= $('.js-projects-charts option:selected').text();
		idEnterprise	= $('.js-enterprise-charts').val();
		enterprisename	= $('.js-enterprise-charts option:selected').text();
		father			= $('.js-account').val();
		account			= $('.js-account option:selected').text();
		mindate			= $('input[name="mindatecharts"]').val();
		maxdate			= $('input[name="maxdatecharts"]').val();
		labels 			= [];
		series 			= [];
		type 			= 1;
		if ($('.js-projects-charts option:selected').length == 0) 
		{
			tit = 'Empresa(s): '+enterprisename+' \n'+'Cuenta: '+account.substring(8,50)+'\n De: '+mindate+' \n Hasta: '+maxdate;
		}
		else
		{
			tit = 'Empresa: '+enterprisename+' \n'+'Proyecto(s): '+projectname+' \n'+ 'Cuenta: '+account.substring(8,50)+'\n De: '+mindate+' \n Hasta: '+maxdate;
		}

		if (idEnterprise == '' || father == '' || mindate == '' || maxdate == '')
		{
			swal('', 'Favor de llenar todos los campos', 'error');
		}
		else
		{
			swal({
					icon: '{{ url('images/load.gif') }}',
					button: false,
					closeOnClickOutside: false,
					closeOnEsc: false
				});

			$.ajax(
			{
				type  : 'get',
				url   : '{{ url("/report/finance/concentrated/charts") }}',
				data  : {'idEnterprise':idEnterprise,'mindate':mindate,'maxdate':maxdate,'father':father[0],'idProject':idProject,'type':type},
				success : function(data)
				{
					$.each(data,function(i, d) 
					{
						labels.push(d.description);
						series.push(d.total);
					});
					
					accountsChartCircle(labels,series);
					$('#accountsChartCircle').show();
					swal.close();
				},
				error	: function()
				{
					swal.close();
					swal('', 'Error al generar la gráfica', 'error');
				}
			});
		}
	})
	.on('change','.js-enterprise-charts',function()
	{
		$('.js-account').empty();
		$enterprise	= $(this).val();
		if ($enterprise != 'todas') 
		{
			$.ajax(
			{
				type 	: 'get',
				url 	: '{{ url("/report/finance/getaccounts") }}',
				data 	: {'enterpriseid':$enterprise},
				success : function(data)
				{
					$.each(data,function(i, d) {
								$('.js-account').append('<option value='+d.father+'>'+d.account+' - '+d.description+'</option>');
						 });
				}
			})
		}
	})
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


