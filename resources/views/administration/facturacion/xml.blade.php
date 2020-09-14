<?php
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<cfdi:Comprobante
	xmlns:cfdi="http://www.sat.gob.mx/cfd/3"
@if($bill->type == 'P')
	xmlns:pago10="http://www.sat.gob.mx/Pagos"
@endif
@if($bill->type == 'N')
	xmlns:nomina12="http://www.sat.gob.mx/nomina12"
@endif
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd @if($bill->type == 'P') http://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd @endif @if($bill->type == 'N') http://www.sat.gob.mx/nomina12 http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd @endif"
	Version="3.3"
@if($bill->serie!=null)
	Serie="{{$bill->serie}}"
@endif
@if($bill->folio!=null)
	Folio="{{$bill->folio}}"
@endif
	Fecha="{{str_replace(" ","T",$bill->expeditionDateCFDI)}}"
@if(isset($sello) && $sello!='')
	Sello="{{$sello}}"
@endif
@if($bill->paymentWay!=null)
	FormaPago="{{$bill->paymentWay}}"
@endif
	NoCertificado="{{$noCertificado}}"
@if(isset($certificado) && $certificado!='')
	Certificado="{{$certificado}}"
@endif
@if($bill->conditions != null)
	CondicionesDePago="{{$bill->conditions}}"
@endif
	SubTotal="{{$bill->subtotal}}"
@if($bill->type != 'P')
	Descuento="{{$bill->discount}}"
@endif
	Moneda="{{$bill->currency}}"
	Total="{{$bill->total}}"
	TipoDeComprobante="{{$bill->type}}"
@if($bill->paymentMethod!=null)
	MetodoPago="{{$bill->paymentMethod}}"
@endif
	LugarExpedicion="{{$bill->postalCode}}">
@if($bill->related != null)
	<cfdi:CfdiRelacionados TipoRelacion="{{$bill->related}}">
@foreach($bill->cfdiRelated as $rel)
		<cfdi:CfdiRelacionado UUID="{{$rel->uuid}}"></cfdi:CfdiRelacionado>
@endforeach
	</cfdi:CfdiRelacionados>
@endif
	<cfdi:Emisor Rfc="{{$bill->rfc}}" Nombre="{{$bill->businessName}}" RegimenFiscal="{{$bill->taxRegime}}"></cfdi:Emisor>
	<cfdi:Receptor Rfc="{{$bill->clientRfc}}" Nombre="{{$bill->clientBusinessName}}" UsoCFDI="{{$bill->useBill}}"></cfdi:Receptor>
@php
	$trasCFDI = $retCFDI = array();
@endphp
	<cfdi:Conceptos>
	@foreach($bill->billDetail as $d)
		<cfdi:Concepto ClaveProdServ="{{$d->keyProdServ}}" @if($bill->type == 'N') Cantidad="1" @else Cantidad="{{$d->quantity}}" @endif ClaveUnidad="{{$d->keyUnit}}" Descripcion="{{$d->description}}" ValorUnitario="{{$d->value}}" Importe="{{$d->amount}}" @if($bill->type != 'P') Descuento="{{$d->discount}}" @endif>
		@if($d->taxes->count()>0)
			<cfdi:Impuestos>
			@if($d->taxesTras->count()>0)
				<cfdi:Traslados>
				@foreach($d->taxesTras as $t)
					<cfdi:Traslado Base="{{$t->base}}" Impuesto="{{$t->tax}}" TipoFactor="{{$t->quota}}" @if($t->quota != 'Exento') TasaOCuota="{{$t->quotaValue}}" Importe="{{$t->amount}}" @endif></cfdi:Traslado>
					@php
						if(isset($trasCFDI[$t->tax][$t->quota][$t->quotaValue]) && $t->quota != 'Exento')
						{
							$trasCFDI[$t->tax][$t->quota][$t->quotaValue] += $t->amount; 
						}
						elseif($t->quota != 'Exento')
						{
							$trasCFDI[$t->tax][$t->quota][$t->quotaValue] = $t->amount;
						}
					@endphp
				@endforeach
				</cfdi:Traslados>
			@endif
			@if($d->taxesRet->count()>0)
				<cfdi:Retenciones>
				@foreach($d->taxesRet as $r)
					<cfdi:Retencion Base="{{$r->base}}" Impuesto="{{$r->tax}}" TipoFactor="{{$r->quota}}" TasaOCuota="{{$r->quotaValue}}" Importe="{{$r->amount}}"></cfdi:Retencion>
					@php
						if(isset($retCFDI[$r->tax]))
						{
							$retCFDI[$r->tax] += $r->amount;
						}
						else
						{
							$retCFDI[$r->tax] = $r->amount;
						}
					@endphp
				@endforeach
				</cfdi:Retenciones>
			@endif
			</cfdi:Impuestos>
		@endif
		</cfdi:Concepto>
	@endforeach
	</cfdi:Conceptos>
