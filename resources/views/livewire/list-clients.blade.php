 <div class="row">
	<div class="col align-self-center">
		<div class="form-group">
			<div class="md-form">
				<i class="fas fa-search prefix" aria-hidden="true"></i>
				<label for="search">Escriba aquí para buscar un cliente</label>
				<input wire:model="name" type="text" class="form-control my-0 py-1" id="search" name="search">
			</div>
		</div>
		<center>
			<button wire:click="search" type="button" class="btn btn-info" id="getClients">
				<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
			</button>
		</center>
		<br>
	</div>
</div>
<div class="table-responsive" id="result-clients">
	@if(isset($clients) && count($clients)>0)
		<div class="table-responsive">
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
		</div>
		{{ $clients->links() }}
	@else
		<div class="alert alert-danger" role="alert">Resultado no encontrado</div>
	@endif
</div>
