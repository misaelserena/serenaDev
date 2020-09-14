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
	</style>
@endsection

@section('data')
<div id="container-cambio" class="div-search">
	<form method='get' action='{{ route('report.account-concentrated.excel') }}' accept-charset='UTF-8' id='formsearch'>
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
							<select title="Empresa" name="idEnterprise" class="js-enterprise-excel form-control" multiple="multiple" data-validation="required">
								@foreach(App\Enterprise::orderName()->get() as $enterprise)
									<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<button class="btn btn-green all-select select" type="button" data-target="js-account-excel" disabled id="select_accounts"> todas las cuentas</button>
							<select title="Empresa" name="account[]" data-validation="required" class="js-account-excel form-control" multiple="multiple">
								
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<button class="btn btn-green all-select select" type="button" data-target="js-projects-excel"> todos los proyectos</button>
							<select title="Proyecto" name="idProject[]" class="js-projects-excel form-control" multiple="multiple">
								@foreach(App\Project::orderName()->where('status',1)->get() as $project)
									<option value="{{ $project->idproyect }}">{{ $project->proyectName }}</option>
								@endforeach
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select class="form-control year-excel" data-validation="required" multiple="multiple" name="year[]">
								@for($year = 2019; $year<= date("Y"); $year++)
									<option value="{{ $year }}">{{ $year }}</option>
								@endfor
							</select>
						</p>
					</div>
					<div class="search-table-center-row">
						<p>
							@php
								$months = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
							@endphp
							<button class="btn btn-green all-select select" type="button" data-target="month-excel"> todos los meses</button>
							<select class="form-control month-excel" data-validation="required" multiple="multiple" name="month[]">
								@for($month = 1; $month <= 12; $month++)
									<option value="{{ $month }}">{{ $months[$month] }}</option>
								@endfor
							</select>
						</p>
					</div>
					<br>
					<div class="search-table-center-row">
						<div class="left">
							<label class="label-form">Seleccione lo que deseas obtener:</label>
						</div>
						<div class="right-date">
							<p>
								<button type="submit" class="btn follow-btn" id="showChartCircle"><img src="{{ asset('images/charts/excel.svg') }}" class="img-responsive" width="100"></button>
								<button type="submit" formaction="{{ route('report.account-concentrated.charts') }}" class="btn follow-btn" id="showChartCircle"><img src="{{ asset('images/charts/graphic_circle.svg') }}" class="img-responsive" width="100"></button>
							</p>
						</div>
					</div>
					
				</div>
			</div>
		</center>
		<br><br>
	</form>
</div>
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
	$.validate(
	{
		form 		: '#formsearch',
		modules 	: 'security',
		onError   	: function($form)
		{
			swal('', 'Por favor llene todos los campos que son obligatorios.', 'error');
		}
	});

	$(document).ready(function()
	{

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
		$(function() 
		{
			$( ".datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
		});
		$(document).on('click','#showChartBar',function()
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
		.on('change','.js-enterprise-excel',function()
		{
			$('#select_accounts').prop('disabled',false);
			$('.js-account-excel').empty();
			$enterprise	= $(this).val();
			$.ajax(
			{
				type 	: 'get',
				url 	: '{{ url("/report/finance/account-concentrated/get-account") }}',
				data 	: {'enterpriseid':$enterprise},
				success : function(data)
				{
					$.each(data,function(i, d) {
								$('.js-account-excel').append('<option value='+d.id+'>'+d.description+'</option>');
						 });
				},
				error 	: function()
				{
					swal('Error','No se encontraron cuentas','error');
				}
			});
		})
		.on('select2:unselecting','.js-enterprise-excel',function(e)
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
		});
	})

	function accountsChartCircle($labels,$series) 
	{
		var options = 
		{
			series	: $series,
			chart	: 
			{
				width	: 780,
				type	: 'pie',
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
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