@if($bill->type == 'I' || $bill->type == 'E')
	<cfdi:Impuestos @if(count($retCFDI)>0) TotalImpuestosRetenidos="{{$bill->ret}}" @endif @if(count($trasCFDI)>0) TotalImpuestosTrasladados="{{$bill->tras}}" @endif>
	@if(count($retCFDI)>0)
		<cfdi:Retenciones>
			@foreach($retCFDI as $kImp => $imp)
				<cfdi:Retencion Impuesto="{{$kImp}}" Importe="{{round($imp,2)}}"></cfdi:Retencion>
			@endforeach
		</cfdi:Retenciones>
	@endif
	@if(count($trasCFDI)>0)
		<cfdi:Traslados>
			@foreach($trasCFDI as $kImp => $imp)
				@foreach($imp as $kTipFac => $tipFac)
					@foreach($tipFac as $kTasCuot => $tasCuot)
						<cfdi:Traslado Impuesto="{{$kImp}}" TipoFactor="{{$kTipFac}}" TasaOCuota="{{$kTasCuot}}" Importe="{{round($tasCuot,2)}}"></cfdi:Traslado>
					@endforeach
				@endforeach
			@endforeach
		</cfdi:Traslados>
	@endif
	</cfdi:Impuestos>
@endif
@if($bill->type == 'P')
	<cfdi:Complemento>
		<pago10:Pagos Version="1.0">
			<pago10:Pago FechaPago="{{$bill->paymentComplement->first()->paymentDate}}T00:00:00" FormaDePagoP="{{$bill->paymentComplement->first()->paymentWay}}" MonedaP="{{$bill->paymentComplement->first()->currency}}" Monto="{{$bill->paymentComplement->first()->amount}}" NumOperacion="1">
	@foreach($bill->cfdiRelated as $rel)
				<pago10:DoctoRelacionado IdDocumento="{{$rel->uuid}}" MonedaDR="{{$rel->currency}}" MetodoDePagoDR="{{$rel->paymentMethod}}" NumParcialidad="{{$rel->pivot->partial}}" ImpSaldoAnt="{{$rel->pivot->prevBalance}}" ImpPagado="{{$rel->pivot->amount}}" ImpSaldoInsoluto="{{$rel->pivot->unpaidBalance}}"></pago10:DoctoRelacionado>
	@endforeach
			</pago10:Pago>
		</pago10:Pagos>
	</cfdi:Complemento>
