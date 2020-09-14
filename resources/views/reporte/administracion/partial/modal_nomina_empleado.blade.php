@if($fiscal == 1)
	@switch($typeNomina)
		@case('001')
			<div class="modal-content">
				<div class="modal-header" style="border:none;display:block">
					<span class="close exit">&times;</span>
				</div>
				<div class="modal-body">
					<center>
						<strong>DATOS</strong>
					</center>
					<div class="divisor">
						<div class="gray-divisor"></div>
						<div class="orange-divisor"></div>
						<div class="gray-divisor"></div>
					</div><br>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										DATOS DE PAGO
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
									<td width="50%">Forma de pago</td>
									<td width="50%">
										{{ $nominaemployee->salary->first()->paymentMethod->method }}
									</td>
								</tr>
								@if($nominaemployee->salary->first()->idpaymentMethod == 1)							
									<tr>
										<td>Alias</td>
										<td>
											{{ $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->alias : '------' }}
										</td>
									</tr>
									<tr>
										<td>Banco</td>
										<td>
											{{ $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->bank->description : '------' }}
										</td>
									</tr>
									<tr>
										<td>Cuenta</td>
										<td>
											{{ $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->account : '------' }}
										</td>
									</tr>
									<tr>
										<td>CLABE</td>
										<td>
											{{ $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->clabe : '------' }}
										</td>
									</tr>
									<tr>
										<td>Tarjeta</td>
										<td>
											{{ $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->salary->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->cardNumber : '------' }}
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										INFORMACIÓN
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
									<td width="50%">S.D.</td>
									<td width="50%">
										{{ $nominaemployee->salary()->exists() ? $nominaemployee->salary->first()->sd : 0 }}
									</td>
								</tr>
								<tr>
									<td>S.D.I.</td>
									<td>
										{{ $nominaemployee->salary()->exists() ? $nominaemployee->salary->first()->sdi : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días trabajados</td>
									<td>
										{{ $nominaemployee->salary()->exists() ? $nominaemployee->salary->first()->workedDays : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días para IMSS</td>
									<td>
										{{ $nominaemployee->salary()->exists() ? $nominaemployee->salary->first()->daysForImss : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="2">
										PERCEPCIONES
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">Sueldo</td>
									<td width="50%">
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->salary != '' ? $nominaemployee->salary->first()->salary : 0 }}
									</td>
								</tr>
								<tr>
									<td>Préstamo</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->loan_perception != '' ? $nominaemployee->salary->first()->loan_perception : 0 }}
									</td>
								</tr>
								<tr>
									<td>Puntualidad</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->puntuality != '' ? $nominaemployee->salary->first()->puntuality : 0 }}
									</td>
								</tr>
								<tr>
									<td>Asistencia</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->assistance != '' ? $nominaemployee->salary->first()->assistance : 0 }}
									</td>
								</tr>
								<tr>
									<td>Subsidio</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->subsidy != '' ? $nominaemployee->salary->first()->subsidy : 0 }}
									</td>
								</tr>
								<tr>
									<td>Subsidio Causado</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->subsidyCaused != '' ? $nominaemployee->salary->first()->subsidyCaused : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total percepciones</b></td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->totalPerceptions != '' ? $nominaemployee->salary->first()->totalPerceptions : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										RETENCIONES
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">IMSS</td>
									<td width="50%">
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->imss != '' ? $nominaemployee->salary->first()->imss : 0 }}
									</td>
								</tr>
								<tr>
									<td>Infonavit</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->infonavit != '' ? $nominaemployee->salary->first()->infonavit : 0 }}
									</td>
								</tr>
								<tr>
									<td>Fonacot</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->fonacot != '' ? $nominaemployee->salary->first()->fonacot : 0 }}
									</td>
								</tr>
								<tr>	
									<td>Préstamo</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->loan_retention != '' ? $nominaemployee->salary->first()->loan_retention : 0 }}
									</td>
								</tr>
								<tr>
									<td>Retención de isr</td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->isrRetentions != '' ? $nominaemployee->salary->first()->isrRetentions : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total retenciones</b></td>
									<td>
										{{ $nominaemployee->salary()->exists() && $nominaemployee->salary->first()->totalRetentions != '' ? $nominaemployee->salary->first()->totalRetentions : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<center>
						<div style="padding: 15px; border-radius: 15px; border: 2px solid #fca700; width: 20%">
							<b>Sueldo neto:</b><br>
							{{ $nominaemployee->salary()->exists() ? round($nominaemployee->salary->first()->netIncome,2) : 0 }}
						</div>
					</center>
					<br>
					<center>
						<button type="button" class="btn btn-red exit" title="Cerrar">
							<span class="icon-x"></span> Cerrar
						</button>
					</center><br>
				</div>
			</div>
		@break
		@case('002')
			<div class="modal-content">
				<div class="modal-header" style="border:none;display:block">
					<span class="close exit">&times;</span>
				</div>
				<div class="modal-body">
					<center>
						<strong>DATOS</strong>
					</center>
					<div class="divisor">
						<div class="gray-divisor"></div>
						<div class="orange-divisor"></div>
						<div class="gray-divisor"></div>
					</div><br>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										DATOS DE PAGO
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
									<td width="50%">Forma de pago</td>
									<td width="50%">
										{{ $nominaemployee->bonus->first()->paymentMethod->method }}
									</td>
								</tr>
								@if($nominaemployee->bonus->first()->idpaymentMethod == 1)							
									<tr>
										<td>Alias</td>
										<td>
											{{ $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->alias : '---' }}
										</td>
									</tr>
									<tr>
										<td>Banco</td>
										<td>
											{{ $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->bank->description : '---' }}
										</td>
									</tr>
									<tr>
										<td>Cuenta</td>
										<td>
											{{ $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->account : '---' }}
										</td>
									</tr>
									<tr>
										<td>CLABE</td>
										<td>
											{{ $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->clabe : '---' }}
										</td>
									</tr>
									<tr>
										<td>Tarjeta</td>
										<td>
											{{ $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->bonus->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->cardNumber : '---' }}
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										INFORMACIÓN
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
					 				<td width="50%">S.D.</td>
					 				<td width="50%">
					 					{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->sd != '' ? $nominaemployee->bonus->first()->sd : 0 }}
					 				</td>
					 			</tr>
								<tr>
									<td>S.D.I.</td>
									<td>
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->sdi != '' ? $nominaemployee->bonus->first()->sdi : 0 }}
									</td>
								</tr>
								<tr>
									<td>Fecha de ingreso</td>
									<td>
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->dateOfAdmission != '' ? $nominaemployee->bonus->first()->dateOfAdmission : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días para aguinaldos</td>
									<td>
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->daysForBonuses != '' ? $nominaemployee->bonus->first()->daysForBonuses : 0 }}
									</td>
								</tr>
								<tr>
									<td>Parte proporcional para aguinaldo</td>
									<td>
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->proportionalPartForChristmasBonus != '' ? $nominaemployee->bonus->first()->proportionalPartForChristmasBonus : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										PERCEPCIONES
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">Aguinaldo exento</td>
									<td width="50%">
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->exemptBonus!='' ? $nominaemployee->bonus->first()->exemptBonus : 0 }}
									</td>
								</tr>
								<tr>
									<td>Aguinaldo gravable</td>
									<td>
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->taxableBonus!='' ? $nominaemployee->bonus->first()->taxableBonus : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total</b></td>
									<td>
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->totalPerceptions!='' ? $nominaemployee->bonus->first()->totalPerceptions : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										IMPUESTOS
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">ISR</td>
									<td width="50%">
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->isr != '' ? $nominaemployee->bonus->first()->isr : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total</b></td>
									<td>
										{{ $nominaemployee->bonus()->exists() && $nominaemployee->bonus->first()->totalTaxes != '' ? $nominaemployee->bonus->first()->totalTaxes : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<center>
						<div style="padding: 15px; border-radius: 15px; border: 2px solid #fca700; width: 20%">
							<b>Sueldo neto:</b><br>
							{{ $nominaemployee->bonus()->exists() ? round($nominaemployee->bonus->first()->netIncome,2) : 0 }}
						</div>
					</center>
					<br>
					<center>						
						<button type="button" class="btn btn-red exit" title="Cerrar">
							<span class="icon-x"></span> Cerrar
						</button>
					</center><br>
				</div>
			</div>
		@break
		@case('003')
		@case('004')
			<div class="modal-content">
				<div class="modal-header" style="border:none;display:block">
					<span class="close exit">&times;</span>
				</div>
				<div class="modal-body">
					<center>
						<strong>DATOS</strong>
					</center>
					<div class="divisor">
						<div class="gray-divisor"></div>
						<div class="orange-divisor"></div>
						<div class="gray-divisor"></div>
					</div><br>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										DATOS DE PAGO
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
									<td width="50%">Forma de pago</td>
									<td width="50%">
										{{ $nominaemployee->liquidation->first()->paymentMethod->method }}
									</td>
								</tr>
								@if($nominaemployee->liquidation->first()->idpaymentMethod == 1)							
									<tr>
										<td>Alias</td>
										<td>
											{{ $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->alias : '---' }}
										</td>
									</tr>
									<tr>
										<td>Banco</td>
										<td>
											{{ $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->bank->description : '---' }}
										</td>
									</tr>
									<tr>
										<td>Cuenta</td>
										<td>
											{{ $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->account : '---' }}
										</td>
									</tr>
									<tr>
										<td>CLABE</td>
										<td>
											{{ $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->clabe : '---' }}
										</td>
									</tr>
									<tr>
										<td>Tarjeta</td>
										<td>
											{{ $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->liquidation->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->cardNumber : '---' }}
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										INFORMACIÓN
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
					 				<td width="50%">S.D.</td>
					 				<td width="50%">
					 					{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->sd != '' ? $nominaemployee->liquidation->first()->sd : 0 }}
					 				</td>
					 			</tr>
								<tr>
									<td>S.D.I.</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->sdi != '' ? $nominaemployee->liquidation->first()->sdi : 0 }}
									</td>
								</tr>
								<tr>
									<td>Fecha de ingreso</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->admissionDate != '' ? $nominaemployee->liquidation->first()->admissionDate : '' }}
									</td>
								</tr>
								<tr>
									<td>Fecha de baja</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->downDate != '' ? $nominaemployee->liquidation->first()->downDate : '' }}
									</td>
								</tr>
								<tr>
									<td>Años completos</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->fullYears != '' ? $nominaemployee->liquidation->first()->fullYears : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días trabajados</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->workedDays != '' ? $nominaemployee->liquidation->first()->workedDays : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días para vacaciones</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->holidayDays != '' ? $nominaemployee->liquidation->first()->holidayDays : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días de aguinaldo</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->bonusDays != '' ? $nominaemployee->liquidation->first()->bonusDays : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										PERCEPCIONES
									</th>
								</tr>
							</thead>
							<tbody>
								@if($typeNomina == '004')
									<tr>
										<td width="50%">Sueldo por liquidación</td>
										<td width="50%">
											<p>
												{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->liquidationSalary != '' ? $nominaemployee->liquidation->first()->liquidationSalary : 0 }}
											</p>
										</td>
									</tr>
									<tr>
										<td>20 días x año de servicios</td>
										<td>
											<p>
												{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->twentyDaysPerYearOfServices != '' ? $nominaemployee->liquidation->first()->twentyDaysPerYearOfServices : 0 }}
											</p>
										</td>
									</tr>
								@endif
								<tr>
									<td width="50%">Prima de antigüedad</td>
									<td width="50%">
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->seniorityPremium != '' ? $nominaemployee->liquidation->first()->seniorityPremium : 0 }}
									</td>
								</tr>
								<tr>
									<td>Vacaciones</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->holidays != '' ? $nominaemployee->liquidation->first()->holidays : 0 }}
									</td>
								</tr>
								<tr>
									<td>Indemnización exenta</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->exemptCompensation != '' ? $nominaemployee->liquidation->first()->exemptCompensation : 0 }}
									</td>
								</tr>
								<tr>
									<td>Indemnización gravada</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->taxedCompensation != '' ? $nominaemployee->liquidation->first()->taxedCompensation : 0 }}
									</td>
								</tr>
								<tr>
									<td>Aguinaldo exento</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->exemptBonus != '' ? $nominaemployee->liquidation->first()->exemptBonus : 0 }}
									</td>
								</tr>
								<tr>
									<td>Aguinaldo gravable</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->taxableBonus != '' ? $nominaemployee->liquidation->first()->taxableBonus : 0 }}
									</td>
								</tr>
								<tr>
									<td>Prima vacacional exenta</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->holidayPremiumExempt != '' ? $nominaemployee->liquidation->first()->holidayPremiumExempt : 0 }}
									</td>
								</tr>
								<tr>
									<td>Prima vacacional gravada</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->holidayPremiumTaxed != '' ? $nominaemployee->liquidation->first()->holidayPremiumTaxed : 0 }}
									</td>
								</tr>
								<tr>
									<td>Otras percepciones</td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->otherPerception != '' ? $nominaemployee->liquidation->first()->otherPerception : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total</b></td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->totalPerceptions != '' ? $nominaemployee->liquidation->first()->totalPerceptions : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										IMPUESTOS
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">ISR</td>
									<td width="50%">
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->isr != '' ? $nominaemployee->liquidation->first()->isr : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total</b></td>
									<td>
										{{ $nominaemployee->liquidation()->exists() && $nominaemployee->liquidation->first()->totalRetentions != '' ? $nominaemployee->liquidation->first()->totalRetentions : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<center>
						<div style="padding: 15px; border-radius: 15px; border: 2px solid #fca700; width: 20%">
							<b>Sueldo neto:</b><br>
							{{ $nominaemployee->liquidation()->exists() ? round($nominaemployee->liquidation->first()->netIncome,2) : 0 }}
						</div>
					</center><br>
					<center>
						<button type="button" class="btn btn-red exit" title="Cerrar">
							<span class="icon-x"></span> Cerrar
						</button>
					</center><br>
				</div>
			</div>
		@break
		@case('005')
			<div class="modal-content">
				<div class="modal-header" style="border:none;display:block">
					<span class="close exit">&times;</span>
				</div>
				<div class="modal-body">
					<center>
						<strong>DATOS</strong>
					</center>
					<div class="divisor">
						<div class="gray-divisor"></div>
						<div class="orange-divisor"></div>
						<div class="gray-divisor"></div>
					</div><br>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										DATOS DE PAGO
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
									<td width="50%">Forma de pago</td>
									<td width="50%">
										{{ $nominaemployee->vacationPremium->first()->paymentMethod->method }}
									</td>
								</tr>
								@if($nominaemployee->vacationPremium->first()->idpaymentMethod == 1)							
									<tr>
										<td>Alias</td>
										<td>
											{{ $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->alias : '---' }}
										</td>
									</tr>
									<tr>
										<td>Banco</td>
										<td>
											{{ $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->bank->description : '---' }}
										</td>
									</tr>
									<tr>
										<td>Cuenta</td>
										<td>
											{{ $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->account : '---' }}
										</td>
									</tr>
									<tr>
										<td>CLABE</td>
										<td>
											{{ $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->clabe : '---' }}
										</td>
									</tr>
									<tr>
										<td>Tarjeta</td>
										<td>
											{{ $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->vacationPremium->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->cardNumber : '---' }}
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										INFORMACIÓN
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
					 				<td width="50%">S.D.</td>
					 				<td width="50%">
					 					{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->sd != '' ? $nominaemployee->vacationPremium->first()->sd : 0 }}
					 				</td>
					 			</tr>
								<tr>
									<td>S.D.I.</td>
									<td>
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->sdi != '' ? $nominaemployee->vacationPremium->first()->sdi : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días trabajados</td>
									<td>
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->workedDays != '' ? $nominaemployee->vacationPremium->first()->workedDays : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días para vacaciones</td>
									<td>
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->holidaysDays != '' ? $nominaemployee->vacationPremium->first()->holidaysDays : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										PERCEPCIONES
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">Vacaciones</td>
									<td width="50%">
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->holidays != '' ? $nominaemployee->vacationPremium->first()->holidays : 0 }}
									</td>
								</tr>
								<tr>
									<td>Prima vacacional exenta</td>
									<td>
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->exemptHolidayPremium != '' ? $nominaemployee->vacationPremium->first()->exemptHolidayPremium : 0 }}
									</td>
								</tr>
								<tr>
									<td>Prima vacacional gravada</td>
									<td>
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->holidayPremiumTaxed != '' ? $nominaemployee->vacationPremium->first()->holidayPremiumTaxed : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total</b></td>
									<td>
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->totalPerceptions != '' ? $nominaemployee->vacationPremium->first()->totalPerceptions : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										IMPUESTOS
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">ISR</td>
									<td width="50%">
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->isr != '' ? $nominaemployee->vacationPremium->first()->isr : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total</b> </td>
									<td>
										{{ $nominaemployee->vacationPremium()->exists() && $nominaemployee->vacationPremium->first()->totalTaxes != '' ? $nominaemployee->vacationPremium->first()->totalTaxes : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<center>
						<div style="padding: 15px; border-radius: 15px; border: 2px solid #fca700; width: 20%">
							<b>Sueldo neto:</b><br>
							{{ $nominaemployee->vacationPremium()->exists() ? round($nominaemployee->vacationPremium->first()->netIncome,2) : 0 }}
						</div>
					</center><br>
					<center>
						<button type="button" class="btn btn-red exit" title="Cerrar">
							<span class="icon-x"></span> Cerrar
						</button>
					</center><br>
				</div>
			</div>
		@break
		@case('006')
			<div class="modal-content">
				<div class="modal-header" style="border:none;display:block">
					<span class="close exit">&times;</span>
				</div>
				<div class="modal-body">
					<center>
						<strong>DATOS</strong>
					</center>
					<div class="divisor">
						<div class="gray-divisor"></div>
						<div class="orange-divisor"></div>
						<div class="gray-divisor"></div>
					</div><br>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										DATOS DE PAGO
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
									<td width="50%">Forma de pago</td>
									<td width="50%">
										{{ $nominaemployee->profitSharing->first()->paymentMethod->method }}
									</td>
								</tr>
								@if($nominaemployee->profitSharing->first()->idpaymentMethod == 1)							
									<tr>
										<td>Alias</td>
										<td>
											{{ $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->alias : '---' }}
										</td>
									</tr>
									<tr>
										<td>Banco</td>
										<td>
											{{ $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->bank->description : '---' }}
										</td>
									</tr>
									<tr>
										<td>Cuenta</td>
										<td>
											{{ $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->account : '---' }}
										</td>
									</tr>
									<tr>
										<td>CLABE</td>
										<td>
											{{ $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->clabe : '---' }}
										</td>
									</tr>
									<tr>
										<td>Tarjeta</td>
										<td>
											{{ $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts()->exists() ? $nominaemployee->profitSharing->first()->nominaEmployeeAccounts->first()->employeeAccounts->first()->cardNumber : '---' }}
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										INFORMACIÓN
									</th>
								</tr>
							</thead>
							<tbody>
					 			<tr>
					 				<td width="50%">S.D.</td>
					 				<td width="50%">
					 					{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->sd != '' ? $nominaemployee->profitSharing->first()->sd : 0 }}
					 				</td>
					 			</tr>
								<tr>
									<td>S.D.I.</td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->sdi != '' ? $nominaemployee->profitSharing->first()->sdi : 0 }}
									</td>
								</tr>
								<tr>
									<td>Días trabajados</td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->workedDays != '' ? $nominaemployee->profitSharing->first()->workedDays : 0 }}
									</td>
								</tr>
								<tr>
									<td>Sueldo total</td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->totalSalary != '' ? $nominaemployee->profitSharing->first()->totalSalary : 0 }}
									</td>
								</tr>
								<tr>
									<td>PTU por días</td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->ptuForDays != '' ? $nominaemployee->profitSharing->first()->ptuForDays : 0 }}
									</td>
								</tr>
								<tr>
									<td>PTU por sueldo</td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->ptuForSalary != '' ? $nominaemployee->profitSharing->first()->ptuForSalary : 0 }}
									</td>
								</tr>
								<tr>
									<td>PTU total</td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->totalPtu != '' ? $nominaemployee->profitSharing->first()->totalPtu : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										PERCEPCIONES
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">PTU exenta</td>
									<td width="50%">
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->exemptPtu != '' ? $nominaemployee->profitSharing->first()->exemptPtu : 0 }}
									</td>
								</tr>
								<tr>
									<td>PTU gravada</td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->taxedPtu != '' ? $nominaemployee->profitSharing->first()->taxedPtu : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total percepciones</b></td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->totalPerceptions != '' ? $nominaemployee->profitSharing->first()->totalPerceptions : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th colspan="4">
										IMPUESTOS
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%">Retenciones de isr</td>
									<td width="50%">
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->isrRetentions != '' ? $nominaemployee->profitSharing->first()->isrRetentions : 0 }}
									</td>
								</tr>
								<tr>
									<td><b>Total retenciones</b></td>
									<td>
										{{ $nominaemployee->profitSharing()->exists() && $nominaemployee->profitSharing->first()->totalRetentions != '' ? $nominaemployee->profitSharing->first()->totalRetentions : 0 }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<center>
						<div style="padding: 15px; border-radius: 15px; border: 2px solid #fca700; width: 20%">
							<b>Sueldo neto:</b><br>
							{{ $nominaemployee->profitSharing()->exists() ? round($nominaemployee->profitSharing->first()->netIncome,2) : 0 }}
						</div>
					</center><br>
					<center>
						<button type="button" class="btn btn-red exit" title="Cerrar">
							<span class="icon-x"></span> Cerrar
						</button>
					</center><br>
				</div>
			</div>
		@break
	@endswitch
@else
	<div class="modal-content">
		<div class="modal-header" style="border:none;display:block">
			<span class="close exit">&times;</span>
		</div>
		<div class="modal-body">
			<center>
				<strong>DATOS</strong>
			</center>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div><br>
			<div class="table-responsive">
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th colspan="4">
								DATOS DE PAGO
							</th>
						</tr>
					</thead>
					<tbody>
			 			<tr>
							<td width="50%">Forma de pago</td>
							<td width="50%">
								{{ $nominaemployee->nominasEmployeeNF->first()->paymentMethod->method }}
							</td>
						</tr>
						@if($nominaemployee->nominasEmployeeNF->first()->idpaymentMethod == 1)							
							<tr>
								<td>Alias</td>
								<td>
									{{ $nominaemployee->nominasEmployeeNF->first()->employeeAccounts()->exists() ? $nominaemployee->nominasEmployeeNF->first()->employeeAccounts->first()->alias : '---' }}
								</td>
							</tr>
							<tr>
								<td>Banco</td>
								<td>
									{{ $nominaemployee->nominasEmployeeNF->first()->employeeAccounts()->exists() ? $nominaemployee->nominasEmployeeNF->first()->employeeAccounts->first()->bank->description : '---' }}
								</td>
							</tr>
							<tr>
								<td>Cuenta</td>
								<td>
									{{ $nominaemployee->nominasEmployeeNF->first()->employeeAccounts()->exists() ? $nominaemployee->nominasEmployeeNF->first()->employeeAccounts->first()->account : '---' }}
								</td>
							</tr>
							<tr>
								<td>CLABE</td>
								<td>
									{{ $nominaemployee->nominasEmployeeNF->first()->employeeAccounts()->exists() ? $nominaemployee->nominasEmployeeNF->first()->employeeAccounts->first()->clabe : '---' }}
								</td>
							</tr>
							<tr>
								<td>Tarjeta</td>
								<td>
									{{ $nominaemployee->nominasEmployeeNF->first()->employeeAccounts()->exists() ? $nominaemployee->nominasEmployeeNF->first()->employeeAccounts->first()->cardNumber : '---' }}
								</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			<div class="table-responsive">
				<table class="table" style="min-width: 100%;">
					<thead class="thead-dark">
						<tr>
							<th colspan="2">
								DATOS DE COMPLEMENTO
							</th>
						</tr>
					</thead>
					<tbody>
			 			<tr>
							<td>Referencia</td>
							<td>
								{{ $nominaemployee->nominasEmployeeNF()->exists() ? $nominaemployee->nominasEmployeeNF->first()->reference : null }}
								</p>
							</td>
						</tr>
						<tr>
							<td>Razón de pago</td>
							<td>
								{{ $nominaemployee->nominasEmployeeNF()->exists() ? $nominaemployee->nominasEmployeeNF->first()->reasonAmount : null }}
							</td>
						</tr>
						<tr>
							<td>Complemento + Extras - Descuentos</td>
							<td>
								{{ $nominaemployee->nominasEmployeeNF()->exists() ? $nominaemployee->nominasEmployeeNF->first()->amount : null }}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="table-responsive">
				<table class="table" style="min-width: 100%;">
					<thead class="thead-dark">
						<tr>
							<th colspan="5">
								EXTRAS
							</th>
						</tr>
					</thead>
					<tbody id="extras">
						@if($nominaemployee->nominasEmployeeNF()->exists() && $nominaemployee->nominasEmployeeNF->first()->extras()->exists())
							@foreach($nominaemployee->nominasEmployeeNF->first()->extras as $extra)
								<tr>
									<td colspan="2">
										{{ $extra->amount }}
									</td>
									<td colspan="2">
										{{ $extra->reason }}
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
			<div class="table-responsive">
				<table class="table" style="min-width: 100%;">
					<thead class="thead-dark">
						<tr>
							<th colspan="5">
								DESCUENTOS (OPCIONAL)
							</th>
						</tr>
					</thead>
					<tbody id="discounts">
						@if($nominaemployee->nominasEmployeeNF()->exists() && $nominaemployee->nominasEmployeeNF->first()->discounts()->exists())
							@foreach($nominaemployee->nominasEmployeeNF->first()->discounts as $discount)
								<tr>
									<td colspan="2">
										{{ $discount->amount }}
									</td>
									<td colspan="2">
										{{ $discount->reason }}
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
			
			<center>
				<button type="button" class="btn btn-red exit" title="Cerrar">
					<span class="icon-x"></span> Cerrar
				</button>
			</center><br>
		</div>
	</div>
@endif