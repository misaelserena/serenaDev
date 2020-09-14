<table class="table table-striped">
	<thead class="thead-dark">
		<tr>
			<th>Emisor</th>
			<th>Receptor</th>
			<th>UUID</th>
			<th>Estatus</th>
			<th>Fecha</th>
			<th>Método de pago</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@if($selected != '')
			@foreach($selected as $s)
				<tr>
					<td>{{$s->rfc}}</td>
					<td>{{$s->clientRfc}}</td>
					<td>{{$s->uuid}}</td>
					<td>{{$s->statusCFDI}}</td>
					<td>{{$s->stampDate}}</td>
					<td>{{$s->paymentMethod}}</td>
					<td><input type="checkbox" value="{{$s->idBill}}" checked name="cfdi_rel[]" data-uuid="{{$s->uuid}}" data-serie="{{$s->serie}}" data-folio="{{$s->folio}}" data-currency="{{$s->currency}} {{$s->cfdiCurrency->description}}" @if($s->paymentMethod != '') data-payment-method="{{$s->paymentMethod}} {{$s->cfdiPaymentMethod->description}}" @endif></td>
				</tr>
			@endforeach
		@endif
		@foreach($result as $r)
			<tr>
				<td>{{$r->rfc}}</td>
				<td>{{$r->clientRfc}}</td>
				<td>{{$r->uuid}}</td>
				<td>{{$r->statusCFDI}}</td>
				<td>{{$r->stampDate}}</td>
				<td>{{$r->paymentMethod}}</td>
				<td><input type="checkbox" value="{{$r->idBill}}" name="cfdi_rel[]" data-uuid="{{$r->uuid}}" data-serie="{{$r->serie}}" data-folio="{{$r->folio}}" data-currency="{{$r->currency}} {{$r->cfdiCurrency->description}}" @if($r->paymentMethod != '') data-payment-method="{{$r->paymentMethod}} {{$r->cfdiPaymentMethod->description}}" @endif></td>
			</tr>
		@endforeach
	</tbody>
</table>