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
				<p>
					<select title="Tipo" name="type" class="js-type" multiple="multiple" style="width: 98%; max-width: 150px;">
						<option value="1">Smartphone</option>
						<option value="2">Tablet</option>
						<option value="3">Laptop</option>
						<option value="4">Desktop</option>
						<option value="todos">Todos</option>
					</select>
				</p>
			</div>
		</div>
	</center>
	<center>
		<button class="btn 	btn-search send" type="button" title="Buscar"><span class="icon-search"></span> Buscar</button>
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
<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('.js-type').select2(
		{
			placeholder : 'Seleccione el tipo',
			language 	: 'es',
			maximumSelectionLength : 1,
		});
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});
	$(document).on('click','.detail', function()
	{
		$id = $(this).parents('tr').find('.id').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/computer/detail") }}',
			data : {'id':$id},
			success : function(data)
			{
				$('#myModal').show().html(data);
				$('.detail').attr('disabled','disabled');
			}
		})
	})
	.on('click','.send', function()
	{
		type 		= $('select[name="type"] option:selected').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/computer/table") }}',
			data : {'type':type},
			success : function(data)
			{
				$('#table-return').slideDown().html(data);
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