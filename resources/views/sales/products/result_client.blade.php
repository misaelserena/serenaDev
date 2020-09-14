@if(count($clients)>0)
	<table class="table table-striped">
		<thead class="text-align-center thead-dark">
			<th>ID</th>
			<th>Nombre</th>
			<th>Acción</th>
		</thead>
		<tbody class="text-align-center">
			@foreach($clients as $client)
				<tr>
					<td>{{ $client->id }} <input type="hidden" class="id_client_table" value="{{ $client->id }}"></td>
					<td>{{ $client->fullName() }} <input type="hidden" class="name_client_table" value="{{ $client->fullName() }}"></td>
					<td>
						<button type="button" class='btn btn-success' id="addClientExists" alt='Agregar' title='Agregar'>
							<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#person-plus-fill") }}"></use></svg>
						</button> 
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<div class="alert alert-danger" role="alert">Resultado no encontrado</div>
@endif