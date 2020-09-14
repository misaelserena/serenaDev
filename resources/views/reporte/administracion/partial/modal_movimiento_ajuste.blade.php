<div class='modal-content'>
	<div class='modal-header'>
		<span class='close exit'>&times;</span>
	</div>
	<div class='modal-body'>
		<div class="profile-table-center">
			<div class="profile-table-center-header">
				DETALLES DE LA SOLICITUD DE AJUSTE DE MOVIMIENTOS
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Folio:
				</div>
				<div class="right">
					<p></p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Título y fecha:
				</div>
				<div class="right">
					<p></p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Comentarios:
				</div>
				<div class="right">
					<p></p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Solicitante:
				</div>
				<div class="right">
					<p>{{$movement['title'] }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Elaborado por:
				</div>
				<div class="right">
					<p>{{ date('d-m-Y',strtotime($movement['date'])) }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Empresa Origen:
				</div>
				<div class="right">
					<p>{{ $movement['comments'] != "" ? $movement['comments'] : 'Sin comentarios' }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Empresa Destino:
				</div>
				<div class="right">
					<p></p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Empresa Destino:
				</div>
				<div class="right">
					<p></p>
				</div>
			</div>
		</div>
	</div>
	<center>
		<button class="btn btn-red exit">Cerrar</button>
	</center>
</div>

