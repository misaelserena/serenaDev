@extends('layouts.child_module')
  
@section('data')
		{!! Form::open(['route' => 'administration.client.edit', 'method' => 'GET']) !!}			
			<div class="card">
				<div class="card-header">
					BÚSQUEDA DE CLIENTES
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="md-form">
							<label for="name">Nombre</label>
							<input type="text" class="form-control" id="name" name="name" value="{{ isset($name) ? $name : '' }}">
						</div>
					</div>
					<button class="btn btn-success" type="submit">
						<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
					</button>
				</div>
			</div>
		{!! Form::close() !!}
	<br>
	@if(count($clients) > 0)
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="text-align-center thead-dark">
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Télefono</th>
						<th>Status</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody class="text-align-center">
					@foreach($clients as $client)
						<tr>
							<td>{{ $client->id }}</td>
							<td>{{ $client->fullName() }}</td>
							<td>{{ $client->phone }}</td>
							<td>
								{{ $client->status == 1 ? 'Activo' : 'Suspendido' }}
							</td>
							<td>
								@if($client->status == 1)
									<a href="{{ route('administration.client.show',$client->id) }}" class='btn btn-info' alt='Editar' title='Editar'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#pencil") }}"></use></svg>
									</a> 
									<a href="{{ route('administration.client.delete',$client->id) }}" class='btn-suspend-client btn btn-danger' alt='Baja' title='Baja'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#trash-fill") }}"></use></svg>
									</a> 
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
		<center>
			{{ $clients->appends(['name'=> $name])->render() }}
		</center>
		@else
			<div class="alert alert-danger" role="alert">Resultado no encontrado</div>
		@endif
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
			
			$(document).on('click','.btn-suspend-client',function(e)
			{
				e.preventDefault();
				attr = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea suspender al cliente",
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
						window.location.href=attr;
					}
				});
			});
		}); 
	</script>
@endsection
