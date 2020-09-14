<div class='modal-content'>
	<div class='modal-header'>
		<span class='close exit'>&times;</span>
	</div>
	<div class='modal-body'>
		<div class="profile-table-center">
			<div class="profile-table-center-header">
				Detalles de pago
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Folio:
				</div>
				<div class="right">
					<p>{{$payment->idFolio }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Tipo de solicitud
				</div>
				<div class="right">
					<p>{{ $payment->request->requestkind->kind }}</p>
				</div>
			</div><div class="profile-table-center-row">
				<div class="left">
					Empresa
				</div>
				<div class="right">
					<p>{{ $payment->enterprise->name }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Clasificación del gasto
				</div>
				<div class="right">
					<p>{{ $payment->accounts->account.' - '.$payment->accounts->description.'('.$payment->accounts->content.')' }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Fecha
				</div>
				<div class="right">
					<p>{{ date('d-m-Y',strtotime($payment->paymentDate)) }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Comentarios
				</div>
				<div class="right">
					<p>{{ $payment->commentaries != "" ? $payment->commentaries : 'Sin comentarios' }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Importe
				</div>
				<div class="right">
					<p>{{ $payment->amount }}</p>
				</div>
			</div>
			<div class="profile-table-center-row no-border">
				<div class="left">
					Documentos adjuntos
				</div>
				<div class="right">
					@if($payment->documentsPayments()->exists())
						@foreach($payment->documentsPayments as $doc)
							<p>
								<a href="{{ asset('/docs/payments/'.$doc->path) }}" target="_blank" class="btn btn-red" title="{{ $doc->path }}"><span class="icon-pdf"></span></a>
							</p>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
	<center>
		<button class="btn btn-red exit">Cerrar</button>
	</center>
</div>

