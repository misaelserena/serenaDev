@extends('layouts.child_module')

@section('data')
	
	@if(count($sales) > 0)
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="text-align-center thead-dark">
					<tr>
						<th>ID</th>
						<th>Cliente</th>
						<th>Total</th>
						<th>Fecha</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody class="text-align-center">
					@foreach($sales as $sale)
						<tr>
							<td>{{ $sale->id }}</td>
							<td>{{ $sale->clientData->fullName() }}</td>
							<td>{{ $sale->total }}</td>
							<td>
								{{ $sale->created_at }}
							</td>
							<td>
								<a href="{{ route('sales.product.show',$sale->id) }}" class='btn btn-info' alt='Editar' title='Editar'>
									<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg>
								</a> 
								<a href="{{ route('sales.product.delete',$sale->id) }}" class='btn-suspend btn btn-danger' alt='Baja' title='Baja'>
									<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#trash-fill") }}"></use></svg>
								</a> 
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
		<center>
			{{ $sales->render() }}
		</center>
	@else
		<div class="alert alert-danger" role="alert">Resultado no encontrado</div>
	@endif
	<br><br>
@endsection