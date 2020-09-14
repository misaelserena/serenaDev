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
					<label class="label-form">Solicitante:</label>
				</div>
				<div class="right">
					<p><input title="Solicitante" type="text" name="name" class="input-text-search name" id="input-search" placeholder="Escribe aquí..."></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Rango de fechas:</label>
				</div>
				<div class="right-date">
					<p><input title="Desde" type="text" name="mindate" step="1" class="input-text-date datepicker" placeholder="Desde" id="mindate"> - <input title="Hasta" type="text" name="maxdate" step="1" class="input-text-date datepicker" placeholder="Hasta" id="maxdate"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Empresa" name="idEnterprise" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach(App\Enterprise::orderName()->get() as $enterprise)
						<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Dirección" class="js-area" multiple="multiple" name="idArea" style="width: 98%; max-width: 150px;">
						@foreach(App\Area::orderName()->where('status','ACTIVE')->get() as $area)
						<option value="{{ $area->id }}">{{ $area->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Departamento" class="js-department" multiple="multiple" name="idDepartment" style="width: 98%; max-width: 150px;">
						@foreach(App\Departament::where('status','ACTIVE')->get() as $department)
						<option value="{{ $department->id }}">{{ $department->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Estado de solicitud" name="status" class="js-status" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach (App\StatusRequest::orderName()->whereIn('idrequestStatus',[3,5,9])->get() as $s)
								<option value="{{ $s->idrequestStatus }}">{{ $s->description }}</option>		
						@endforeach
					</select>
				</p>
			</div>
		</div>
	</center>
	<center>
		<button class="btn 	btn-search send" type="submit" title="Buscar"><span class="icon-search"></span> Buscar</button>
	</center>
	<br><br>
</div>
<br>
<div id="table-return"></div>
<div id="myModal" class="modal"></div>
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('input[name="folio"]').numeric(false);
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
			placeholder : 'Seleccione uno o varios estados',
			language 	: 'es',
		});
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});

	$(document).on('change','.js-enterprise',function()
	{
		$('.js-account').empty();
		$enterprise = $(this).val();
		if ($enterprise != 'todas') 
		{
			swal(
			{
				closeOnClickOutside:false,
				closeOnEsc:false,
				icon	: '{{ url('images/load.gif') }}',
				button	: false
			});
			$.ajax(
			{
				type 	: 'get',
				url 	: '{{ url("/report/administration/account") }}',
				data 	: {'enterpriseid':$enterprise},
				success : function(data)
				{
					swal.close()
					 $.each(data,function(i, d) {
				        $('.js-account').append('<option value='+d.idAccAcc+'>'+d.account+' - '+d.description+'</option>');
				     });
					
				},
				error: function()
				{
					swal('', 'Ocurrió un error al buscar, intente de nuevo, por favor', 'error');
				}
			})
		}
	})
	.on('click','.detail', function()
	{
		$folio = $(this).parents('tr').find('.folio').val();
		swal(
			{
				closeOnClickOutside:false,
				closeOnEsc:false,
				icon	: '{{ url('images/load.gif') }}',
				button	: false
			});
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/stationery/detail") }}',
			data : {'folio':$folio},
			success : function(data)
			{
				swal.close()
				$('#myModal').show().html(data);
				$('.detail').attr('disabled','disabled');
			},
			error: function()
			{
				swal('', 'Ocurrió un error al buscar, intente de nuevo, por favor', 'error');
			}
		})
	})
	.on('click','.send', function()
	{
		idDepartment 	= $('.js-department').val();
		idArea			= $('.js-area').val();
		idEnterprise	= $('.js-enterprise').val();
		stat 			= $('.js-status').val();
		name			= $('input[name="name"]').val();
		mindate			= $('input[name="mindate"]').val();
		maxdate 		= $('input[name="maxdate"]').val();
		folio 			= $('input[name="folio"]').val();
		swal(
			{
				closeOnClickOutside:false,
				closeOnEsc:false,
				icon	: '{{ url('images/load.gif') }}',
				button	: false
			});
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/stationery/table") }}',
			data : {
					'idEnterprise'	:idEnterprise,
					'idArea'		:idArea,
					'idDepartment'	:idDepartment,
					'stat'			:stat,
					'name'			:name,
					'mindate'		:mindate,
					'maxdate'		:maxdate,
					'folio'			:folio
				},
			success : function(data)
			{
				swal.close();
				$('#table-return').html(data);
			},
			error: function()
			{
				swal('', 'Ocurrió un error al buscar, intente de nuevo, por favor', 'error');
			}
		})
	})
	.on('click','.exit',function()
	{
		$('#detail').slideUp();
		$('.detail').removeAttr('disabled');
		$('#myModal').hide();
	});
		
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection