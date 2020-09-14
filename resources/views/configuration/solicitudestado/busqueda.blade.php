@extends('layouts.child_module')
  
@section('data')
	<center>
		<form id="container-cambio">
			<div class="container-search">
				<br><label class="label-form">Buscar estado</label><br><br>
				<center>
					<input type="text" name="search" class="input-text" id="input-search" placeholder="Escribe un nombre de etiqueta..."> <span class="icon-search"></span>
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
			$('#input-search').on('keyup', function()
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
					$.ajax(
					{
						type	: 'get',
						url		: '{{ url("configuration/status/search") }}',
						data	: {'search':$text},
						success	: function(data)
						{
							$('.table-responsive').html(data);
						}
					}); 
				}
			})
		}); 
	</script>
<script type="text/javascript"> 
      @if(isset($alert)) 
      {!! $alert !!} 
      @endif 
    </script> 
@endsection
