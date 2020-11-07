@extends('layouts.child_module')

@section('data')
	{!! Form::open(['route' => 'sales.product.edit', 'method' => 'GET']) !!}	
		<div class="card">
			<div class="card-header">
				BÚSQUEDA DE VENTAS
			</div>
			<div class="card-body">
				<div class="form-group">
					<div class="md-form">
						<label class="label-form" for="client_id">Cliente</label>
						<select class="form-control" id="client_id" name="client_id[]" multiple="multiple">
							@foreach(App\Client::orderName()->get() as $client)
								<option value="{{ $client->id }}" @if(isset($client_id) && in_array($client->id, $client_id)) selected="selected" @endif>{{ $client->fullName() }}</option>
							@endforeach
						</select>
					</div>
					<div class="md-form">
						<label class="label-form" for="product_id">Producto</label>
						<select class="form-control" id="product_id" name="product_id[]" multiple="multiple">
							@foreach(App\Products::where('products.status',1)->orderDescription()->get() as $cat)
								<option value="{{ $cat->id }}" @if(isset($product_id) && in_array($cat->id, $product_id)) selected="selected" @endif>{{ $cat->code }} - {{ $cat->description }}</option>
							@endforeach
						</select>
					</div>
					<div class="md-form">
						<input type="text" class="input-text" id="mindate" name="mindate" @if(isset($mindate)) value="{{ $mindate }}" @endif placeholder="Fecha Inicial"> -
						<input type="text" class="input-text" id="maxdate" name="maxdate" @if(isset($maxdate)) value="{{ $maxdate }}" @endif placeholder="Fecha Final">
					</div>
				</div>
				<button class="btn btn-success" type="submit">
					<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
				</button>
			</div>
		</div>
	{!! Form::close() !!}
	<p><br></p>
	@if(count($sales) > 0)
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="text-align-center thead-dark">
					<tr>
						<th>ID</th>
						<th>Cliente</th>
						<th>Total de Productos</th>
						<th>Total</th>
						<th>Fecha</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody class="text-align-center">
					@foreach($sales as $sale)
						<tr>
							<td>
								{{ $sale->id }}
							</td>
							<td>
								{{ $sale->clientData->fullName() }}
							</td>
							<td>
								{{ $sale->detail->sum('quantity') }}
							</td>
							<td>
								${{ number_format($sale->total,2) }}
							</td>
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
			{{ $sales->appends([
				'mindate' 		=> $mindate,
				'maxdate' 		=> $maxdate,
				'product_id' 	=> $product_id,
				'client_id' 	=> $client_id
				])->render() }}
		</center>
	@else
		<div class="alert alert-danger" role="alert">Resultado no encontrado</div>
	@endif
	<br><br>
@endsection
@section('scripts')
	<script type="text/javascript">
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function()
		{
			$(function() 
			{
				$("#mindate,#maxdate").datepicker({ dateFormat: "yy-mm-dd" });
			});
			$('#client_id').select2(
			{
				placeholder				: 'Cliente',
				language				: "es",
				width 					: "100%"
			});
			$('#product_id').select2(
			{
				placeholder				: 'Producto',
				language				: "es",
				width 					: "100%"
			});
		});
	</script>
@endsection