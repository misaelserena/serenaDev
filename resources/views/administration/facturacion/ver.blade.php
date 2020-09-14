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
		.icon-xml,
		.icon-pdf
		{
			font-size	: 4rem;
			padding		: 1rem 2rem;
		}
	</style>
@endsection

@section('data')
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">Factura</h5>
		</div>
		<div class="card-body">
			<hr>
			<p>
				<label>Emisor:</label>
			</p>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>RFC:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->rfc}}">
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Razón social:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->businessName}}">
			</div>
			<p>
				<label>Receptor:</label>
			</p>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>RFC:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->clientRfc }}">
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Razón social:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->clientBusinessName }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Folio Fiscal (UUID):</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->uuid }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>No. Certificado Digital:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->noCertificate }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>No. Certificado Digital SAT:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->satCertificateNo }}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Uso de CFDI:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{ $bill->cfdiUse->description }}">
				<div class="input-group-append">
					<span class="input-group-text"><strong>Tipo de CFDI:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->cfdiType->description}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Código postal:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->postalCode}}">
				<div class="input-group-append">
					<span class="input-group-text"><strong>Fecha de timbrado:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->stampDate}}">
			</div>
			@if($bill->paymentWay != null)
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>Forma de pago:</strong></span>
					</div>
					<input type="text" class="form-control" disabled value="{{$bill->cfdiPaymentWay->paymentWay}} {{$bill->cfdiPaymentWay->description}}">
					<div class="input-group-append">
						<span class="input-group-text"><strong>Método de pago:</strong></span>
					</div>
					<input type="text" class="form-control" disabled value="{{$bill->cfdiPaymentMethod->paymentMethod}} {{$bill->cfdiPaymentMethod->description}}">
				</div>
			@endif
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Folio:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->folio}}">
				<div class="input-group-prepend">
					<span class="input-group-text">Serie:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->serie}}">
			</div>
			<div class="input-group mb-5">
				<div class="input-group-prepend">
					<span class="input-group-text">Condiciones de pago:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->conditions}}">
			</div>
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
			<p><br></p>
			<div class="table-responsive">
				<table class="table">
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
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->keyProdServ}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->keyUnit}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->quantity}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->description}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->value}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->amount}}"></td>
												<td class="align-middle"><input type="text" disabled class="form-control-plaintext" value="{{$d->discount}}"></td>
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
																	<td class="align-middle">{{$ret->cfdiTax->description}}</td>
																	<td class="align-middle">{{$ret->quota}}</td>
																	<td class="align-middle">{{$ret->quotaValue}}</td>
																	<td class="align-middle">{{$ret->amount}}</td>
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
																	<td class="align-middle">{{$tras->cfdiTax->description}}</td>
																	<td class="align-middle">{{$tras->quota}}</td>
																	<td class="align-middle">{{$tras->quotaValue}}</td>
																	<td class="align-middle">{{$tras->amount}}</td>
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
			@if($bill->type == 'N')
			<div class="card payments-receipt" style="display: block;">
					<div class="card-header">
						<h5 class="card-title">Nómina</h5>
					</div>
					<div class="card-body">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Datos complementarios del receptor</h5>
							</div>
							<div class="card-body">
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*CURP:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->curp}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Número de seguridad social:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->nss}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Fecha de inicio de relación laboral:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->laboralDateStart}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Antigüedad:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->antiquity}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Riesgo de puesto:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->nominaPositionRisk->description}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Salario diario integrado:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->sdi}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Tipo contrato:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->nominaContract->description}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Tipo régimen:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->nominaRegime->description}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Número de empleado:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->employee_id}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Periodicidad del pago:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->nominaPeriodicity->description}}">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Clave entidad federativa:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nominaReceiver->c_state}} - {{App\State::where('c_state',$bill->nominaReceiver->c_state)->first()->description}}">
								</div>
							</div>
						</div>
						<p><br></p>
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Datos generales de la nómina</h5>
							</div>
							<div class="card-body">
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Tipo de nómina:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="@if($bill->nomina->type=='O') Ordinaria @elseif($bill->nomina->type=='E') Extraordinaria @endif">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Fecha de pago:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nomina->paymentDate}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Fecha inicial de pago:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nomina->paymentStartDate}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Fecha final de pago:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nomina->paymentEndDate}}">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><strong>*Número de días pagados:</strong></span>
									</div>
									<input type="text" class="form-control" disabled value="{{$bill->nomina->paymentDays}}">
								</div>
							</div>
						</div>
						<p><br></p>
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Percepciones</h5>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead class="thead-dark">
											<tr>
												<th width="30%">*Tipo de percepción</th>
												<th width="15%">*Clave</th>
												<th width="35%">*Concepto</th>
												<th width="10%">*Importe gravado</th>
												<th width="10%">*Importe excento</th>
											</tr>
										</thead>
										<tbody>
											@foreach($bill->nomina->nominaPerception as $per)
												<tr>
													<td>{{$per->type}} - {{$per->perception->description}}</td>
													<td>{{$per->perceptionKey}}</td>
													<td>{{$per->concept}}</td>
													<td>{{$per->taxedAmount}}</td>
													<td>{{$per->exemptAmount}}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<p><br></p>
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Deducciones</h5>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead class="thead-dark">
											<tr>
												<th width="35%">*Tipo de deducción</th>
												<th width="15%">*Clave</th>
												<th width="40%">*Concepto</th>
												<th width="10%">*Importe</th>
											</tr>
										</thead>
										<tbody>
											@foreach($bill->nomina->nominaDeduction as $ded)
												<tr>
													<td>{{$ded->type}} - {{$ded->deduction->description}}</td>
													<td>{{$ded->deductionKey}}</td>
													<td>{{$ded->concept}}</td>
													<td>{{$ded->amount}}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<p><br></p>
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Otros pagos</h5>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead class="thead-dark">
											<tr>
												<th width="35%">*Tipo otro pago</th>
												<th width="15%">*Clave</th>
												<th width="40%">*Concepto</th>
												<th width="10%">*Importe</th>
											</tr>
										</thead>
										<tbody>
											@foreach($bill->nomina->nominaOtherPayment as $other)
												<tr>
													<td>{{$other->type}} - {{$other->otherPayment->description}}</td>
													<td>{{$other->otherPaymentKey}}</td>
													<td>{{$other->concept}}</td>
													<td>{{$other->amount}}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<p><br></p>
			@endif
			<div class="mb-5"></div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Subtotal:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->subtotal}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Descuento:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->discount}}">
			</div>
			@if($bill->type != 'P' && $bill->type != 'N')
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Total de impuestos trasladados:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->tras}}">
			</div>
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text">Total de impuestos retenidos:</span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->ret}}">
			</div>
			@endif
			<div class="input-group mb-1">
				<div class="input-group-prepend">
					<span class="input-group-text"><strong>Total:</strong></span>
				</div>
				<input type="text" class="form-control" disabled value="{{$bill->total}}">
			</div>
			<div class="card payments-receipt" @if($bill->type != 'P') style="display: none;" @endif>
				<div class="card-header">
					<h5 class="card-title">Recepción de pagos</h5>
				</div>
				<div class="card-body">
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>*Fecha de pago:</strong></span>
						</div>
						<input type="text" class="form-control" disabled @if($bill->paymentComplement->count()>0) value="{{$bill->paymentComplement->first()->paymentDate}}" @endif>
					</div>
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>*Forma de pago:</strong></span>
						</div>
						<input type="text" class="form-control" disabled @if($bill->paymentComplement->count()>0) value="{{$bill->paymentComplement->first()->complementPaymentWay->description}}" @endif>
					</div>
					<div class="input-group mb-5">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>*Monto:</strong></span>
						</div>
						<input type="text" class="form-control" disabled @if($bill->paymentComplement->count()>0) value="{{$bill->paymentComplement->first()->amount}}" @endif>
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
								@if($bill->type == 'P' && $bill->related != '')
									@foreach($bill->cfdiRelated as $rel)
										<tr>
											<td>{{$rel->uuid}}</td>
											<td>{{$rel->serie}}</td>
											<td>{{$rel->folio}}</td>
											<td>{{$rel->currency}} {{$rel->cfdiCurrency->description}}</td>
											<td>{{$rel->paymentMethod}} {{$rel->cfdiPaymentMethod->description}}</td>
											<td>{{$rel->pivot->partial}}</td>
											<td>{{$rel->pivot->prevBalance}}</td>
											<td>{{$rel->pivot->amount}}</td>
											<td>{{$rel->pivot->unpaidBalance}}</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@if($bill->status == 4)
				<div class="mb-5"></div>
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>Estatus SAT</strong></span>
					</div>
					<input type="text" class="form-control" disabled value="{{$bill->statusCFDI}} @if($bill->status==5) (esperando aprobación) @endif">
				</div>
			@endif
		</div>
		<div class="card-footer text-center">
			@if($bill->status == 1 || $bill->status == 2)
				<div class="input-group mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text"><strong>Estatus SAT</strong></span>
					</div>
					<input type="text" class="form-control" disabled value="{{$bill->statusCFDI}}">
				</div>
				<p><br></p>
				@if(\Storage::disk('reserved')->exists('/stamped/'.$bill->uuid.'.xml'))
					<a href="{{route('stamped.download.xml',$bill->uuid)}}" class="btn btn-blue"><span class="icon-xml"></span></a>
				@endif
				@if(\Storage::disk('reserved')->exists('/stamped/'.$bill->uuid.'.pdf'))
					<a href="{{route('stamped.download.pdf',$bill->uuid)}}" class="btn btn-green"><span class="icon-pdf"></span></a>
				@endif
				<p><br></p>
				<form action="{{route('bill.cancel',$bill->idBill)}}" method="post">
					@csrf
					<button type="submit" class="btn btn-red cancel-cfdi"><span class="icon-x"></span> Cancelar</button>
				</form>
			@elseif($bill->status == 4)
				@if(\Storage::disk('reserved')->exists('/cancelled/'.$bill->uuid.'_acuse.xml'))
					<a href="{{route('cancelled.download.xml',$bill->uuid)}}" class="btn btn-blue"><span class="icon-xml"></span></a>
				@endif
				@if(\Storage::disk('reserved')->exists('/cancelled/'.$bill->uuid.'_acuse.pdf'))
					<a href="{{route('cancelled.download.pdf',$bill->uuid)}}" class="btn btn-green"><span class="icon-pdf"></span></a>
				@endif
			@elseif($bill->status == 3)
				<a href="{{route('bill.cancelled.status',$bill->idBill)}}" class="btn btn-green">Consultar y actualizar estatus</a>
			@endif
		</div>
		<div class="card-footer text-right">
			@if($option_id == 154)
				<a href="{{route('bill.stamped')}}" class="btn btn-red">Regresar</a>
			@else
				<a href="{{route('bill.cancelled')}}" class="btn btn-red">Regresar</a>
			@endif			
		</div>
	</div>
@endsection
@if($bill->status == 1 || $bill->status == 2)
@section('scripts')
	<script type="text/javascript"> 
		$(document).ready(function()
		{
			$(document).on('click','.cancel-cfdi',function(e)
			{
				e.preventDefault();
				actioner	= $(this);
				swal({
					title		: "",
					text		: "Confirme que desea cancelar el comprobante",
					icon		: "warning",
					buttons		:
					{
						cancel:
						{
							text		: "Abortar",
							value		: null,
							visible		: true,
							closeModal	: true,
						},
						confirm:
						{
							text		: "Proceder con la cancelación",
							value		: true,
							closeModal	: false
						}
					},
					dangerMode	: true,
				})
				.then((a) => {
					if (a)
					{
						actioner.parent('form').submit();
					}
				});
			});
		});
	</script>
@endsection
@endif