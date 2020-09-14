@extends('layouts.child_module')
@section('css')
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<style>
		.taxError
		{
			background: #ffd6d1;
		}
		.table-responsive ul.select2-selection__rendered li:not(:first-child)
		{
			height		: 0;
			overflow	: hidden;
		}
		.help-block.form-error
		{
			position	: absolute;
			right		: 0;
			top			: -19px;
		}
		.custom-select + span.select2.select2-container.select2-container--default
		{
			padding	: .2rem .5rem;
		}
		.custom-select + span .select2-selection.select2-selection--multiple
		{
			background		: none !important;
			border-bottom	: 0 !important;
			height			: 1rem;
		}
		.select2-selection__choice
		{
			margin	: 0 !important;
			padding	: .1rem !important;
		}
		.payments-receipt
		{
			display: none;
		}
	</style>
@endsection

@section('data')
	<form id="container-factura" @if(isset($bill)) action="{{route('bill.cfdi.save.saved',$bill->idBill)}}" @else action="{{route('bill.cfdi.save')}}" @endif method="POST">
		@csrf
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Generar CFDI</h5>
			</div>
			<div class="card-body">
				<hr>
				<p>
					<label>Emisor:</label>
				</p>
				@php
					$optionSelect	= '';
					$rfc			= '';
					$businessName	= '';
					$taxRegime		= '';
					$firstOption	= true;
				@endphp
				@foreach(App\Enterprise::orderName()->where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeEnt($option_id)->pluck('enterprise_id'))->get() as $e)
					@php
						if($firstOption)
						{
							$rfc			= $e->rfc;
							$businessName	= $e->name;
							$taxRegime		= ((App\CatTaxRegime::where('taxRegime',$e->taxRegime)->exists())? $e->taxRegime.' - '.App\CatTaxRegime::where('taxRegime',$e->taxRegime)->first()->description : '');
							$firstOption	= false;
						}
						$optionSelect .= '<option value="'.$e->rfc.'" data-tax-regime="'.((App\CatTaxRegime::where('taxRegime',$e->taxRegime)->exists())? $e->taxRegime.' - '.App\CatTaxRegime::where('taxRegime',$e->taxRegime)->first()->description : '').'" '.((isset($bill) && $bill->rfc == $e->rfc) ? 'selected' : '').'>'.$e->name.'</option>';
						if(isset($bill) && $bill->rfc == $e->rfc)
						{
							$rfc			= $e->rfc;
							$businessName	= $e->name;
							$taxRegime		= ((App\CatTaxRegime::where('taxRegime',$e->taxRegime)->exists())? $e->taxRegime.' - '.App\CatTaxRegime::where('taxRegime',$e->taxRegime)->first()->description : '');
						}
					@endphp
				@endforeach
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*RFC:</strong></span>
					</div>
					<input type="text" class="form-control" readonly data-validation="required" name="rfc_emitter" value="{{$rfc}}">
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Razón social:</strong></span>
						<input type="hidden" name="business_name_emitter" value="{{$businessName}}">
					</div>
					<select class="custom-select" id="enterprise_selector">
						{!!$optionSelect!!}
					</select>
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Régimen fiscal:</strong></span>
					</div>
					<input type="text" class="form-control" data-validation="required" name="tax_regime_cfdi" data-validation-error-msg="La empresa no tiene configurado un Régimen Fiscal y no se podrá proceder" readonly value="{{$taxRegime}}">
				</div>
				<p>
					<label>Receptor:</label>
				</p>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*RFC:</strong></span>
					</div>
					<input type="text" class="form-control" data-validation="custom required" name="rfc_receiver" data-validation-regexp="^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$" data-validation-error-msg="Por favor, ingrese un RFC válido" @if(isset($bill)) value="{{$bill->clientRfc}}" @endif>
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Razón social:</strong></span>
					</div>
					<input type="text" class="form-control" data-validation="required" name="business_name_receiver" @if(isset($bill)) value="{{$bill->clientBusinessName}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Uso de CFDI:</strong></span>
					</div>
					<select class="custom-select" name="cfdi_use" @if(isset($bill) && $bill->type == 'P') disabled @endif>
						@if(isset($bill) && $bill->clientRfc != '')
							@php
								$kind = strlen($bill->clientRfc) == 12 ? 'moral' : 'physical';
								$useCDFI = App\CatUseVoucher::orderName()->where($kind,'Sí');
							@endphp
							@foreach($useCDFI->get() as $u)
								<option value="{{$u->useVoucher}}" @if($bill->useBill==$u->useVoucher) selected @endif>{{$u->description}}</option>
							@endforeach
						@endif
					</select>
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Tipo de CFDI:</strong></span>
					</div>
					<select class="custom-select" name="cfdi_kind">
						@foreach(App\CatTypeBill::orderName()->where('typeVoucher','!=','N')->get() as $k)
							<option value="{{$k->typeVoucher}}" @if(isset($bill) && $bill->type == $k->typeVoucher) selected @endif>{{$k->description}}</option>
						@endforeach
					</select>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Código postal:</strong></span>
					</div>
					<select class="custom-select" id="cp_cfdi" name="cp_cfdi" data-validation="required" multiple>
						@if(isset($bill) && $bill->postalCode != '')
							<option value="{{$bill->postalCode}}" selected>{{$bill->postalCode}}</option>
						@endif
					</select>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Forma de pago:</strong></span>
					</div>
					<select class="custom-select" name="cfdi_payment_way" @if(isset($bill) && $bill->type == 'P') disabled @endif>
						@if(isset($bill) && $bill->type == 'P')
							<option hidden disabled selected value></option>
						@endif
						@foreach(App\CatPaymentWay::orderName()->get() as $p)
							<option value="{{$p->paymentWay}}" @if(isset($bill) && $bill->paymentWay==$p->paymentWay) selected @endif>{{$p->paymentWay}} {{$p->description}}</option>
						@endforeach
					</select>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Método de pago:</strong></span>
					</div>
					<select class="custom-select" name="cfdi_payment_method" @if(isset($bill) && $bill->type == 'P') disabled @endif>
						@if(isset($bill) && $bill->type == 'P')
							<option hidden disabled selected value></option>
						@endif
						@foreach(App\CatPaymentMethod::orderName()->get() as $p)
							<option value="{{$p->paymentMethod}}" @if(isset($bill) && $bill->paymentMethod==$p->paymentMethod) selected @elseif(!isset($bill) && $p->paymentMethod=='PUE') selected @endif>{{$p->paymentMethod}} {{$p->description}}</option>
						@endforeach
					</select>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Serie:</span>
					</div>
					<input name="serie" type="text" class="form-control" @if(isset($bill)) value="{{$bill->serie}}" @endif>
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text">Condiciones de pago:</span>
					</div>
					<input type="text" class="form-control" name="conditions" @if(isset($bill)) value="{{$bill->conditions}}" @endif>
				</div>
				<div class="div-form-group modules text-left mb-5" style="display: block;">
					<ul>
						<li>
							<input name="related_cfdi" type="checkbox" value="1" id="related_cfdi" @if(isset($bill) && $bill->related != '') checked @endif>
							<label class="switch" for="related_cfdi"><span class="slider round"></span>CFDI relacionados</label>
						</li>
					</ul>
					<button class="btn btn-blue add-related" type="button" data-toggle="modal" data-target="#relatedCFDIModal" @if(isset($bill) && $bill->related != '')  @else disabled @endif>Agregar relación</button>
					<div class="related-cfdi-container">
						@if(isset($bill) && $bill->related != '')
							<table class="table table-table-striped">
								<thead class="thead-dark">
									<tr>
										<th>{{$bill->related}} {{App\CatRelation::where('typeRelation',$bill->related)->first()->description}}<input type="hidden" name="related_kind_cfdi" value="{{$bill->related}}"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($bill->cfdiRelated as $rel)
										<tr>
											<td>{{$rel->uuid}}<input type="hidden" name="cfdi_related_id[]" value="{{$rel->idBill}}"></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@endif
					</div>
				</div>
				<div class="table-responsive">
					<table class="table cfdi-concepts">
						<thead class="thead-dark" @if(isset($bill) && $bill->type == 'P') style="display: none;" @endif>
							<tr>
								<th><strong>*Clave de producto o servicio</strong></th>
								<th><strong>*Clave de unidad</strong></th>
								<th><strong>*Cantidad</strong></th>
								<th><strong>*Descripción</strong></th>
								<th><strong>*Valor unitario</strong></th>
								<th><strong>*Importe</strong></th>
								<th><strong>*Descuento</strong></th>
								<th>Agregar</th>
							</tr>
						</thead>
						<thead @if(isset($bill) && $bill->type == 'P') style="display: none;" @endif>
							<tr>
								<td>
									<label><select id="cfdi-product-id" style="width: 98%;" multiple></select></label>
								</td>
								<td>
									<label><select id="cfdi-unity-id" style="width: 98%" multiple></select></label>
								</td>
								<td><input type="text" class="form-control" id="cfdi-quantity"></td>
								<td><input type="text" class="form-control" id="cfdi-description"></td>
								<td><input type="text" class="form-control" id="cfdi-value"></td>
								<td><input type="text" class="form-control" readonly id="cfdi-total" value="0"></td>
								<td><input type="text" class="form-control" id="cfdi-discount" value="0"></td>
								<td><button type="button" class="btn btn-blue add-cfdi-concept"><span class="icon-plus"></span></button></td>
							</tr>
							<tr>
								<td><button type="button" class="btn btn-blue tax-add">Agregar impuesto</button></td>
								<td colspan="7">
									<table class="table" id="CFDI_TAXES" style="display: none;">
										<thead class="thead-dark">
											<tr>
												<th>Tipo</th>
												<th>Impuesto</th>
												<th>¿Tasa o cuota?</th>
												<th>Valor de la tasa o cuota</th>
												<th>Importe</th>
												<th>Eliminar</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</td>
							</tr>
						</thead>
						<tbody>
							@if(isset($bill))
								@foreach($bill->billDetail as $d)
									<tr>
										<td colspan="8">
											<table class="table table-borderless">
												<thead class="thead-dark">
													<tr>
														<th><strong>Clave de producto o servicio</strong></th>
														<th><strong>Clave de unidad</strong></th>
														<th><strong>Cantidad</strong></th>
														<th><strong>Descripción</strong></th>
														<th><strong>Valor unitario</strong></th>
														<th><strong>Importe</strong></th>
														<th><strong>Descuento</strong></th>
														<th>Acción</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="align-middle">
															@php
																$id_item	= round(microtime(true) * 1000);
																usleep(10);
															@endphp
															<input name="product_id[]" type="text" readonly class="form-control-plaintext" value="{{$d->keyProdServ}}" data-text="{{$d->cfdi_product->description}}">
															<input name="cfdi_item[]" type="hidden" value="{{$id_item}}"></td>
														<td class="align-middle"><input name="unity_id[]" type="text" readonly class="form-control-plaintext" value="{{$d->keyUnit}}" data-text="{{$d->cfdi_unity->name}}"></td>
														<td class="align-middle"><input name="quantity[]" type="text" readonly class="form-control-plaintext" value="{{$d->quantity}}"></td>
														<td class="align-middle"><input name="description[]" type="text" readonly class="form-control-plaintext" value="{{$d->description}}"></td>
														<td class="align-middle"><input name="valueCFDI[]" type="text" readonly class="form-control-plaintext" value="{{$d->value}}"></td>
														<td class="align-middle"><input name="amount[]" type="text" readonly class="form-control-plaintext" value="{{$d->amount}}"></td>
														<td class="align-middle"><input name="discount[]" type="text" readonly class="form-control-plaintext" value="{{$d->discount}}"></td>
														<td rowspan="2" class="align-middle" style="width: 3%;">
															@if($bill->type != 'P')
																<button type="button" class="btn btn-red cfdi-concept-delete"><span class="icon-x"></span></button>
																<button type="button" class="btn btn-green cfdi-concept-modify"><span class="icon-pencil"></span></button>
															@endif
														</td>
													</tr>
													<tr>
														<td colspan="7">
															@if($d->taxesRet->count()>0)
																<table class="table table-borderless">
																	<thead class="thead-white">
																		<tr>
																			<th colspan="4">Retenciones</th>
																		</tr>
																	</thead>
																	<tbody>
																@foreach($d->taxesRet as $ret)
																		<tr>
																			<td class="align-middle"><input name="ret[{{$id_item}}][]" type="hidden" value="{{$ret->tax}}">{{$ret->cfdiTax->description}}</td>
																			<td class="align-middle"><input name="ret_fee[{{$id_item}}][]" type="text" readonly class="form-control-plaintext" value="{{$ret->quota}}"></td>
																			<td class="align-middle"><input name="ret_tax_fee[{{$id_item}}][]" type="text" readonly class="form-control-plaintext" value="{{$ret->quotaValue}}"></td>
																			<td class="align-middle"><input name="ret_total_tax[{{$id_item}}][]" type="text" readonly class="form-control-plaintext" value="{{$ret->amount}}"></td>
																		</tr>
																@endforeach
																	</tbody>
																</table>
															@endif
															@if($d->taxesTras->count()>0)
																<table class="table table-borderless">
																	<thead class="thead-white">
																		<tr>
																			<th colspan="4">Traslados</th>
																		</tr>
																	</thead>
																	<tbody>
																@foreach($d->taxesTras as $tras)
																		<tr>
																			<td class="align-middle"><input name="tras[{{$id_item}}][]" type="hidden" value="{{$tras->tax}}">{{$tras->cfdiTax->description}}</td>
																			<td class="align-middle"><input name="tras_fee[{{$id_item}}][]" type="text" readonly class="form-control-plaintext" value="{{$tras->quota}}"></td>
																			<td class="align-middle"><input name="tras_tax_fee[{{$id_item}}][]" type="text" readonly class="form-control-plaintext" value="{{$tras->quotaValue}}"></td>
																			<td class="align-middle"><input name="tras_total_tax[{{$id_item}}][]" type="text" readonly class="form-control-plaintext" value="{{$tras->amount}}"></td>
																		</tr>
																@endforeach
																	</tbody>
																</table>
															@endif
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<div class="mb-5"></div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Subtotal:</strong></span>
					</div>
					<input type="text" class="form-control" readonly name="subtotal" @if(isset($bill)) value="{{$bill->subtotal}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Descuento:</span>
					</div>
					<input type="text" class="form-control" readonly name="discount_cfdi" @if(isset($bill)) value="{{$bill->discount}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Total de impuestos trasladados:</span>
					</div>
					<input type="text" class="form-control" readonly name="tras_total" @if(isset($bill)) value="{{$bill->tras}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Total de impuestos retenidos:</span>
					</div>
					<input type="text" class="form-control" readonly name="ret_total" @if(isset($bill)) value="{{$bill->ret}}" @endif>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Total:</strong></span>
					</div>
					<input type="text" class="form-control" readonly name="cfdi_total" @if(isset($bill)) value="{{$bill->total}}" @endif>
				</div>
			</div>
			<p><br></p>
			<div class="card payments-receipt" @if(isset($bill) && $bill->type == 'P') style="display: block;" @endif>
				<div class="card-header">
					<h5 class="card-title">Recepción de pagos</h5>
				</div>
				<div class="card-body">
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>*Fecha de pago:</strong></span>
						</div>
						<input type="text" class="form-control" data-validation="required" name="cfdi_payment_date" @if(isset($bill) && $bill->paymentComplement->count()>0) value="{{$bill->paymentComplement->first()->paymentDate}}" @endif>
					</div>
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>*Forma de pago:</strong></span>
						</div>
						<select class="custom-select" name="cfdi_payment_payment_way">
							@foreach(App\CatPaymentWay::orderName()->get() as $p)
								@if(isset($bill) && $bill->paymentComplement->count()>0 && $bill->paymentComplement->first()->paymentWay==$p->paymentWay)
									<option value="{{$p->paymentWay}}" selected>{{$p->paymentWay}} {{$p->description}}</option>
								@else
									<option value="{{$p->paymentWay}}">{{$p->paymentWay}} {{$p->description}}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="input-group mb-5">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>*Monto:</strong></span>
						</div>
						<input type="text" class="form-control" name="cfdi_payment_amount" data-validation="number required" data-validation-allowing="float" @if(isset($bill) && $bill->paymentComplement->count()>0) value="{{$bill->paymentComplement->first()->amount}}" @endif>
					</div>
					<div class="table-responsive">
						<table class="table table-striped related-payments-cfdi">
							<thead class="thead-dark">
								<tr>
									<th colspan="9">Documentos relacionados</th>
								</tr>
								<tr>
									<th>UUID</th>
									<th>Serie</th>
									<th>Folio</th>
									<th>Moneda</th>
									<th>Método de pago</th>
									<th>Número de parcialidad</th>
									<th>Importe de saldo anterior</th>
									<th>Importe pagado</th>
									<th>Importe de saldo insoluto</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($bill) && $bill->type == 'P' && $bill->related != '')
									@foreach($bill->cfdiRelated as $rel)
										<tr>
											<td>{{$rel->uuid}}<input type="hidden" name="cfdi_payment_related_id[]" value="{{$rel->idBill}}"></td>
											<td>{{$rel->serie}}</td>
											<td>{{$rel->folio}}</td>
											<td>{{$rel->currency}} {{$rel->cfdiCurrency->description}}</td>
											<td>{{$rel->paymentMethod}} {{$rel->cfdiPaymentMethod->description}}</td>
											<td><input type="text" class="form-control" name="cfdi_payment_partial_number[]" data-validation="number" data-validation-optional="true" value="{{$rel->pivot->partial}}"></td>
											<td><input type="text" class="form-control" name="cfdi_payment_last_amount[]" data-validation="number" data-validation-allowing="float" data-validation-optional="true" value="{{$rel->pivot->prevBalance}}"></td>
											<td><input type="text" class="form-control" name="cfdi_payment_comp_amount[]" data-validation="number" data-validation-allowing="float" data-validation-optional="true" value="{{$rel->pivot->amount}}"></td>
											<td><input type="text" class="form-control" name="cfdi_payment_insolute[]" data-validation="number" data-validation-allowing="float" data-validation-optional="true" value="{{$rel->pivot->unpaidBalance}}"></td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<p><br></p>
			<div class="card-footer text-right">
				<div class="div-form-group modules text-left" style="display: block;">
					<ul>
						<li>
							<input name="send_email_cfdi" type="checkbox" value="1" id="email_cfdi">
							<label class="switch" for="email_cfdi"><span class="slider round"></span>Enviar por email</label>
						</li>
					</ul>
				</div>
				<button class="btn btn-blue" id="save_only" type="submit">Guardar CFDI</button>
				<button class="btn btn-green" type="submit" @if(isset($bill)) formaction="{{route('bill.cfdi.stamp.saved',$bill->idBill)}}" @else formaction="{{route('bill.cfdi.stamp')}}" @endif>Timbrar CFDI</button>
			</div>
		</div>
	</form>
	<div class="modal" id="relatedCFDIModal" tabindex="-1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<center>
						<img src="{{asset('images/load.gif')}}" width="100">
					</center>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-green add-cfdi-related">Agregar</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="{{ asset('js/select2.min.js') }}"></script>
	<script src="{{ asset('js/datepicker.js') }}"></script>
	<script src="{{ asset('js/jquery.numeric.js') }}"></script>
	<script>
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		formValidate();
		$(document).ready(function()
		{
			$("#cfdi-value,#cfdi-discount").on("contextmenu",function(e)
			{
				return false;
			});
			$('#cfdi-quantity#cfdi-value,#cfdi-discount').numeric({ altDecimal: ".", decimalPlaces: 2, negative: false });
			$('.value-tax_fee').numeric({ negative:false});

			$('[name="cfdi_payment_date"]').datepicker({ dateFormat: "yy-mm-dd" });
			$('#cfdi-product-id').select2({
				maximumSelectionLength	: 1,
				ajax					:
				{
					delay		: 400,
					url			: '{{route('income.catalogue.product')}}',
					dataType	: 'json',
					method		: 'post',
					data		: function (params)
					{
						s =
						{
							search: params.term,
						}
						return s;
					}
				},
				minimumInputLength		: 3,
				language				:
				{
					noResults: function()
					{
						return "No hay resultados";
					},
					searching: function()
					{
						return "Buscando...";
					},
					inputTooShort: function(args)
					{
						return 'Por favor ingrese más de 3 caracteres';
					}
				}
			});

			$('#cp_cfdi').select2({
				maximumSelectionLength	: 1,
				ajax					:
				{
					delay		: 400,
					url			: '{{route('income.catalogue.zip')}}',
					dataType	: 'json',
					method		: 'post',
					data		: function (params)
					{
						s =
						{
							search: params.term,
						}
						return s;
					}
				},
				minimumInputLength		: 3,
				language				:
				{
					noResults: function()
					{
						return "No hay resultados";
					},
					searching: function()
					{
						return "Buscando...";
					},
					inputTooShort: function(args)
					{
						return 'Por favor ingrese más de 3 caracteres';
					}
				}
			});
			$('#cfdi-unity-id').select2({
				maximumSelectionLength	: 1,
				ajax					:
				{
					delay		: 400,
					url			: '{{route('income.catalogue.unity')}}',
					dataType	: 'json',
					method		: 'post',
					data		: function (params)
					{
						s =
						{
							search: params.term,
						}
						return s;
					}
				},
				minimumInputLength		: 3,
				language				:
				{
					noResults: function()
					{
						return "No hay resultados";
					},
					searching: function()
					{
						return "Buscando...";
					},
					inputTooShort: function(args)
					{
						return 'Por favor ingrese más de 3 caracteres';
					}
				}
			});
			add		= true;
			$(document).on('click','.tax-add',function()
			{
				if($('#cfdi-product-id').val()=='' || $('#cfdi-unity-id').val()=='' || $('#cfdi-quantity').val()=='' || $('#cfdi-value').val()=='' || $('#cfdi-description').val()=='' || $('#cfdi-discount').val()=='')
				{
					swal('','Por favor, concluya con los campos del concepto antes de proceder','warning');
				}
				else if(Number($('#cfdi-quantity').val())==0 || Number($('#cfdi-value').val())==0)
				{
					swal('','La cantidad y el valor unitario no puede ser cero','warning');
				}
				else
				{
					nextStep	= true;
					$('.value-tax_fee').each(function(i,v)
					{
						if($(this).parent('td').parent('tr').find('.fee').val() != 'Exento' && $(this).val()=='')
						{
							nextStep	= false;
						}
					});
					$('.total-tax').each(function(i,v)
					{
						if($(this).parent('td').parent('tr').find('.fee').val() != 'Exento' && $(this).val()=='')
						{
							nextStep	= false;
						}
					});
					if(nextStep)
					{
						taxRow	= '<tr>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select tax-select">';
						taxRow	+= '			<option value="1">Retención</option>';
						taxRow	+= '			<option value="2">Traslado</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select tax-name">';
						taxRow	+= '			<option value="001">ISR</option>';
						taxRow	+= '			<option value="002">IVA</option>';
						taxRow	+= '			<option value="003">IEPS</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select fee">';
						taxRow	+= '			<option value="Tasa">Tasa</option>';
						taxRow	+= '			<option value="Cuota" disabled>Cuota</option>';
						taxRow	+= '			<option value="Exento" disabled>Exento</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<input type="text" class="form-control value-tax_fee">';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<input type="text" class="form-control total-tax" readonly="">';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<button type="button" class="btn btn-red tax-delete"><span class="icon-x"></span></button>';
						taxRow	+= '	</td>';
						taxRow	+= '</tr>';
						$('#CFDI_TAXES tbody').append(taxRow);
						$('.value-tax_fee').numeric({ negative:false});
						if($('#CFDI_TAXES tbody tr').length==1)
						{
							$('#CFDI_TAXES').fadeIn();
						}
					}
					else
					{
						swal('','Por favor, concluya el registro del impuesto antes de agregar uno adicional','warning');
					}
				}
			})
			.on('click','[data-toggle="modal"]',function()
			{
				choosen = [];
				$('[name="cfdi_related_id[]"]').each(function(i,v)
				{
					choosen.push($(this).val());
				});
				$.ajax(
				{
					type	: 'post',
					url		: '{{ route("bill.cfdi.related") }}',
					data	: {'choosen':choosen},
					success	: function(data)
					{
						$('#relatedCFDIModal .modal-body').html(data);
						$('#date_cfdi_range').daterangepicker(
						{
							autoUpdateInput: false,
							locale:
							{
								cancelLabel	: 'Borrar',
								applyLabel	: 'Aplicar',
								daysOfWeek	:
								[
									"Do",
									"Lu",
									"Ma",
									"Mie",
									"Ju",
									"Vi",
									"Sa"
								],
								monthNames	:
								[
									"Enero",
									"Febrero",
									"Marzo",
									"Abril",
									"Mayo",
									"Junio",
									"Julio",
									"Agosto",
									"Septiembre",
									"Octubre",
									"Noviembre",
									"Diciembre"
								],
							}
						});
						$('#date_cfdi_range').on('apply.daterangepicker', function(ev, picker)
						{
							$('input[name="min_date_cfdi"]').val(picker.startDate.format('YYYY-MM-DD'));
							$('input[name="max_date_cfdi"]').val(picker.endDate.format('YYYY-MM-DD'));
							$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
							$('.cfdi-search-container').html('');
						});
						$('#date_cfdi_range').on('cancel.daterangepicker', function(ev, picker)
						{
							date = new Date();
							$(this).val('');
							$('input[name="min_date_cfdi"]').val('');
							$('input[name="max_date_cfdi"]').val('');
							$(this).data('daterangepicker').setStartDate(date.toLocaleDateString("en-US"));
							$(this).data('daterangepicker').setEndDate(date.toLocaleDateString("en-US"));
							$('.cfdi-search-container').html('');
						});
						$('#emiter_cfdi_search').select2(
						{
							placeholder	: 'Emisor',
							language	: "es",
						});
						$.validate({
							form		: '#form-search-cfdi',
							lang		: 'es',
							onSuccess	: function($form)
							{
								info = $form.serializeArray();
								$('[name="cfdi_rel[]"]:checked').each(function(i,v)
								{
									temp	= $(this).serializeArray();
									info.push(temp[0]);
								});
								console.log(info);
								$('.cfdi-search-container').html('<center><img src="{{asset('images/load.gif')}}" width="100"></center>');
								$.ajax({
									method	: 'post',
									data	: info,
									url		: '{{ route('bill.cfdi.related.search') }}',
									success	: function (response)
									{
										$('.cfdi-search-container').html(response);
									}
								});
								return false;
							}
						});
						if($('[name="related_kind_cfdi"]').val())
						{
							$('#cfdi_relation_kind').val($('[name="related_kind_cfdi"]').val());
						}
					}
				});
			})
			.on('click','[data-dismiss="modal"]',function()
			{
				$('.modal-body').html('<center><img src="{{asset('images/load.gif')}}" width="100"></center>');
			})
			.on('change','#cfdi-product-id',function()
			{
				$('#cfdi-unity-id').val(null).trigger('change');
				$('#cfdi-quantity').val('');
				$('#cfdi-description').val('');
				$('#cfdi-value').val('');
				$('#cfdi-total').val(0);
				$('#cfdi-discount').val(0);
				$('#CFDI_TAXES tbody tr').remove();
				$('#CFDI_TAXES').hide();
			})
			.on('change','#emiter_cfdi_search,[name="receptor_cfdi_search"]',function()
			{
				$('.cfdi-search-container').html('');
			})
			.on('click','.tax-delete',function()
			{
				$(this).parent('td').parent('tr').remove();
				if($('#CFDI_TAXES tbody tr').length<1)
				{
					$('#CFDI_TAXES').fadeOut();
				}
			})
			.on('click','.cfdi-concept-delete',function()
			{
				$(this).parent('td').parent('tr').parent('tbody').parent('table').parent('td').parent('tr').remove();
				subtotalGlobal	= 0;
				discountGlobal	= 0;
				retentionGlobal	= 0;
				transferGlobal	= 0;
				$('[name="amount[]"]').each(function(i,v)
				{
					subtotalGlobal += Number($(this).val());
				});
				$('[name="discount[]"]').each(function(i,v)
				{
					discountGlobal += Number($(this).val());
				});
				$('[name^="tras_total_tax"]').each(function(i,v)
				{
					transferGlobal += Number($(this).val());
				});
				$('[name^="ret_total_tax"]').each(function(i,v)
				{
					retentionGlobal += Number($(this).val());
				});
				totalGlobal = Number(Number(subtotalGlobal.toFixed(2)) - Number(discountGlobal.toFixed(2)) + Number(transferGlobal.toFixed(2)) - Number(retentionGlobal.toFixed(2)));
				$('[name="subtotal"]').val(subtotalGlobal.toFixed(2));
				$('[name="discount_cfdi"]').val(discountGlobal.toFixed(2));
				$('[name="tras_total"]').val(transferGlobal.toFixed(2));
				$('[name="ret_total"]').val(retentionGlobal.toFixed(2));
				$('[name="cfdi_total"]').val(totalGlobal.toFixed(2));
			})
			.on('click','.cfdi-concept-modify',function()
			{
				selector	= $(this).parent('td').parent('tr').parent('tbody').parent('table').parent('td').parent('tr');
				selector2	= $(this).parent('td').parent('tr').next('tr').children('td').children('table').children('tbody');
				id			= selector.find('[name="cfdi_item"]').val();
				$('#cfdi-product-id').html('<option value="'+selector.find('[name="product_id[]"]').val()+'" selected>'+selector.find('[name="product_id[]"]').attr('data-text')+'</option>');
				$('#cfdi-unity-id').html('<option value="'+selector.find('[name="unity_id[]"]').val()+'" selected>'+selector.find('[name="unity_id[]"]').attr('data-text')+'</option>');
				$('#cfdi-quantity').val(selector.find('[name="quantity[]"]').val());
				$('#cfdi-description').val(selector.find('[name="description[]"]').val());
				$('#cfdi-value').val(selector.find('[name="valueCFDI[]"]').val());
				$('#cfdi-total').val(selector.find('[name="amount[]"]').val());
				$('#cfdi-discount').val(selector.find('[name="discount[]"]').val());
				ret				= selector2.find('[name^="ret["]');
				ret_fee			= selector2.find('[name^="ret_fee["]');
				ret_tax_fee		= selector2.find('[name^="ret_tax_fee["]');
				ret_total_tax	= selector2.find('[name^="ret_total_tax["]');
				if(ret.length>0)
				{
					ret.each(function(i,v)
					{
						taxRow	= '<tr>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select tax-select">';
						taxRow	+= '			<option value="1" selected>Retención</option>';
						taxRow	+= '			<option value="2">Traslado</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select tax-name">';
						taxRow	+= '			<option value="001" '+(ret.get(i).value=='001'?'selected':'')+'>ISR</option>';
						taxRow	+= '			<option value="002" '+(ret.get(i).value=='002'?'selected':'')+'>IVA</option>';
						taxRow	+= '			<option value="003" '+(ret.get(i).value=='003'?'selected':'')+'>IEPS</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select fee">';
						taxRow	+= '			<option value="Tasa" '+(ret_fee.get(i).value=='Tasa'?'selected':'')+'>Tasa</option>';
						taxRow	+= '			<option value="Cuota" '+(ret_fee.get(i).value=='Cuota'?'selected':'')+'>Cuota</option>';
						taxRow	+= '			<option value="Exento" disabled>Exento</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<input type="text" class="form-control value-tax_fee" value="'+ret_tax_fee.get(i).value+'">';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<input type="text" class="form-control total-tax" readonly="" value="'+ret_total_tax.get(i).value+'">';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<button type="button" class="btn btn-red tax-delete"><span class="icon-x"></span></button>';
						taxRow	+= '	</td>';
						taxRow	+= '</tr>';
						$('#CFDI_TAXES').fadeIn(300).children('tbody').append(taxRow);
					});
				}
				tras				= selector2.find('[name^="tras["]');
				tras_fee			= selector2.find('[name^="tras_fee["]');
				tras_tax_fee		= selector2.find('[name^="tras_tax_fee["]');
				tras_total_tax	= selector2.find('[name^="tras_total_tax["]');
				if(tras.length>0)
				{
					tras.each(function(i,v)
					{
						taxRow	= '<tr>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select tax-select">';
						taxRow	+= '			<option value="1">Retención</option>';
						taxRow	+= '			<option value="2" selected>Traslado</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select tax-name">';
						taxRow	+= '			<option value="001" '+(tras.get(i).value=='001'?'selected':'')+'>ISR</option>';
						taxRow	+= '			<option value="002" '+(tras.get(i).value=='002'?'selected':'')+'>IVA</option>';
						taxRow	+= '			<option value="003" '+(tras.get(i).value=='003'?'selected':'')+'>IEPS</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<select class="custom-select fee">';
						taxRow	+= '			<option value="Tasa" '+(tras_fee.get(i).value=='Tasa'?'selected':'')+'>Tasa</option>';
						taxRow	+= '			<option value="Cuota" '+(tras_fee.get(i).value=='Cuota'?'selected':'')+'>Cuota</option>';
						taxRow	+= '			<option value="Exento" disabled>Exento</option>';
						taxRow	+= '		</select>';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<input type="text" class="form-control value-tax_fee" value="'+tras_tax_fee.get(i).value+'">';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<input type="text" class="form-control total-tax" readonly="" value="'+tras_total_tax.get(i).value+'">';
						taxRow	+= '	</td>';
						taxRow	+= '	<td>';
						taxRow	+= '		<button type="button" class="btn btn-red tax-delete"><span class="icon-x"></span></button>';
						taxRow	+= '	</td>';
						taxRow	+= '</tr>';
						$('#CFDI_TAXES').fadeIn(300).children('tbody').append(taxRow);
					});
				}
				selector.remove();
				subtotalGlobal	= 0;
				discountGlobal	= 0;
				retentionGlobal	= 0;
				transferGlobal	= 0;
				$('[name="amount[]"]').each(function(i,v)
				{
					subtotalGlobal += Number($(this).val());
				});
				$('[name="discount[]"]').each(function(i,v)
				{
					discountGlobal += Number($(this).val());
				});
				$('[name^="tras_total_tax"]').each(function(i,v)
				{
					transferGlobal += Number($(this).val());
				});
				$('[name^="ret_total_tax"]').each(function(i,v)
				{
					retentionGlobal += Number($(this).val());
				});
				totalGlobal = Number(Number(subtotalGlobal.toFixed(2)) - Number(discountGlobal.toFixed(2)) + Number(transferGlobal.toFixed(2)) - Number(retentionGlobal.toFixed(2)));
				$('[name="subtotal"]').val(subtotalGlobal.toFixed(2));
				$('[name="discount_cfdi"]').val(discountGlobal.toFixed(2));
				$('[name="tras_total"]').val(transferGlobal.toFixed(2));
				$('[name="ret_total"]').val(retentionGlobal.toFixed(2));
				$('[name="cfdi_total"]').val(totalGlobal.toFixed(2));
			})
			.on('click','.add-cfdi-concept',function()
			{
				if(add)
				{
					id			= Date.now();
					product		= $('#cfdi-product-id').val();
					productText	= $('#cfdi-product-id option:selected').text();
					unity		= $('#cfdi-unity-id').val();
					unityText	= $('#cfdi-unity-id option:selected').text();
					quantity	= isNaN(Number($('#cfdi-quantity').val())) ? 0 : Number($('#cfdi-quantity').val());
					description	= $('#cfdi-description').val();
					description	= description.replace(/"/g, '&quot;');
					valueCFDI	= isNaN(Number($('#cfdi-value').val())) ? 0 : Number($('#cfdi-value').val());
					total		= $('#cfdi-total').val();
					discount	= isNaN(Number($('#cfdi-discount').val())) ? 0 : Number($('#cfdi-discount').val()).toFixed(6);
					if(quantity==0 || valueCFDI==0)
					{
						swal('','La cantidad y el valor unitario no puede ser cero','warning');
					}
					else if(product == '' || unity=='' || quantity=='' || description =='' || valueCFDI=='' || discount=='')
					{
						swal('','Por favor complete los datos del producto','warning');
					}
					else
					{
						nextStep	= true;
						$('.value-tax_fee').each(function(i,v)
						{
							if($(this).parent('td').parent('tr').find('.fee').val() != 'Exento' && $(this).val()=='')
							{
								nextStep	= false;
							}
						});
						$('.total-tax').each(function(i,v)
						{
							if($(this).parent('td').parent('tr').find('.fee').val() != 'Exento' && $(this).val()=='')
							{
								nextStep	= false;
							}
						});
						if(nextStep)
						{
							tr = '<tr>';
							tr += '	<td colspan="8">';
							tr += '		<table class="table table-borderless">';
							tr += '			<thead class="thead-dark">';
							tr += '				<tr>';
							tr += '					<th><strong>Clave de producto o servicio</strong></th>';
							tr += '					<th><strong>Clave de unidad</strong></th>';
							tr += '					<th><strong>Cantidad</strong></th>';
							tr += '					<th><strong>Descripción</strong></th>';
							tr += '					<th><strong>Valor unitario</strong></th>';
							tr += '					<th><strong>Importe</strong></th>';
							tr += '					<th><strong>Descuento</strong></th>';
							tr += '					<th>Acción</th>';
							tr += '				</tr>';
							tr += '			</thead>';
							tr += '			<tbody>';
							tr += '				<tr>';
							tr += '					<td class="align-middle"><input name="product_id[]" type="text" readonly data-text="'+productText+'" class="form-control-plaintext" value="'+product+'">';
							tr += '					<input name="cfdi_item[]" type="hidden" value="'+id+'"></td>';
							tr += '					<td class="align-middle"><input name="unity_id[]" type="text" readonly data-text="'+unityText+'" class="form-control-plaintext" value="'+unity+'"></td>';
							tr += '					<td class="align-middle"><input name="quantity[]" type="text" readonly class="form-control-plaintext" value="'+quantity+'"></td>';
							tr += '					<td class="align-middle"><input name="description[]" type="text" readonly class="form-control-plaintext" value="'+description+'"></td>';
							tr += '					<td class="align-middle"><input name="valueCFDI[]" type="text" readonly class="form-control-plaintext" value="'+valueCFDI+'"></td>';
							tr += '					<td class="align-middle"><input name="amount[]" type="text" readonly class="form-control-plaintext" value="'+total+'"></td>';
							tr += '					<td class="align-middle"><input name="discount[]" type="text" readonly class="form-control-plaintext" value="'+discount+'"></td>';
							tr += '					<td rowspan="2" class="align-middle" style="width: 3%;">';
							tr += '						<button type="button" class="btn btn-red cfdi-concept-delete"><span class="icon-x"></span></button>';
							tr += '						<button type="button" class="btn btn-green cfdi-concept-modify"><span class="icon-pencil"></span></button>';
							tr += '					</td>';
							tr += '				</tr>';
							tr += '				<tr>';
							tr += '					<td colspan="7">';
							retFirst	= true;
							retTable	= '';
							trasFirst	= true;
							trasTable	= '';
							$('#CFDI_TAXES tbody tr').each(function(i,v)
							{
								if($(this).find('.tax-select').val()==1)
								{
									if(retFirst)
									{
										retTable	= '	<table class="table table-borderless">';
										retTable	+= '		<thead class="thead-white">';
										retTable	+= '			<tr>';
										retTable	+= '				<th colspan="4">Retenciones</th>';
										retTable	+= '			</tr>';
										retTable	+= '		</thead>';
										retTable	+= '		<tbody>';
										retFirst	= false;
									}
									retTable	+= '				<tr>';
									retTable	+= '					<td class="align-middle"><input name="ret['+id+'][]" type="hidden" value="'+$(this).find('.tax-name').val()+'">'+$(this).find('.tax-name option:selected').text()+'</td>';
									retTable	+= '					<td class="align-middle"><input name="ret_fee['+id+'][]" type="text" readonly class="form-control-plaintext" value="'+$(this).find('.fee').val()+'"></td>';
									retTable	+= '					<td class="align-middle"><input name="ret_tax_fee['+id+'][]" type="text" readonly class="form-control-plaintext" value="'+$(this).find('.value-tax_fee').val()+'"></td>';
									retTable	+= '					<td class="align-middle"><input name="ret_total_tax['+id+'][]" type="text" readonly class="form-control-plaintext" value="'+$(this).find('.total-tax').val()+'"></td>';
									retTable	+= '				</tr>';
								}
								else
								{
									if(trasFirst)
									{
										trasTable	= '	<table class="table table-borderless">';
										trasTable	+= '		<thead class="thead-white">';
										trasTable	+= '			<tr>';
										trasTable	+= '				<th colspan="4">Traslados</th>';
										trasTable	+= '			</tr>';
										trasTable	+= '		</thead>';
										trasTable	+= '		<tbody>';
										trasFirst	= false;
									}
									trasTable	+= '				<tr>';
									trasTable	+= '					<td class="align-middle"><input name="tras['+id+'][]" type="hidden" value="'+$(this).find('.tax-name').val()+'">'+$(this).find('.tax-name option:selected').text()+'</td>';
									trasTable	+= '					<td class="align-middle"><input name="tras_fee['+id+'][]" type="text" readonly class="form-control-plaintext" value="'+$(this).find('.fee').val()+'"></td>';
									trasTable	+= '					<td class="align-middle"><input name="tras_tax_fee['+id+'][]" type="text" readonly class="form-control-plaintext" value="'+$(this).find('.value-tax_fee').val()+'"></td>';
									trasTable	+= '					<td class="align-middle"><input name="tras_total_tax['+id+'][]" type="text" readonly class="form-control-plaintext" value="'+$(this).find('.total-tax').val()+'"></td>';
									trasTable	+= '				</tr>';
								}
							});
							if(!retFirst)
							{
								retTable	+= '				</tbody>';
								retTable	+= '			</table>';
							}
							if(!trasFirst)
							{
								trasTable	+= '				</tbody>';
								trasTable	+= '			</table>';
							}
							tr += retTable+trasTable;
							tr += '					</td>';
							tr += '				</tr>';
							tr += '			</tbody>';
							tr += '		</table>';
							tr += '	</td>';
							tr += '</tr>';
							$('.cfdi-concepts>tbody').append(tr);
							$('#cfdi-product-id').val(null).trigger('change');
							$('#cfdi-unity-id').val(null).trigger('change');
							$('#cfdi-quantity').val('');
							$('#cfdi-description').val('');
							$('#cfdi-value').val('');
							$('#cfdi-total').val(0);
							$('#cfdi-discount').val(0);
							$('#CFDI_TAXES tbody tr').remove();
							$('#CFDI_TAXES').hide();
							subtotalGlobal	= 0;
							discountGlobal	= 0;
							retentionGlobal	= 0;
							transferGlobal	= 0;
							$('[name="amount[]"]').each(function(i,v)
							{
								subtotalGlobal += Number($(this).val());
							});
							$('[name="discount[]"]').each(function(i,v)
							{
								discountGlobal += Number($(this).val());
							});
							$('[name^="tras_total_tax"]').each(function(i,v)
							{
								transferGlobal += Number($(this).val());
							});
							$('[name^="ret_total_tax"]').each(function(i,v)
							{
								retentionGlobal += Number($(this).val());
							});
							totalGlobal = Number(Number(subtotalGlobal.toFixed(2)) - Number(discountGlobal.toFixed(2)) + Number(transferGlobal.toFixed(2)) - Number(retentionGlobal.toFixed(2)));
							$('[name="subtotal"]').val(subtotalGlobal.toFixed(2));
							$('[name="discount_cfdi"]').val(discountGlobal.toFixed(2));
							$('[name="tras_total"]').val(transferGlobal.toFixed(2));
							$('[name="ret_total"]').val(retentionGlobal.toFixed(2));
							$('[name="cfdi_total"]').val(totalGlobal.toFixed(2));
						}
						else
						{
							swal('','Por favor complete todos los datos de los impuestos','warning');
						}
					}
				}
				else
				{
					swal('','Hay un error en sus datos, por favor verifique antes de continuar','error');
				}
			})
			.on('input','#cfdi-quantity',function()
			{
				q		= isNaN(Number($(this).val())) ? 0 : Number($(this).val());
				v		= isNaN(Number($('#cfdi-value').val())) ? 0 : Number($('#cfdi-value').val());
				total	= q * v;
				$('#cfdi-total').val(total);
			})
			.on('input','#cfdi-value',function()
			{
				v		= isNaN(Number($(this).val())) ? 0 : Number($(this).val());
				q		= isNaN(Number($('#cfdi-quantity').val())) ? 0 : Number($('#cfdi-quantity').val());
				total	= q * v;
				$('#cfdi-total').val(total);
			})
			.on('change','.tax-select', function()
			{
				tipoImp		= Number($(this).val());
				impuesto	= $(this).parent('td').parent('tr').find('.tax-name').val();
				factor		= $(this).parent('td').parent('tr').find('.fee').val();
				valor		= $(this).parent('td').parent('tr').find('.value-tax_fee').val()!='' ? Number($(this).parent('td').parent('tr').find('.value-tax_fee').val()) : null;
				tr			= $(this).parent('td').parent('tr');
				if(tipoImp==1)
				{
					$(this).parent('td').parent('tr').find('.fee').val('Tasa');
					$(this).parent('td').parent('tr').find('.fee option[value="Exento"]').prop('disabled',true);
				}
				else
				{
					$(this).parent('td').parent('tr').find('.fee').val('Tasa');
					$(this).parent('td').parent('tr').find('.fee option[value="Exento"]').prop('disabled',false);
				}
				if(impuesto != '' && factor != '' && valor != null)
				{
					rules(tipoImp,impuesto,factor,valor,tr);
				}
			})
			.on('change','.fee',function()
			{
				if($(this).val() == 'Exento')
				{
					$(this).parent('td').parent('tr').find('.value-tax_fee').val('').prop('disabled',true);
					$(this).parent('td').parent('tr').find('.total-tax').val('');
				}
				else
				{
					$(this).parent('td').parent('tr').find('.value-tax_fee').val('').prop('disabled',false);
					tipoImp		= Number($(this).parent('td').parent('tr').find('.tax-select').val());
					impuesto	= $(this).parent('td').parent('tr').find('.tax-name').val();
					factor		= $(this).parent('td').parent('tr').find('.fee').val();
					valor		= $(this).parent('td').parent('tr').find('.value-tax_fee').val()!='' ? Number($(this).parent('td').parent('tr').find('.value-tax_fee').val()) : null;
					tr			= $(this).parent('td').parent('tr');
					if(impuesto != '' && factor != '' && valor != null)
					{
						rules(tipoImp,impuesto,factor,valor,tr);
					}
				}
			})
			.on('change','.tax-name', function()
			{
				impuesto	= $(this).val();
				if(impuesto == '001' || impuesto == '002')
				{
					$(this).parent('td').parent('tr').find('.fee option[value="Cuota"]').prop('disabled',true);
					$(this).parent('td').parent('tr').find('.fee').val('Tasa');
				}
				else
				{
					$(this).parent('td').parent('tr').find('.fee option[value="Cuota"]').prop('disabled',false);
				}
				tipoImp		= Number($(this).parent('td').parent('tr').find('.tax-select').val());
				factor		= $(this).parent('td').parent('tr').find('.fee').val();
				valor		= $(this).parent('td').parent('tr').find('.value-tax_fee').val()!='' ? Number($(this).parent('td').parent('tr').find('.value-tax_fee').val()) : null;
				tr			= $(this).parent('td').parent('tr');
				if(impuesto != '' && factor != '' && valor != null)
				{
					rules(tipoImp,impuesto,factor,valor,tr);
				}
			})
			.on('focusout','.value-tax_fee',function()
			{
				tipoImp		= Number($(this).parent('td').parent('tr').find('.tax-select').val());
				impuesto	= $(this).parent('td').parent('tr').find('.tax-name').val();
				factor		= $(this).parent('td').parent('tr').find('.fee').val();
				valor		= $(this).val()!='' ? Number($(this).val()) : null;
				tr			= $(this).parent('td').parent('tr');
				if(impuesto != '' && factor != '')
				{
					rules(tipoImp,impuesto,factor,valor,tr);
				}
			})
			.on('focusout','#cfdi-value,#cfdi-quantity',function()
				{
					v		= isNaN(Number($('#cfdi-value').val())) ? 0 : Number($('#cfdi-value').val());
					q		= isNaN(Number($('#cfdi-quantity').val())) ? 0 : Number($('#cfdi-quantity').val());
					total	= q * v;
					$('#cfdi-total').val(total);
				})
			.on('change','[name="cfdi_payment_way"]',function()
			{
				if($(this).val()=='99')
				{
					$('[name="cfdi_payment_method"]').val('PPD');
				}
				else
				{
					$('[name="cfdi_payment_method"]').val('PUE');
				}
			})
			.on('change','[name="cfdi_payment_method"]',function()
			{
				if($(this).val()=='PUE' && $('[name="cfdi_payment_way"]').val()=='99')
				{
					$('[name="cfdi_payment_way"]').val('01');
				}
				else if($(this).val()=='PPD' && $('[name="cfdi_payment_way"]').val()!='99')
				{
					$('[name="cfdi_payment_way"]').val('99');
				}
			})
			.on('input','#cfdi-quantity,#cfdi-value,#cfdi-discount',function()
			{
				$('#CFDI_TAXES tbody tr').each(function(i,v)
				{
					tipoImp		= $(this).find('.tax-select').val();
					impuesto	= $(this).find('.tax-name').val();
					factor		= $(this).find('.fee').val();
					valor		= $(this).find('.value-tax_fee').val();
					rules(tipoImp,impuesto,factor,valor,$(this))
				});
			})
			.on('change','[name="send_email_cfdi"]',function()
			{
				if($(this).is(':checked'))
				{
					$(this).parents('.modules').append('<button type="button" class="btn btn-blue add-email-cfdi mb-1"><span class="icon-plus"></span> Agregar email</button>');
					$(this).parents('.modules').append('<div class="input-group mb-1 email-cfdi"><input type="email" class="form-control" data-validation="required email" name="email_cfdi[]"></div>');
					formValidate();
				}
				else
				{
					$('.add-email-cfdi,.email-cfdi').remove();
					form = $(this).parent('li').parent('ul').parent('div').parent('form');
					form[0].reset();
				}
			})
			.on('click','.add-email-cfdi',function()
			{
				$(this).parents('.modules').append('<div class="input-group mb-1 email-cfdi"><input type="email" class="form-control" data-validation="required email" name="email_cfdi[]"><div class="input-group-append"><button class="btn btn-red delete-email-cfdi" type="button"><span class="icon-x"></span></button></div></div>');
				formValidate();
			})
			.on('change','#related_cfdi',function()
			{
				if($(this).is(':checked'))
				{
					$('.add-related').prop('disabled',false);
				}
				else
				{
					$('.add-related').prop('disabled',true);
					$('.related-cfdi-container').html('');
					$('.related-payments-cfdi tbody').html('');
				}
			})
			.on('click','.delete-email-cfdi',function()
			{
				$(this).parent('.input-group-append').parent('.input-group').remove();
				formValidate();
			})
			.on('change','#enterprise_selector',function()
			{
				rfc				= $(this).val();
				businessName	= $(this).find('option:selected').text();
				taxRegime		= $(this).find('option:selected').attr('data-tax-regime');
				$('[name="business_name_emitter"]').val(businessName);
				$('[name="rfc_emitter"]').val(rfc);
				$('[name="tax_regime_cfdi"]').val(taxRegime);
			})
			.on('input','[name="rfc_receiver"]',function()
			{
				m		= p = '';
				@foreach(App\CatUseVoucher::orderName()->where('moral','Sí')->get() as $m)
					m += '<option value="{{$m->useVoucher}}">{{$m->description}}</option>';
				@endforeach
				@foreach(App\CatUseVoucher::orderName()->where('physical','Sí')->get() as $p)
					p += '<option value="{{$p->useVoucher}}">{{$p->description}}</option>';
				@endforeach
				if($(this).val().length == 12)
				{
					$('[name="cfdi_use"]').html(m);
				}
				else if($(this).val().length == 13)
				{
					$('[name="cfdi_use"]').html(p);
				}
				else
				{
					$('[name="cfdi_use"]').html('');
				}
				if($('[name="cfdi_kind"]').val() == 'P')
				{
					$('[name="cfdi_use"]').val('P01');
				}
			})
			.on('click','.add-cfdi-related',function()
			{
				if($('[name="cfdi_rel[]"]:checked').length>0)
				{
					tr = '';
					$('[name="cfdi_rel[]"]:checked').each(function(i,v)
					{
						tr += '<tr><td>'+$(this).attr('data-uuid')+'<input type="hidden" name="cfdi_related_id[]" value="'+$(this).val()+'"></td></tr>';
					});
					table = '<table class="table table-table-striped"><thead class="thead-dark"><tr><th>'+$('#cfdi_relation_kind option:selected').text()+'<input type="hidden" name="related_kind_cfdi" value="'+$('#cfdi_relation_kind').val()+'"></th></tr></thead><tbody>'+tr+'</tbody></table>';
					$('.related-cfdi-container').html(table);
					if($('[name="cfdi_kind"]').val() == 'P')
					{
						tr2 = '';
						$('[name="cfdi_rel[]"]:checked').each(function(i,v)
						{
							tr2 += '<tr><td>'+$(this).attr('data-uuid')+'<input type="hidden" name="cfdi_payment_related_id[]" value="'+$(this).val()+'"></td><td>'+$(this).attr('data-serie')+'</td><td>'+$(this).attr('data-folio')+'</td><td>'+$(this).attr('data-currency')+'</td><td>'+$(this).attr('data-payment-method')+'</td><td><input type="text" class="form-control" name="cfdi_payment_partial_number[]" data-validation="number" data-validation-optional="true"></td><td><input type="text" class="form-control" name="cfdi_payment_last_amount[]" data-validation="number" data-validation-allowing="float" data-validation-optional="true"></td><td><input type="text" class="form-control" name="cfdi_payment_comp_amount[]" data-validation="number" data-validation-allowing="float" data-validation-optional="true"></td><td><input type="text" class="form-control" name="cfdi_payment_insolute[]" data-validation="number" data-validation-allowing="float" data-validation-optional="true"></td></tr>';
						});
						$('.related-payments-cfdi tbody').html(tr2);
						formValidate();
					}
					$(this).parents('.modal').fadeOut();
				}
				else
				{
					swal('','Debe seleccioanr al menos un CFDI para relacionar','warning');
				}
			})
			.on('change','[name="cfdi_kind"]',function()
			{
				$('[name="related_cfdi"]').prop('checked',false);
				$('.add-related').prop('disabled',true);
				$('.related-cfdi-container').html('');
				$('[name="subtotal"]').val('0.00');
				$('[name="discount_cfdi"]').val('0.00');
				$('[name="tras_total"]').val('0.00');
				$('[name="ret_total"]').val('0.00');
				$('[name="cfdi_total"]').val('0.00');
				if($(this).val() == 'P')
				{
					$('.cfdi-concepts thead').hide();
					$('[name="cfdi_payment_way"]').prop('disabled',true).val('');
					$('[name="cfdi_payment_method"]').prop('disabled',true).val('');
					$('[name="cfdi_use"]').prop('disabled',true).val('P01');
					$('.cfdi-concepts>tbody').html('<tr><td colspan="8"><table class="table table-borderless"><thead class="thead-dark"><tr><th><strong>Clave de producto o servicio</strong></th><th><strong>Clave de unidad</strong></th><th><strong>Cantidad</strong></th><th><strong>Descripción</strong></th><th><strong>Valor unitario</strong></th><th><strong>Importe</strong></th><th><strong>Descuento</strong></th><th>Acción</th></tr></thead><tbody><tr><td class="align-middle"><input name="product_id[]" type="text" readonly="" class="form-control-plaintext" value="84111506"><input name="cfdi_item[]" type="hidden" value="1568074175290"></td><td class="align-middle"><input name="unity_id[]" type="text" readonly="" class="form-control-plaintext" value="ACT"></td><td class="align-middle"><input name="quantity[]" type="text" readonly="" class="form-control-plaintext" value="1"></td><td class="align-middle"><input name="description[]" type="text" readonly="" class="form-control-plaintext" value="Pago"></td><td class="align-middle"><input name="valueCFDI[]" type="text" readonly="" class="form-control-plaintext" value="0"></td><td class="align-middle"><input name="amount[]" type="text" readonly="" class="form-control-plaintext" value="0"></td><td class="align-middle"><input name="discount[]" type="text" readonly="" class="form-control-plaintext" value=""></td><td rowspan="2" class="align-middle" style="width: 3%;"></td></tr><tr><td colspan="7"></td></tr></tbody></table></td></tr>');
					$('.payments-receipt').show();
				}
				else
				{
					$('.cfdi-concepts thead').show();
					$('[name="cfdi_payment_way"]').prop('disabled',false).val('01');
					$('[name="cfdi_payment_method"]').prop('disabled',false).val('PUE');
					$('[name="cfdi_use"]').prop('disabled',false);
					$('.cfdi-concepts>tbody').html('');
					$('related-payments-cfdi').html('');
					$('.payments-receipt').hide();
				}
				formValidate();
			})
			.on('click','#save_only',function()
			{
				$('#container-factura')[0].submit();
			});
		});
		function rules(tipoImp,impuesto,factor,valor,tr)
		{
			if(tipoImp == 1) //Retención
			{
				if(impuesto == '002' && factor == 'Tasa' && valor >= 0 && valor <= 0.16)
				{
					acceptedTax(valor,tr);
				}
				else if(impuesto == '003' && factor == 'Tasa' && (valor == 0.265000 || valor == 0.300000 || valor== 0.530000 || valor == 0.500000 || valor == 1.600000 || valor == 0.304000 || valor == 0.250000 || valor == 0.090000 || valor == 0.080000 || valor == 0.070000 || valor == 0.060000))
				{
					acceptedTax(valor,tr);
				}
				else if(impuesto == '003' && factor == 'Cuota' && valor <= 43.770000 && valor >= 0.000000)
				{
					acceptedTax(valor,tr);
				}
				else if(impuesto == '001' && factor == 'Tasa' && valor <= 0.350000 && valor >= 0.000000)
				{
					acceptedTax(valor,tr);
				}
				else
				{
					notAcceptedTax(tr)
				}
			}
			else //Traslado
			{
				if(impuesto == '002' && factor == 'Tasa' && (valor == 0 || valor == 0.16))
				{
					acceptedTax(valor,tr);
				}
				else if(impuesto == '002' && factor == 'Tasa' && valor == 0.080000)
				{
					acceptedTax(valor,tr);
				}
				else if(impuesto == '003' && factor == 'Tasa' && (valor == 0.265000 || valor == 0.300000 || valor== 0.530000 || valor == 0.500000 || valor == 1.600000 || valor == 0.304000 || valor == 0.250000 || valor == 0.090000 || valor == 0.080000 || valor == 0.070000 || valor == 0.060000 || valor == 0.030000 || valor == 0.000000))
				{
					acceptedTax(valor,tr);
				}
				else if(impuesto == '003' && factor == 'Cuota' && valor <= 43.770000 && valor >= 0.000000)
				{
					acceptedTax(valor,tr);
				}
				else
				{
					notAcceptedTax(tr)
				}
			}
		}
		function notAcceptedTax(tr)
		{
			tr.addClass('taxError');
			swal('','No se encuentra la combinación de impuesto y tipo factor en el catálogo de tasa o cuota','warning');
			add	= false;
		}
		function acceptedTax(value,tr)
		{
			tr.removeClass('taxError');
			total	= Number($('#cfdi-total').val()).toFixed(6);
			discount	= Number($('#cfdi-discount').val()).toFixed(6);
			tax		= Number((total-discount) * value).toFixed(6);
			tr.find('.total-tax').val(tax);
			add		= true;
		}
		function formValidate()
		{
			$.validate(
			{
				form		: '#container-factura',
				onSuccess	: function($form)
				{
					if($('[name="cfdi_kind"]').val() == 'P' && $('[name="cfdi_payment_related_id[]"]').length < 1)
					{
						swal('','Al menos debe ingresar un documento relacionado.','error');
						return false;
					}
					if($('#taxRegime').val()!='')
					{
						if($('.table.cfdi-concepts tbody tr').length<1)
						{
							swal('','Al menos debe ingresar un concepto','error');
							return false;
						}
						else if(Number($('[name="cfdi_total"]').val()) <= 0 && $('[name="cfdi_kind"]').val() != 'P')
						{
							swal('','No pueden timbrarse facturas en cero o total negativo','error');
							return false;
						}
						else
						{
							swal({
								icon				: "{{asset('/images/load.gif')}}",
								button				: false,
								closeOnEsc			: false,
								closeOnClickOutside	: false,
							});
						}
					}
					else
					{
						swal('','La empresa seleccionada no cuenta con régimen fiscal registrado por lo que no se podrá proceder.','warning');
						return false;
					}
				},
			});
		}
	</script>
@endsection