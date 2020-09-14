@extends('layouts.child_module')
@section('css')
	<style>
		.taxError
		{
			background: #ffd6d1;
		}
		ul.select2-selection__rendered li:not(:first-child)
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
	</style>
@endsection

@section('data')
	{!! Form::open(['route' => ['bill.pending.update',$bill->idBill], 'method' => 'post', 'id' => 'container-factura']) !!}
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Editar factura</h5>
			</div>
			<div class="card-body">
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text">Folio de solicitud de ingreso:</span>
					</div>
					<input type="text" class="form-control" readonly value="{{$bill->folioRequest}}">
				</div>
				<hr>
				<p>
					<label>Emisor:</label>
				</p>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*RFC:</strong></span>
					</div>
					<input type="text" class="form-control" readonly name="rfc_emitter" value="{{$bill->rfc}}">
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Razón social:</strong></span>
					</div>
					<input type="text" class="form-control" readonly name="business_name_emitter" value="{{$bill->businessName}}">
				</div>
				<p>
					<label>Receptor:</label>
				</p>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*RFC:</strong></span>
					</div>
					<input type="text" class="form-control" readonly name="rfc_receiver" value="{{ $bill->clientRfc }}">
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Razón social:</strong></span>
					</div>
					<input type="text" class="form-control" readonly name="business_name_receiver" value="{{ $bill->clientBusinessName }}">
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Uso de CFDI:</strong></span>
					</div>
					@php
						$kind = strlen($bill->clientRfc) == 12 ? 'moral' : 'physical';
						$useCDFI = App\CatUseVoucher::orderName()->where($kind,'Sí');
					@endphp
					<select class="custom-select" name="cfdi_use">
						@foreach($useCDFI->get() as $u)
							<option value="{{$u->useVoucher}}" @if($bill->useBill==$u->useVoucher) selected @endif>{{$u->description}}</option>
						@endforeach
					</select>
					<div class="input-group-append">
						<span class="input-group-text"><strong>*Tipo de CFDI:</strong></span>
					</div>
					<input type="text" class="form-control" readonly value="{{$bill->cfdiType->description}}">
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Código postal:</strong></span>
					</div>
					<select class="custom-select" id="cp_cfdi" name="cp_cfdi" data-validation="required" multiple>
						<option value="{{$bill->postalCode}}" selected>{{$bill->postalCode}}</option>
					</select>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Forma de pago:</strong></span>
					</div>
					<select class="custom-select" name="cfdi_payment_way">
						@foreach(App\CatPaymentWay::orderName()->get() as $p)
							<option value="{{$p->paymentWay}}" @if($bill->paymentWay==$p->paymentWay) selected @endif>{{$p->paymentWay}} {{$p->description}}</option>
						@endforeach
					</select>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Método de pago:</strong></span>
					</div>
					<select class="custom-select" name="cfdi_payment_method">
						@foreach(App\CatPaymentMethod::orderName()->get() as $p)
							<option value="{{$p->paymentMethod}}" @if($bill->paymentMethod==$p->paymentMethod) selected @endif>{{$p->paymentMethod}} {{$p->description}}</option>
						@endforeach
					</select>
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Serie:</span>
					</div>
					<input name="serie" type="text" class="form-control" value="{{$bill->serie}}">
				</div>
				<div class="input-group mb-5">
					<div class="input-group-prepend">
						<span class="input-group-text">Condiciones de pago:</span>
					</div>
					<input type="text" class="form-control" name="conditions" value="{{$bill->conditions}}">
				</div>
				<div class="table-responsive">
					<table class="table cfdi-concepts">
						<thead class="thead-dark">
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
						<thead>
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
														<button type="button" class="btn btn-red cfdi-concept-delete"><span class="icon-x"></span></button>
														<button type="button" class="btn btn-green cfdi-concept-modify"><span class="icon-pencil"></span></button>
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
						</tbody>
					</table>
				</div>
				<div class="mb-5"></div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Subtotal:</strong></span>
					</div>
					<input type="text" class="form-control" readonly name="subtotal" value="{{$bill->subtotal}}">
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Descuento:</span>
					</div>
					<input type="text" class="form-control" readonly name="discount_cfdi" value="{{$bill->discount}}">
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Total de impuestos trasladados:</span>
					</div>
					<input type="text" class="form-control" readonly name="tras_total" value="{{$bill->tras}}">
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Total de impuestos retenidos:</span>
					</div>
					<input type="text" class="form-control" readonly name="ret_total" value="{{$bill->ret}}">
				</div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>*Total:</strong></span>
					</div>
					<input type="text" class="form-control" readonly name="cfdi_total" value="{{$bill->total}}">
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-green" type="submit">Guardar cambios</button>
			</div>
		</div>
	{!! Form::close() !!}
@endsection

@section('scripts')
	<script src="{{ asset('js/select2.min.js') }}"></script>
	<script src="{{ asset('js/jquery.numeric.js') }}"></script>
	<script>
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.validate(
		{
			form		: '#container-factura',
			onSuccess	: function($form)
			{
				if($('#taxRegime').val()!='')
				{
					if($('.table.cfdi-concepts tbody tr').length<1)
					{
						swal('','Al menos debe ingresar un concepto','error');
						return false;
					}
					else if(Number($('[name="cfdi_total"]').val()) <= 0)
					{
						swal('','No pueden timbrarse facturas en cero o total negativo','error');
						return false;
					}
				}
				else
				{
					swal('','La empresa seleccionada no cuenta con régimen fiscal registrado por lo que no se podrá proceder.','warning');
					return false;
				}
			},
		});
		$(document).ready(function()
		{

			$('#cfdi-quantity,#cfdi-value,#cfdi-discount').numeric({ altDecimal: ".", decimalPlaces: 2, negative: false });
			$('.value-tax_fee').numeric({ negative:false});
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
			$(document).on('click','.cfdi-concept-delete',function()
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
				totalGlobal = Number(subtotalGlobal - discountGlobal + transferGlobal - retentionGlobal);
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
				$('#cfdi-product-id').html('<option value="'+selector.find('[name="product_id[]"]').val()+'" selected>'+selector.find('[name="product_id[]"]').val()+' '+selector.find('[name="product_id[]"]').attr('data-text')+'</option>');
				$('#cfdi-unity-id').html('<option value="'+selector.find('[name="unity_id[]"]').val()+'" selected>'+selector.find('[name="unity_id[]"]').val()+' '+selector.find('[name="unity_id[]"]').attr('data-text')+'</option>');
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
							totalGlobal = Number(subtotalGlobal - discountGlobal + transferGlobal - retentionGlobal);
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
				totalGlobal = Number(subtotalGlobal - discountGlobal + transferGlobal - retentionGlobal);
				$('[name="subtotal"]').val(subtotalGlobal);
				$('[name="discount_cfdi"]').val(discountGlobal.toFixed(2));
				$('[name="tras_total"]').val(transferGlobal.toFixed(2));
				$('[name="ret_total"]').val(retentionGlobal.toFixed(2));
				$('[name="cfdi_total"]').val(totalGlobal.toFixed(2));
			})
			.on('click','.tax-add',function()
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
			tax		= Number(total * value).toFixed(6);
			tr.find('.total-tax').val(tax);
			add		= true;
		}
		@if(isset($alert))
			{!! $alert !!}
		@endif
	</script>
@endsection