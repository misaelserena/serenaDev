<div class="modal-content">
	<div class="modal-header" style="border:none;display:block">
		<span class="close exit">&times;</span>
	</div>
	<div class="modal-body">
		<center>
			<strong>DATOS PERSONALES</strong>
		</center>
		<div class="divisor">
			<div class="gray-divisor"></div>
			<div class="orange-divisor"></div>
			<div class="gray-divisor"></div>
		</div>
		<div>
			<table class="employee-details">
				<tbody>
					<tr>
						<td><b>Nombre:</b></td>
						<td><label>{{ $employee->name.' '.$employee->last_name.' '.$employee->scnd_last_name }}</label></td>
					</tr>
					<tr>
						<td><b>CURP:</b></td>
						<td><label>{{ $employee->curp }}</label></td>
					</tr>
					<tr>
						<td><b>RFC:</b></td>
						<td><label>{{ $employee->rfc }}</label></td>
					</tr>
					<tr>
						<td><b>#IMSS:</b></td>
						<td><label>{{ $employee->imss }}</label></td>
					</tr>
					<tr>
						<td><b>Calle:</b></td>
						<td><label>{{ $employee->street }}</label></td>
					</tr>
					<tr>
						<td><b>Número:</b></td>
						<td><label>{{ $employee->number }}</label></td>
					</tr>
					<tr>
						<td><b>Colonia:</b></td>
						<td><label>{{ $employee->colony }}</label></td>
					</tr>
					<tr>
						<td><b>CP:</b></td>
						<td><label>{{ $employee->cp }}</label></td>
					</tr>
					<tr>
						<td><b>Ciudad:</b></td>
						<td><label>{{ $employee->city }}</label></td>
					</tr>
					<tr>
						<td><b>Estado:</b></td>
						<td><label>{{ $employee->states->description }}</label></td>
					</tr>
				</tbody>
			</table><br><br>
		</div>
		<center>
			<strong>DATOS LABORALES</strong>
		</center>
		<div class="divisor">
			<div class="gray-divisor"></div>
			<div class="orange-divisor"></div>
			<div class="gray-divisor"></div>
		</div>
		<div>
			<table class="employee-details">
				<tbody>
					<tr>
						<td><b>Estado:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->states()->exists() ? $employee->workerData->where('visible',1)->first()->states->description : '' }}</label></td>
					</tr>
					<tr>
						<td><b>Proyecto:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->projects()->exists() ? $employee->workerData->where('visible',1)->first()->projects->proyectName : '' }}</label></td>
					</tr>
					<tr>
						<td><b>Empresa:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->enterprises()->exists() ? $employee->workerData->where('visible',1)->first()->enterprises->name : '' }}</label></td>
					</tr>
					<tr>
						<td><b>Clasificación de gasto:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->accounts->account.' '.$employee->workerData->where('visible',1)->first()->accounts->description }}</label></td>
					</tr>
					<tr>
						<td><b>Lugar de Trabajo:</b></td>
						<td>
							@foreach ($employee->workerData->where('visible',1)->first()->places as $p) 
								<label>{{ $p->place }}</label>, 
							@endforeach
			 			</td>
					</tr>
					<tr>
						<td><b>Dirección:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->directions()->exists() ? $employee->workerData->where('visible',1)->first()->directions->name : '' }}</label></td>
					</tr>
					<tr>
						<td><b>Departamento:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->departments()->exists() ? $employee->workerData->where('visible',1)->first()->departments->name : '' }}</label></td>
					</tr>
					<tr>
						<td><b>Registro patronal:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->employer_register }}</label></td>
					</tr>
					<tr>
						<td><b>Puesto:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->position }}</label></td>
					</tr>
					<tr>
						<td><b>Fecha de ingreso:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->admissionDate }}</label></td>
					</tr>
					<tr>
						<td><b>Fecha de alta IMSS:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->imssDate }}</label></td>
					</tr>
					<tr>
						<td><b>Fecha de baja:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->downDate }}</label></td>
					</tr>
					<tr>
						<td><b>Fecha de término de relación laboral:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->endingDate }}</label></td>
					</tr>
					<tr>
						<td><b>Reingreso:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->reentryDate }}</label></td>
					</tr>
					<tr>
						<td><b>Tipo de trabajador:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->worker()->exists() ?  $employee->workerData->where('visible',1)->first()->worker->description : 'no hay' }} </label></td>
					</tr>
					<tr>
						<td><b>Estatus:</b></td>
						<td><label>
						@if ($employee->workerData->where('visible',1)->first()->workerStatus == 1) 
							 Activo
						@endif
						@if ($employee->workerData->where('visible',1)->first()->workerStatus == 2) 
							 Baja pacial
						@endif
						@if ($employee->workerData->where('visible',1)->first()->workerStatus == 3) 
							 Baja definitiva
						@endif
						@if ($employee->workerData->where('visible',1)->first()->workerStatus == 4) 
							 Suspensión
						@endif
						@if ($employee->workerData->where('visible',1)->first()->workerStatus == 5) 
							 Boletinado
						@endif
			 </label></td>
					</tr>
					<tr>
						<td><b>SDI:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->sdi }}</label></td>
					</tr>
					<tr>
						<td><b>Periodicidad:</b></td>
						<td><label>{{ App\CatPeriodicity::where('c_periodicity',$employee->workerData->where('visible',1)->first()->periodicity)->first()->description }}</label></td>
					</tr>
					<tr>
						<td><b>Sueldo neto:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->netIncome }}</label></td>
					</tr>
					<tr>
						<td><b>Complemento:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->complement }}</label></td>
					</tr>
					<tr>
						<td><b>Monto Fonacot:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->fonacot }}</label></td>
					</tr>
					<tr>
						<td><b>Número de crédito:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->infonavitCredit }}</label></td>
					</tr>
					<tr>
						<td><b>Descuento:</b></td>
						<td><label>{{ $employee->workerData->where('visible',1)->first()->infonavitDiscount }}</label></td>
					</tr>
					<tr>
						<td><b>Tipo de descuento:</b></td>
						<td><label>
						@if ($employee->workerData->where('visible',1)->first()->infonavitDiscountType == 1) 
							 VSM (Veces Salario Mínimo)
						@endif
						@if ($employee->workerData->where('visible',1)->first()->infonavitDiscountType == 2) 
							 Cuota fija
						@endif
						@if ($employee->workerData->where('visible',1)->first()->infonavitDiscountType == 3) 
							 Porcentaje
						@endif
			 </label></td>
					</tr>
				</tbody>
			</table>
			<p><br></p>
			<div class="table-responsive">
				<table class="table" style="min-width: 100%;">
					<thead class="thead-dark">
						<tr>
							<th colspan="2">Esquema de pagos</th>
						</tr>
						<tr>
							<th>Porcentaje de nómina</th>
							<th>Porcentaje de bonos</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<center>
									<b>{{ $employee->workerData->where('visible',1)->first()->nomina }}</b>
								</center>
							</td>
							<td>
								<center>
									<b>{{ $employee->workerData->where('visible',1)->first()->bono }}</b>
								</center>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<p><br></p>
			<center>
				<strong>CUENTAS BANCARIAS</strong>
			</center>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div>
			<p><br></p>
			<div class="table-responsive">
				<table class="table full-table" id="bank-data-register">
					<thead class="thead-dark">
						<tr>
							<th>Alias</th>
							<th>Banco</th>
							<th>CLABE</th>
							<th>Cuenta</th>
							<th>Tarjeta</th>
							<th>Sucursal</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($employee->bankData->where('visible',1) as $b) 
							<tr>
								<td>{{ $b->alias }}</td>
								<td>{{ $b->bank->description }}</td>
								<td>{{ $b->clabe }}</td>
								<td>{{ $b->account }}</td>
								<td>{{ $b->cardNumber }}</td>
								<td>{{ $b->branch }}</td>
							</tr>
						@endforeach
		 			</tbody>
				</table>
			</div>
		</div>
	</div>
	<center><button type="button" class="btn btn-red exit" title="Cerrar"><span class="icon-x"></span> Cerrar</button></center><br>
</div>