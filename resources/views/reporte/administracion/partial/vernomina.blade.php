<div class='modal-content'>
	<div class='modal-header'>
		<span class='close exit'>&times;</span>
	</div>
	<div class='modal-body'>
		<div class="profile-table-center">
			<div class="profile-table-center-header">
				Detalles de la Solicitud de Nómina de {{ App\CatTypePayroll::find($request->nominasReal->first()->idCatTypePayroll)->description }}
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Folio:
				</div>
				<div class="right">
					<p>{{$request->folio }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Título y fecha:
				</div>
				<div class="right">
					<p>{{$request->nominasReal->first()->title }} - {{ $request->nominasReal->first()->datetitle }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Categoria:
				</div>
				<div class="right">
					<p>{{ $request->idDepartment == 11 ? 'Obra' : 'Administrativa' }} - {{ $request->taxPayment == 1 ? 'Fiscal' : 'No fiscal' }}</p>
				</div>
			</div>
			<div class="profile-table-center-row">
				<div class="left">
					Tipo:
				</div>
				<div class="right">
					<p>{{ $request->nominasReal->first()->typePayroll->description }}</p>
				</div>
			</div>
			@switch($request->nominasReal->first()->idCatTypePayroll)
				@case('001')
					<div class="profile-table-center-row">
						<div class="left">
							Periodicidad:
						</div>
						<div class="right">
							<p>{{ App\CatPeriodicity::find($request->nominasReal->first()->idCatPeriodicity)->description }}</p>
						</div>
					</div>
					<div class="profile-table-center-row">
						<div class="left">
							Rango de fecha:
						</div>
						<div class="right">
							<p>{{ $request->nominasReal->first()->from_date }} - {{ $request->nominasReal->first()->to_date }}</p>
						</div>
					</div>
				@break
				@case('002')

				@break
				@case('003')

				@break
				@case('004')

				@break
				@case('005')

				@break
				@case('006')

				@break
			@endswitch
			<div class="profile-table-center-row">
				<div class="left">
					Solicitante:
				</div>
				<div class="right">
					<p>{{ $request->requestUser->name }} {{ $request->requestUser->last_name }} {{ $request->requestUser->scnd_last_name }}</p>
				</div>
			</div>
			<div class="profile-table-center-row no-border">
				<div class="left">
					Elaborado por:
				</div>
				<div class="right">
					<p>{{ $request->elaborateUser->name }} {{ $request->elaborateUser->last_name }} {{ $request->elaborateUser->scnd_last_name }}</p>
				</div>
			</div>
		</div>

		<center>
			<center>
			<strong>Lista de Empleados <span class="help-btn" id="help-btn-add-employee"></span></strong>
			</center>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div><br>
		</center>
		@if($request->taxPayment == 1)
			@switch($request->nominasReal->first()->idCatTypePayroll)
				@case('001')
					<div class="table-responsive">
						<table id="table" class="table table-striped">
							<thead class="thead-dark">
								<th width="15%">Nombre del Empleado</th>
								<th width="10%">Desde</th>
								<th width="10%">Hasta</th>
								<th width="15%">Periodicidad</th>
								<th width="5%">Faltas</th>
								<th width="5%">Préstamo (Percepción)</th>
								<th width="5%">Préstamo (Retención)</th>
							</thead>
							<tbody id="body-payroll" class="request-validate">
								@foreach($request->nominasReal->first()->nominaEmployee->where('visible',1) as $n)
									<tr>
										<td>
											{{ $n->employee->first()->name.' '.$n->employee->first()->last_name.' '.$n->employee->first()->scnd_last_name }}
										</td>
										<td>
											{{ $n->from_date }}
										</td>
										<td>
											{{ $n->to_date }}
										</td>
										<td>
											{{ App\CatPeriodicity::where('c_periodicity',$n->idCatPeriodicity)->first()->description }}
										</td>
										<td>
											{{ $n->absence!= '' ? $n->absence : '---'  }}
										</td>
										<td>
											{{ $n->loan_perception!= '' ? $n->loan_perception : '---'  }}
										</td>
										<td>
											{{ $n->loan_retention!= '' ? $n->loan_retention : '---'  }}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@break
				@case('002')
					<div class="table-responsive">
						<table id="table" class="table table-striped">
							<thead class="thead-dark">
								<th width="50%">Nombre del Empleado</th>
								<th width="20%">Días para aguinaldo</th>
							</thead>
							<tbody id="body-payroll" class="request-validate">
								@foreach($request->nominasReal->first()->nominaEmployee->where('visible',1) as $n)
									<tr>
										<td>
											<input type="hidden" class="type_payroll" value="002">
											<input type="hidden" class="idnominaEmployee" value="{{ $n->idnominaEmployee }}">
											<input type="hidden" name="idrealEmployee[]" class="idrealEmployee" value="{{ $n->idrealEmployee }}">
											<input type="hidden" name="idworkingData[]" class="idworkingData" value="{{ $n->idworkingData }}">
											{{ $n->employee->first()->name.' '.$n->employee->first()->last_name.' '.$n->employee->first()->scnd_last_name }}
										</td>
										<td>
											{{ $n->day_bonus }}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@break
				@case('003')
					<div class="table-responsive">
						<table id="table" class="table table-striped">
							<thead class="thead-dark">
								<th width="30%">Nombre del Empleado</th>
								<th width="25%">Fecha de baja</th>
								<th width="10%">Días trabajados</th>
								<th width="10%">Otras percepciones</th>
							</thead>
							<tbody id="body-payroll" class="request-validate">
								@foreach($request->nominasReal->first()->nominaEmployee->where('visible',1) as $n)
									<tr>
										<td>
											<input type="hidden" class="type_payroll" value="003">
											<input type="hidden" class="idnominaEmployee" value="{{ $n->idnominaEmployee }}">
											<input type="hidden" name="idrealEmployee[]" class="idrealEmployee" value="{{ $n->idrealEmployee }}">
											<input type="hidden" name="idworkingData[]" class="idworkingData" value="{{ $n->idworkingData }}">
											{{ $n->employee->first()->name.' '.$n->employee->first()->last_name.' '.$n->employee->first()->scnd_last_name }}
										</td>
										<td>
											@if($request->status == 2)
												<input type="text" class="input-text datepicker2 down_date" name="down_date[]" data-validation="required" placeholder="Fecha" readonly="readonly">
											@else
												{{ $n->down_date }}
											@endif
										</td>
										<td>
											@if($request->status == 2)
												<input type="text" name="worked_days[]" placeholder="0" class="input-text" value="365">
											@else
												{{ $n->worked_days }}
											@endif
										</td>
										<td>
											@if($request->status == 2)
												<input type="text" name="other_perception[]" placeholder="0" class="input-text" value="365">
											@else
												{{ $n->other_perception }}
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@break
				@case('004')
					<div class="table-responsive">
						<table id="table" class="table table-striped">
							<thead class="thead-dark">
								<th width="30%">Nombre del Empleado</th>
								<th width="25%">Fecha de baja</th>
								<th width="10%">Días trabajados</th>
								<th width="10%">Otras percepciones</th>
							</thead>
							<tbody id="body-payroll" class="request-validate">
								@foreach($request->nominasReal->first()->nominaEmployee->where('visible',1) as $n)
									<tr>
										<td>
											{{ $n->employee->first()->name.' '.$n->employee->first()->last_name.' '.$n->employee->first()->scnd_last_name }}
										</td>
										<td>
											@if($request->status == 2)
												<input type="text" class="input-text datepicker2 down_date" name="down_date[]" data-validation="required" placeholder="Fecha" readonly="readonly">
											@else
												{{ $n->down_date }}
											@endif
										</td>
										<td>
											@if($request->status == 2)
												<input type="text" name="worked_days[]" placeholder="0" class="input-text" value="365">
											@else
												{{ $n->worked_days }}
											@endif
										</td>
										<td>
											@if($request->status == 2)
												<input type="text" name="other_perception[]" placeholder="0" class="input-text" value="365">
											@else
												{{ $n->other_perception }}
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					
				@break
				@case('005')
					<div class="table-responsive">
						<table id="table" class="table table-striped">
							<thead class="thead-dark">
								<th width="50%">Nombre del Empleado</th>
								<th width="20%">Días trabajados</th>
							</thead>
							<tbody id="body-payroll" class="request-validate">
								@foreach($request->nominasReal->first()->nominaEmployee->where('visible',1) as $n)
									<tr>
										<td>
											{{ $n->employee->first()->name.' '.$n->employee->first()->last_name.' '.$n->employee->first()->scnd_last_name }}
										</td>
										<td>
											{{ $n->worked_days }}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@break
				@case('006')
					<div class="table-responsive">
						<table id="table" class="table table-striped">
							<thead class="thead-dark">
								<th width="50%">Nombre del Empleado</th>
								<th width="20%">Días trabajados</th>
							</thead>
							<tbody id="body-payroll" class="request-validate">
								@foreach($request->nominasReal->first()->nominaEmployee->where('visible',1) as $n)
									<tr>
										<td>
											{{ $n->employee->first()->name.' '.$n->employee->first()->last_name.' '.$n->employee->first()->scnd_last_name }}
										</td>
										<td>
											{{ $n->worked_days }}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@break
			@endswitch
		@else
			<br>
			<div class="table-responsive">
				<table id="table" class="table table-striped">
					<thead class="thead-dark">
						<th hidden># Empleado</th>
						<th width="20%">Nombre del Empleado</th>
						<th width="20%">Tipo</th>
						<th width="20%">Fiscal/No Fiscal</th>
					</thead>
					<tbody id="body-payroll" class="request-validate">
						@foreach($request->nominasReal->first()->nominaEmployee->where('visible',1) as $n)
							<tr>
								<td>
									{{ $n->employee->first()->name.' '.$n->employee->first()->last_name.' '.$n->employee->first()->scnd_last_name }}
								</td>
								<td>{{ $n->type == 1 ? 'Obra' : 'Administrativa' }}</td>
								<td>{{ $n->fiscal == 1 ? 'Fiscal' : 'No fiscal' }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif

		@php
			$payments 		= App\Payment::where('idFolio',$request->folio)->get();
			$total 			= $request->nominasReal->first()->amount;
			$totalPagado 	= 0;
		@endphp

		@if(count($payments) > 0)
		<br><br>
		<center>
			<strong>HISTORIAL DE PAGOS</strong>
		</center>
		<div class="divisor">
			<div class="gray-divisor"></div>
			<div class="orange-divisor"></div>
			<div class="gray-divisor"></div>
		</div>
		<div class="table-responsive">
			<table class="table-no-bordered">
				<thead>
					<th width="20%">Empleado</th>
					<th width="20%">Empresa</th>
					<th width="20%">Cuenta</th>
					<th width="10%">Cantidad</th>
					<th width="10%">Documento</th>
					<th width="20%">Fecha</th>
				</thead>
				<tbody>
					@foreach($payments as $pay)
					<tr>
						<td>{{ $pay->nominaEmployee->employee->first()->name.' '.$pay->nominaEmployee->employee->first()->last_name.' '.$pay->nominaEmployee->employee->first()->scnd_last_name }}</td>
						<td>{{ $pay->enterprise->name }}</td>
						<td>{{ $pay->accounts->account.' - '.$pay->accounts->description }}</td>
						<td>{{ '$'.number_format($pay->amount,2) }}</td>
						<td>
							@foreach($pay->documentsPayments as $doc)
								<a href="{{ asset('docs/payments/'.$doc->path) }}" target="_blank" class="btn btn-red" title="{{ $doc->path }}">
									<span class="icon-pdf"></span>
								</a>
							@endforeach
						</td>
						<td>{{ $pay->paymentDate }}</td>
					</tr>
					@php
						$totalPagado += $pay->amount;
					@endphp
					@endforeach
					<br>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><b>Total pagado:</b> ${{ number_format($totalPagado,2) }}</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><b>Resta:</b> ${{ number_format(($total)-$totalPagado,2) }}</td>
					</tr>
				</tbody>
			</table>
		</div>
		@endif

		<center>
			<p>
				<button class="btn btn-red exit" type="button">Cerrar</button>
			</p>
		</center>
		<br>
	</div>
</div>
