<div class="table-responsive">
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th>Empresa</th>
				<th>Cliente</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><b>{{$bill->rfc}}</b> {{$bill->businessName}}</td>
				<td><b>{{$bill->clientRfc}}</b> {{$bill->clientBusinessName}}</td>
			</tr>
		</tbody>
	</table>
</div>
<p><br></p>
<div class="table-responsive">
	<table class="table">
		<tbody>
			<tr>
				<th class="table-dark">Forma de pago:</th>
				<td>{{$bill->cfdiPaymentWay->description}}</td>
				<th class="table-dark">Folio:</th>
				<td>{{$bill->folio}}</td>
			</tr>
			<tr>
				<th class="table-dark">Método de pago:</th>
				<td>{{$bill->cfdiPaymentMethod->description}}</td>
				<th class="table-dark">Condiciones de pago:</th>
				<td>{{$bill->conditions}}</td>
			</tr>
		</tbody>
	</table>
</div>
<p><br></p>
<div class="table-responsive">
	@foreach($bill->billDetail as $d)
		<table class="table table-borderless">
			<thead class="thead-dark">
				<tr>
					<th><strong>Cantidad</strong></th>
					<th><strong>Valor unitario</strong></th>
					<th><strong>Importe</strong></th>
					<th><strong>Descuento</strong></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$d->quantity}}</td>
					<td>{{$d->value}}</td>
					<td>{{$d->amount}}</td>
					<td>{{$d->discount}}</td>
				</tr>
			</tbody>
		</table>
	@endforeach
</div>
<p><br></p>
<div class="table-responsive">
	<table class="table table-borderless">
		<tbody>
			<tr>
				<th class="text-right">Subtotal:</th>
				<td>{{$bill->subtotal}}</td>
			</tr>
			<tr>
				<th class="text-right">Descuento:</th>
				<td>{{$bill->discount}}</td>
			</tr>
			<tr>
				<th class="text-right">Total:</th>
				<td>{{$bill->total}}</td>
			</tr>
		</tbody>
	</table>
</div>