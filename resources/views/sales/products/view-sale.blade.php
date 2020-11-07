@extends('layouts.child_module')

@section('data')
	
	<div class="card">
		<div class="card-header text-white bg-green">
			ACCIONES
		</div>
		<div class="card-body">
			<label class="label-form">DESCARGAR PDF: </label> 
			<a href="{{ route('sales.download.document',$sale->id) }}" class='btn-suspend btn btn-danger' alt='Descargar' title='Descargar'>
				<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#download") }}"></use></svg>
			</a> 
		</div>
	</div>
	<p><br></p>
	<div class="card">
		<div class="card-header text-white bg-green">
			DATOS DEL CLIENTE
		</div>
		<div class="card-body">
			<table class="table">
				<thead class="text-align-center thead-dark">
					<th>ID</th>
					<TH>Nombre</TH>
				</thead>
				<tbody class="text-align-center" id="clientSelected">
					<tr>
						<td>{{ $sale->id }}</td>
						<td>{{ $sale->clientData->fullName() }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<p><br></p>
	<div class="card">
		<div class="card-header text-white bg-green">
			DATOS DE LA VENTA
		</div>
		<div class="card-body">
			<table class="table">
				<thead class="text-align-center thead-dark">
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Precio</th>
					<th>Subtotal</th>
					<th>IVA</th>
					<th>Descuento</th>
					<th>Total</th>
				</thead>
				<tbody class="text-align-center" id="productSelected">
					@foreach($sale->detail as $detail)
						<tr>
							<td>
								{{ $detail->productData->description }}
							</td>
							<td>
								{{ $detail->quantity }}
							</td>
							<td>
								${{ number_format($detail->price,2) }}
							</td>
							<td>
								${{ number_format($detail->subtotal,2) }}
							</td>
							<td>
								${{ number_format($detail->iva,2) }}
							</td>
							<td>
								${{ number_format($detail->discount,2) }}
							</td>
							<td>
								${{ number_format($detail->total,2) }}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		 <div class="row justify-content-end">
	    	<div class="md-form col-4">
	      		<label class="label-form" for="subtotal_all">Subtotal</label>
				<input type="text" name="subtotal_all" class="form-control subtotal_all" id="subtotal_all" value="${{ number_format($sale->subtotal,2) }}">
	    	</div>
	  	</div>
	  	<div class="row justify-content-end">
	    	<div class="md-form col-4">
	      		<label class="label-form" for="iva_all">IVA</label>
				<input type="text" name="iva_all" class="form-control iva_all" id="iva_all" value="${{ number_format($sale->iva,2) }}">
	    	</div>
	  	</div>
	  	<div class="row justify-content-end">
	    	<div class="md-form col-4">
	      		<label class="label-form" for="discount_all">Descuento</label>
				<input type="text" name="discount_all" class="form-control discount_all" id="discount_all" value="${{ number_format($sale->discount,2) }}">
	    	</div>
	    </div>
	    <div class="row justify-content-end">
	    	<div class="md-form col-4">
	      		<label class="label-form" for="total_all">Total</label>
				<input type="text" name="total_all" class="form-control total_all" id="total_all" value="${{ number_format($sale->total,2) }}">
	    	</div>
	  	</div>
	</div>

@endsection