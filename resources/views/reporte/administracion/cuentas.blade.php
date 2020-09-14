@extends('layouts.child_module')
@section('data')
<div id="container-cambio" class="div-search">
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
					<select title="Empresa" name="idEnterprise" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 150px;">
						@foreach(App\Enterprise::orderName()->get() as $enterprise)
						<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="search-table-center-row">
				<p>
					<select title="Cuenta" class="js-account removeselect" multiple="multiple" name="account" style="width: 98%; max-width: 150px;">
						
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
<div id="table-return">
	
</div>

<div id="myModal" class="modal">

</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('.js-enterprise').select2(
		{
			placeholder : 'Seleccione la empresa',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$('.js-account').select2(
		{
			placeholder : 'Seleccione la cuenta',
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
			$.ajax(
			{
				type 	: 'get',
				url 	: '{{ url("/report/administration/getaccounts") }}',
				data 	: {'enterpriseid':$enterprise},
				success : function(data)
				{
					 $.each(data,function(i, d) {
				        $('.js-account').append('<option value='+d.idAccAcc+'>'+d.account+' - '+d.description+'</option>');
				     });
					
				}
			})
		}
		
	})
	.on('click','.detail', function()
	{

		$folio = $(this).parents('tr').find('.folio').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/accounts/detail") }}',
			data : {'folio':$folio},
			success : function(data)
			{
				$('#myModal').show().html(data);
				//$('#detail').slideDown().html(data);
				//$('#table-purchase').slideUp();
				$('.detail').attr('disabled','disabled');
			}
		})
	})
	.on('click','.send', function()
	{
		idEnterprise	= $('select[name="idEnterprise"] option:selected').val();
		account= [];

		$('select[name="account"] option:selected').each(function(){
		  account.push($(this).val());
		});
		accounts = JSON.stringify(account);
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/accounts/table") }}',
			data : {'idEnterprise':idEnterprise,
					'accounts':accounts},
			success : function(data)
			{
				$('#table-return').html(data);
			}
		})
	})
	.on('click','.exit',function()
	{
		$('#detail').slideUp();
		$('#myModal').hide();
		$('.detail').removeAttr('disabled');
	});
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


