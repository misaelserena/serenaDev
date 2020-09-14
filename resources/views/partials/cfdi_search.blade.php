<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text"><strong>Relación:</strong></span>
	</div>
	<select class="custom-select" id="cfdi_relation_kind">
		@foreach(App\CatRelation::all() as $r)
			<option value="{{$r->typeRelation}}">{{$r->typeRelation}} {{$r->description}}</option>
		@endforeach
	</select>
</div>
<div class="card">
	<div class="card-header">
		<form id="form-search-cfdi">
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Fecha de timbrado:</span>
				</div>
				<input type="text" class="form-control" id="date_cfdi_range">
				<input type="hidden" name="min_date_cfdi">
				<input type="hidden" name="max_date_cfdi">
			</div>
			<div class="div-form-group full" style="padding-left: 0;">
				<p>
					<select id="emiter_cfdi_search" name="emiter_cfdi_search[]" multiple style="width: 100%;">
						@foreach(App\Enterprise::orderName()->get() as $e)
							<option value="{{$e->rfc}}">{{$e->name}}</option>
						@endforeach
					</select>
				</p>
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text">RFC receptor:</span>
				</div>
				<input type="text" class="form-control" name="receptor_cfdi_search" data-validation="custom" data-validation-optional="true" data-validation-regexp="^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$" data-validation-error-msg="Por favor, ingrese un RFC válido">
			</div>
			<div class="text-center">
				<button class="btn btn-blue" type="submit">Buscar</button>
			</div>
		</form>
	</div>
	<div class="card-body cfdi-search-container">
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
				@if($choosen != '')
					@foreach($choosen as $s)
						<tr>
							<td>{{$s->rfc}}</td>
							<td>{{$s->clientRfc}}</td>
							<td>{{$s->uuid}}</td>
							<td>{{$s->statusCFDI}}</td>
							<td>{{$s->stampDate}}</td>
							<td>{{$s->paymentMethod}}</td>
							<td><input type="checkbox" value="{{$s->idBill}}" checked name="cfdi_rel[]" data-uuid="{{$s->uuid}}" data-serie="{{$s->serie}}" data-folio="{{$s->folio}}" data-currency="{{$s->currency}} {{$s->cfdiCurrency->description}}" @if($s->paymentMethod != '') data-payment-method="{{$s->paymentMethod}} {{$s->cfdiPaymentMethod->description}}" @endif ></td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>