@extends('layouts.child_module')
  
@section('data')
	<center>
		<form id="container-cambio">
			<div class="container-search">
				<br><label class="label-form">Buscar proveedor</label><br><br>
				<center>
					<input type="text" name="search" class="input-text" id="input-search" placeholder="Escribe un RFC..."> <span class="icon-search"></span>

				</center><br><br>
			</div>
		</form>
	</center>
	<br>
	<div class="table-responsive">
		
	</div>
	<div id="not-found"></div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function()
		{
			$(document).on('keyup','#input-search',function()
			{
				$text = $(this).val();
				if ($text == "" || $text == " " || $text == "  " || $text == "   ") 
				{
					$('#not-found').stop().show();
					$('#not-found').html("RESULTADO NO ENCONTRADO");
					$('#table').stop().hide();
				}
				else
				{
					$('#not-found').stop().hide();
					$.ajax({
						type : 'get',
						url  : '{{ url("configuration/provider/search/search") }}',
						data : {'search':$text},
						success:function(data){
							$('.table-responsive').html(data);
						}
					}); 
				}
			})
			.on('click','.provider-delete',function(e)
			{
				e.preventDefault();
				attr = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea eliminar el proveedor",
					icon		: "warning",
					buttons		:
					{
						cancel:
						{
							text		: "Cancelar",
							value		: null,
							visible		: true,
							closeModal	: true,
						},
						confirm:
						{
							text		: "Eliminar",
							value		: true,
							closeModal	: false
						}
					},
					dangerMode	: true,
				})
				.then((a) => {
					if (a)
					{
						window.location.href=attr;
					}
				});
			});
		}); 
		
      @if(isset($alert)) 
      {!! $alert !!} 
      @endif 
    </script> 
@endsection
