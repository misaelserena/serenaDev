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
					<label class="label-form">Nombre:</label>
				</div>
				<div class="right">
					<p><input type="text" name="name" class="input-text-search name" id="input-search" placeholder="Escribe..."></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<div class="left">
					<label class="label-form">Rango:</label>
				</div>
				<div class="right-date">
					<p><input type="text" name="min" step="1" class="input-text-date" id="min" placeholder="Mínimo"> - <input type="text" name="max" step="1" id="max" class="input-text-date" placeholder="Máximo"></p>
				</div>
			</div>
			<div class="search-table-center-row">
				<p>
					 <input type="checkbox" name="all" id="all"><label class="label-form" for="all">Mostrar Todos</label>
				</p>
			</div>
		</div>
	</center>
	<center>
		<button class="btn btn-search send" type="button"><span class="icon-search"></span> Buscar</button> 
	</center>
	<br><br>
</div>
<br>
<div id="table-return"></div>
@endsection

@section('scripts')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript"> 
	$(document).on('click','.detail', function()
	{
		id = $(this).parents('tr').find('.id').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/box/detail") }}',
			data : {'id':$id},
			success : function(data)
			{
				$('#detail').slideDown().html(data);
				$('.detail').attr('disabled','disabled');
			}
		})
	})
	.on('click','.send', function()
	{
		if ($('#all').prop('checked')) 
		{
			all = "all";
		}
		else
		{
			all = "no";
		}
		
		name	= $('input[name="name"]').val();
		min		= $('input[name="min"]').val();
		max		= $('input[name="max"]').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/box/table") }}',
			data : {'name':name,
					'min':min,
					'max':max,
					'all':all},
			success : function(data)
			{
				$('#table-return').html(data);
			}
		})
	})
	.on('click','.exit',function()
	{
		$('#detail').slideUp();
		$('.detail').removeAttr('disabled');
	});
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


