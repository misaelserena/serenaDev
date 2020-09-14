<div class='modal-content'>
	<div class='modal-header'>
		<span class='close exit'>&times;</span>
	</div>
	<div class='modal-body'>
		<div class="profile-table-center">
			<div class="profile-table-center-header">
				Detalles de movimiento
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Empresa
				</div>
				<div class="right">
					<p>{{ $movement->enterprise->name }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Clasificación del gasto
				</div>
				<div class="right">
					<p>{{ $movement->accounts->account.' - '.$movement->accounts->description.'('.$movement->accounts->content.')' }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Tipo de movimiento
				</div>
				<div class="right">
					<p>{{ $movement->movementType }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Descripción:
				</div>
				<div class="right">
					<p>{{$movement->description }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Fecha
				</div>
				<div class="right">
					<p>{{ date('d-m-Y',strtotime($movement->movementDate)) }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Comentarios
				</div>
				<div class="right">
					<p>{{ $movement->commentaries != "" ? $movement->commentaries : 'Sin comentarios' }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Importe
				</div>
				<div class="right">
					<p>{{ $movement->amount }}</p>
				</div>
			</div>
		</div>
	</div>
	<center>
		<button class="btn btn-red exit">Cerrar</button>
	</center>
</div>

