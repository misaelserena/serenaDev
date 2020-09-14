@extends('layouts.child_module')
  
@section('data')
	<!-- FORMULARIO ALTA -->
	<center>
		<form id="container-cambio">
			<div class="container-search">
				<br><label class="label-form">Buscar rol</label><br><br>
				<center>
					<input type="text" name="search" class="input-text" id="input-search" placeholder="Escribe un nombre..."> <span class="icon-search"></span>

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
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function()
		{
			$(document).on('keyup','#input-search', function(){
				$text = $(this).val();
				if ($text == "" || $text == " " || $text == "  " || $text == "   ") {
					$('#not-found').stop().show();
					$('#not-found').html("RESULTADO NO ENCONTRADO");
					$('#table').stop().hide();
				}else{
					$('#not-found').stop().hide();
					$.ajax({
						type : 'get',
						url  : '{{ route("role.search.role") }}',
						data : {'search':$text},
						success:function(data){
							$('.table-responsive').html(data);
						}
					}); 
				}
			})
			.on('click','.role-delete',function(e)
			{
				e.preventDefault();
				url = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea suspender el rol",
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
							text		: "Suspender",
							value		: true,
							closeModal	: false
						}
					},
					dangerMode	: true,
				})
				.then((a) => {
					if (a)
					{
						$.ajax(
						{
							url		: url,
							type	: 'DELETE',
							success	: function(result)
							{
								if(result)
								{
									swal('','Rol suspendido correctamente','success');
									$.ajax(
									{
										type	: 'get',
										url		: '{{ route("role.search.role") }}',
										data	: {'search':$('#input-search').val()},
										success	: function(data)
										{
											$('.table-responsive').html(data);
										}
									});
								}
								else
								{
									swal('','Error al suspender el rol; por favor intente más tarde','error');
								}
							}
						});
					}
				});
			})
			.on('click','.role-reactive',function(e)
			{
				e.preventDefault();
				url = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea reactivar el rol",
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
							text		: "Reactivar",
							value		: true,
							closeModal	: false
						}
					},
					dangerMode	: true,
				})
				.then((a) => {
					if (a)
					{
						$.ajax(
						{
							url		: url,
							type	: 'DELETE',
							success	: function(result)
							{
								if(result)
								{
									swal('','Rol reactivado correctamente','success');
									$.ajax(
									{
										type	: 'get',
										url		: '{{ route("role.search.role") }}',
										data	: {'search':$('#input-search').val()},
										success	: function(data)
										{
											$('.table-responsive').html(data);
										}
									});
								}
								else
								{
									swal('','Error al reactivar el rol; por favor intente más tarde','error');
								}
							}
						});
					}
				});
			});
		}); 
	</script>
@endsection