@endif
@if($bill->type == 'N')
	<cfdi:Complemento>
		<nomina12:Nomina Version="1.2" FechaPago="{{$bill->nomina->paymentDate}}" FechaInicialPago="{{$bill->nomina->paymentStartDate}}" FechaFinalPago="{{$bill->nomina->paymentEndDate}}" NumDiasPagados="{{$bill->nomina->paymentDays}}" TipoNomina="{{$bill->nomina->type}}" @if($bill->nomina->perceptions>0) TotalPercepciones="{{$bill->nomina->perceptions}}" @endif @if($bill->nomina->deductions>0) TotalDeducciones="{{$bill->nomina->deductions}}" @endif @if($bill->nomina->nominaOtherPayment->count()>0) TotalOtrosPagos="{{$bill->nomina->other_payments}}" @endif>
		@if($bill->nominaReceiver->contractType_id != '09' && $bill->nominaReceiver->contractType_id != '10' && $bill->nominaReceiver->contractType_id != '99')
			<nomina12:Emisor RegistroPatronal="{{$bill->nomina->employer_register}}" />
		@endif
			<nomina12:Receptor Curp="{{$bill->nominaReceiver->curp}}" TipoContrato="{{$bill->nominaReceiver->contractType_id}}" TipoRegimen="{{$bill->nominaReceiver->regime_id}}" NumEmpleado="{{$bill->nominaReceiver->employee_id}}" PeriodicidadPago="{{$bill->nominaReceiver->periodicity}}" ClaveEntFed="{{$bill->nominaReceiver->c_state}}" @if($bill->nominaReceiver->contractType_id != '09' && $bill->nominaReceiver->contractType_id != '10' && $bill->nominaReceiver->contractType_id != '99') NumSeguridadSocial="{{$bill->nominaReceiver->nss}}" FechaInicioRelLaboral="{{$bill->nominaReceiver->laboralDateStart}}" Antigüedad="{{$bill->nominaReceiver->antiquity}}" RiesgoPuesto="{{$bill->nominaReceiver->job_risk}}" SalarioDiarioIntegrado="{{$bill->nominaReceiver->sdi}}" @endif/>
		@if($bill->nomina->nominaPerception->count()>0)
			@php
				$salary				= round($bill->nomina->nominaPerception->whereNotIn('type',['022','023','025','039','044'])->sum('taxedAmount') + $bill->nomina->nominaPerception->whereNotIn('type',['022','023','025','039','044'])->sum('exemptAmount'),2);
				$indemnification	= round($bill->nomina->nominaPerception->whereIn('type',['022','023','025'])->sum('taxedAmount') + $bill->nomina->nominaPerception->whereIn('type',['022','023','025'])->sum('exemptAmount'),2);
				$retirement			= round($bill->nomina->nominaPerception->whereIn('type',['039','044'])->sum('taxedAmount') + $bill->nomina->nominaPerception->whereIn('type',['039','044'])->sum('exemptAmount'),2);
			@endphp
			<nomina12:Percepciones TotalGravado="{{$bill->nomina->nominaPerception->sum('taxedAmount')}}" TotalExento="{{$bill->nomina->nominaPerception->sum('exemptAmount')}}" @if($salary > 0) TotalSueldos="{{$salary}}" @endif @if($indemnification > 0) TotalSeparacionIndemnizacion="{{$indemnification}}" @endif @if($retirement > 0) TotalJubilacionPensionRetiro="{{$retirement}}" @endif>
			@foreach($bill->nomina->nominaPerception as $per)
				<nomina12:Percepcion TipoPercepcion="{{$per->type}}" Clave="{{$per->perceptionKey}}" Concepto="{{$per->concept}}" ImporteGravado="{{$per->taxedAmount}}" ImporteExento="{{$per->exemptAmount}}" />
			@endforeach
			@if($bill->nomina->nominaIndemnification != '')
				<nomina12:SeparacionIndemnizacion TotalPagado="{{$bill->nomina->nominaIndemnification->total_paid}}" NumAñosServicio="{{$bill->nomina->nominaIndemnification->service_year}}" UltimoSueldoMensOrd="{{$bill->nomina->nominaIndemnification->last_ordinary_monthly_salary}}" IngresoAcumulable="{{$bill->nomina->nominaIndemnification->cumulative_income}}" IngresoNoAcumulable="{{$bill->nomina->nominaIndemnification->non_cumulative_income}}"/>
			@endif
			</nomina12:Percepciones>
		@endif
		@if($bill->nomina->nominaDeduction->count()>0)
			<nomina12:Deducciones @if($bill->nomina->nominaDeduction->where('type','!=','002')->sum('amount')>0)TotalOtrasDeducciones="{{$bill->nomina->nominaDeduction->where('type','!=','002')->sum('amount')}}" @endif @if($bill->nomina->nominaDeduction->where('type','002')->sum('amount')>0) TotalImpuestosRetenidos="{{$bill->nomina->nominaDeduction->where('type','002')->sum('amount')}}" @endif>
			@foreach($bill->nomina->nominaDeduction as $ded)
				<nomina12:Deduccion TipoDeduccion="{{$ded->type}}" Clave="{{$ded->deductionKey}}" Concepto="{{$ded->concept}}" Importe="{{$ded->amount}}" />
			@endforeach
			</nomina12:Deducciones>
		@endif
		@if($bill->nomina->nominaOtherPayment->count()>0)
			<nomina12:OtrosPagos>
			@foreach($bill->nomina->nominaOtherPayment as $otr)
				@if($otr->type == '002')
					<nomina12:OtroPago TipoOtroPago="{{$otr->type}}" Clave="{{$otr->otherPaymentKey}}" Concepto="{{$otr->concept}}" Importe="{{$otr->amount}}">
						<nomina12:SubsidioAlEmpleo SubsidioCausado="{{$otr->subsidy_caused}}" />
					</nomina12:OtroPago>
				@else
					<nomina12:OtroPago TipoOtroPago="{{$otr->type}}" Clave="{{$otr->otherPaymentKey}}" Concepto="{{$otr->concept}}" Importe="{{$otr->amount}}"/>
				@endif
			@endforeach
			</nomina12:OtrosPagos>
		@endif
		</nomina12:Nomina>
	</cfdi:Complemento>
@endif
</cfdi:Comprobante>
