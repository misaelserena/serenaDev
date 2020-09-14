@if(count($requests) > 0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.movements-accounts.excel') }}"><span class='icon-file-excel'></span></button></div>
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<th width="14.28%">Folio</th>
				<th>Tipo</th>
				<th width="14.28%">Solicitante</th>
				<th width="14.28%">Elaborado por</th>
				<th width="14.28%">Estado</th>
				<th width="14.28%">Fecha de elaboración</th>
				<th>Empresa</th>
				<th width="14.28%">Clasificación del gasto</th>
				<th width="14.28%">Acción</th>
				
			</thead>
			@foreach($requests as $request)
				<tr>
					<td>{{ $request->folio }}</td>
					<td>{{ $request->requestkind->kind }}</td>
					<td>{{ $request->requestUser()->exists() ? $request->requestUser->name.' '.$request->requestUser->last_name.' '.$request->requestUser->scnd_last_name : 'No hay' }}</td>
					<td>{{ $request->elaborateUser->name.' '.$request->elaborateUser->last_name.' '.$request->elaborateUser->scnd_last_name }}</td>
					<td>
						{{ $request->statusrequest->description }}
					</td>
					@php	
						$time	= strtotime($request->fDate);
						$date	= date('d-m-Y H:i',$time);
					@endphp 
					<td>{{ $date  }}</td>
					<td>
						Varias
					</td>
					<td>
						Varias
					</td>
					<td>
						<a alt="Ver nómina" title="Ver solicitud" class='btn follow-btn view-request'><span class='icon-search'></span></a>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@else
	<div id="not-found" style="display:block;">No hay solicitudes</div>
@endif