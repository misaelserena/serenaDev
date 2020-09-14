<div class="modal-content">
	<div class="modal-header" style="border:none;display:block">
		<span class="close exit">&times;</span>
	</div>
	<div class="modal-body">
		<center>
			<strong>DETALLES DE EMPLEADO</strong>
		</center>
		<div class="divisor">
			<div class="gray-divisor"></div>
			<div class="orange-divisor"></div>
			<div class="gray-divisor"></div>
		</div>
		<form id="form-employee">
			<input type="hidden" name="idemployee" value="{{ $employee->id }}">
			<input type="hidden" name="idworkingData" value="{{ $employee->workerData->where('visible',1)->first()->id }}">
			<p><br></p>
			<div class="container-blocks" id="container-data">
				<div class="div-form-group">
					<p>
						<label class="label-form">Nombre(s)</label>
						<input placeholder="Ingrese el nombre" type="text" name="name" class="input-text" data-validation="length required" data-validation-length="min2" value="{{ $employee->name }}">
					</p>
					<p>
						<label class="label-form">Apellido Paterno</label>
						<input placeholder="Ingrese el apellido" type="text" name="last_name" class="input-text" data-validation="length required" data-validation-length="min2" value="{{ $employee->last_name }}">
					</p>
					<p>
						<label class="label-form">Apellido Materno (Opcional)</label>
						<input placeholder="Ingrese el apellido" type="text" name="scnd_last_name" class="input-text" value="{{ $employee->scnd_last_name }}">
					</p>
					<p>
						<label class="label-form">CURP</label>
						<input placeholder="Ingrese el CURP" type="text" name="curp" class="input-text" data-validation="custom required" data-validation-regexp="^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$" data-validation-error-msg="Por favor, ingrese un CURP válido" value="{{ $employee->curp }}">
					</p>
					<p>
						<label class="label-form">RFC</label>
						<input placeholder="Ingrese el RFC con homoclave" type="text" name="rfc" class="input-text" data-validation="custom" data-validation-regexp="^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$" data-validation-error-msg="Por favor, ingrese un RFC válido" data-validation-optional="true" value="{{ $employee->rfc }}">
					</p>
					<p>
						<label class="label-form"># IMSS</label>
						<input placeholder="" type="text" name="imss" class="input-text" data-validation="custom" data-validation-regexp="^(\d{10}-\d{1})$" data-validation-error-msg="Por favor, ingrese un # IMSS válido" data-validation-optional="true" value="{{ $employee->imss }}">
					</p>
				</div>
				<div class="div-form-group">
					<p>
						<label class="label-form">Calle</label>
						<input placeholder="Calle" type="text" name="street" class="input-text" data-validation="length required" data-validation-length="max100" value="{{ $employee->street }}">
					</p>
					<p>
						<label class="label-form">Número</label>
						<input type="text" name="number" class="input-text" placeholder="Número" data-validation="required length" data-validation-length="max45" value="{{ $employee->number }}">
					</p>
					<p>
						<label class="label-form">Colonia</label>
						<input type="text" name="colony" class="input-text" placeholder="Colonia" data-validation="required length" data-validation-length="max70" value="{{ $employee->colony }}">
					</p>
					<p>
						<label class="label-form">CP</label>
						<input type="text" name="cp" class="input-text" placeholder="Código postal" data-validation="required length" data-validation-length="max10" value="{{ $employee->cp }}">
					</p>
					<p>
						<label class="label-form">Ciudad</label>
						<input type="text" name="city" class="input-text" placeholder="Ciudad" data-validation="required length" data-validation-length="max70" value="{{ $employee->city }}">
					</p>
					<p>
						<select class="input-text" name="state" multiple data-validation="required">
							@foreach(App\State::orderName()->get() as $e)
								@if($employee->state_id == $e->idstate)
									<option selected="selected" value="{{ $e->idstate }}">{{ $e->description }}</option>
								@else
									<option value="{{ $e->idstate }}">{{ $e->description }}</option>
								@endif
							@endforeach
			 			</select>
					</p>
				</div>
			</div>
			<p><br></p>
			<center>
				<strong>INFORMACIÓN LABORAL</strong>
			</center>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div>
			<center>
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="editworker" name="editworker" value="x">
					<label class="custom-control-label" for="editworker"><b>Habilitar edición</b></label><span class="help-btn" id="help-btn-edit-employee"></span>
				</div>
			</center>
			<div class="info-container">
				<div class="div-form-group">
					<p>
						<select class="input-text disabled" disabled="disabled" name="work_state" multiple data-validation="required">
							@foreach(App\State::orderName()->get() as $e)
								@if ($employee->workerData->where('visible',1)->first()->state == $e->idstate) 
									<option value="{{ $e->idstate }}" selected="selected">{{ $e->description }}</option>
								@else
									<option value="{{ $e->idstate }}">{{ $e->description }}</option>
								@endif
							@endforeach
						</select>
					</p>
					<p>
						<select class="input-text disabled" disabled="disabled" name="work_project" multiple>
							@foreach(App\Project::orderName()->where('status',1)->get() as $project)
								@if ($employee->workerData->where('visible',1)->first()->project == $project->idproyect) 
									<option value="{{ $project->idproyect }}" selected="selected">{{ $project->proyectName }}</option>
								@else
									<option value="{{ $project->idproyect }}">{{ $project->proyectName }}</option>
								@endif
							@endforeach
						</select><br>
					</p>
					<p>
						<select class="input-text js-enterprises disabled" disabled="disabled" name="work_enterprise" multiple data-validation="required">
						@foreach(App\Enterprise::orderName()->where('status','ACTIVE')->get() as $enterprise)
							@if ($employee->workerData->where('visible',1)->first()->enterprise == $enterprise->id) 
								 <option value="{{ $enterprise->id }}" selected="selected">{{ $enterprise->name }}</option>
							@else
								 <option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
							@endif
						@endforeach

			 			</select>
					</p>
					<p>
						<select class="input-text js-accounts disabled" disabled="disabled" multiple name="work_account" data-validation="required">
							@foreach (App\Account::where('idEnterprise',$employee->workerData->where('visible',1)->first()->enterprise)->where(function($q){$q->where('account','LIKE','5102%')->orWhere('account','LIKE','5303%')->orWhere('account','LIKE','5403%');})->where('selectable',1)->get() as $a) 
								@if ($employee->workerData->where('visible',1)->first()->account == $a->idAccAcc) 
									 <option selected="selected" value="{{ $a->idAccAcc }}">{{ $a->account.' - '.$a->description.' ('.$a->content.')' }}</option>
								@else
									 <option value="{{ $a->idAccAcc }}">{{ $a->account.' - '.$a->description.' ('.$a->content.')' }}</option>
								@endif
							@endforeach
			 			</select>
					</p>    
					<p>
						<select class="input-text multichoice disabled" disabled="disabled" name="work_place[]" multiple>
							@foreach(App\Place::orderName()->where('status',1)->get() as $place)
								@php
								$flag = false;
								@endphp
								@foreach ($employee->workerData->where('visible',1)->first()->places as $p) 
									@if ($place->id == $p->id) 
										@php 
											$flag = true;
										@endphp
									@endif
								@endforeach
								@if ($flag) 
									<option value="{{ $place->id }}" selected="selected">{{ $place->place }}</option>
								@else
									<option value="{{ $place->id }}">{{ $place->place }}</option>
								@endif
							@endforeach
				 		</select>
					</p>
					<p>
						<select class="input-text disabled" disabled="disabled" name="work_direction" multiple data-validation="required">
							@foreach(App\Area::orderName()->where('status','ACTIVE')->get() as $area)
								@if ($employee->workerData->where('visible',1)->first()->direction == $area->id) 
									 <option value="{{ $area->id }}" selected="selected">{{ $area->name }}</option>
								@else
									 <option value="{{ $area->id }}">{{ $area->name }}</option>
								@endif
							@endforeach
						</select>	
					</p>
					<p>
						<select class="input-text disabled" disabled="disabled" multiple name="work_department">
							@foreach(App\Departament::orderName()->where('status','ACTIVE')->get() as $area)
								@if ($employee->workerData->where('visible',1)->first()->department == $area->id) 
									 <option value="{{ $area->id }}" selected="selected">{{ $area->name }}</option>
								@else
									 <option value="{{ $area->id }}">{{ $area->name }}</option>
								@endif
							@endforeach
						
						</select><br>
					</p>
					<p>
						<label class="label-form">Puesto</label>
						<input placeholder="Puesto" type="text" name="work_position" class="input-text disabled" disabled="disabled" data-validation="length required" data-validation-length="max100" value="{{ $employee->workerData->where('visible',1)->first()->position }}">
					</p>
					<p>
						<label class="label-form">Fecha de ingreso</label>
						<input placeholder="Fecha de ingreso" type="text" name="work_income_date" class="input-text disabled" disabled="disabled" data-validation="date required" value="{{ $employee->workerData->where('visible',1)->first()->admissionDate }}">
					</p>
					<p>
						<label class="label-form">Fecha de alta IMSS (si aplica) </label>
						<input placeholder="Fecha de alta" type="text" name="work_imss_date" class="input-text disabled" disabled="disabled" data-validation="date" value="{{ $employee->workerData->where('visible',1)->first()->imssDate }}">
					</p>
					<p>
						<label class="label-form">Fecha de baja (si aplica) </label>
						<input placeholder="Fecha de baja" type="text" name="work_down_date" class="input-text disabled" disabled="disabled" data-validation="date" value="{{ $employee->workerData->where('visible',1)->first()->downDate }}">
					</p>
					<p>
						<label class="label-form">Fecha de término de relación laboral (si aplica)</label>
						<input placeholder="Fecha de término de relación laboral" type="text" name="work_ending_date" class="input-text disabled" disabled="disabled" data-validation="date"  value="{{ $employee->workerData->where('visible',1)->first()->endingDate }}">
					</p>
				</div>
				<div class="div-form-group">
					<p>
						<label class="label-form">Reingreso (si aplica)</label>
						<input placeholder="Reingreso" type="text" name="work_reentry_date" class="input-text disabled" disabled="disabled" data-validation="date" value="{{ $employee->workerData->where('visible',1)->first()->reentryDate }}">
					</p>
					<p>
						<label class="label-form">Tipo de trabajador</label>
						<select class="custom-select disabled" disabled="disabled" name="work_type_employee" data-validation="required">
							@foreach(App\CatContractType::orderName()->whereIn('id',['01','02'])->get() as $contract)
								<option value="{{$contract->id}}" @if($employee->workerData->where('visible',1)->first()->workerType==$contract->id) selected @endif>{{$contract->description}}</option>
							@endforeach
						</select>
					</p>
					<p>
						<label class="label-form">Régimen</label>
						<select class="custom-select disabled" disabled="disabled" name="work_regime_employee" data-validation="required">
							@foreach(App\CatRegimeType::orderName()->get() as $regime)
								<option value="{{$regime->id}}" @if($employee->workerData->where('visible',1)->first()->regime_id==$regime->id) selected @endif>{{$regime->description}}</option>
							@endforeach
						</select>
					</p>
					<p>
						<label class="label-form">Estatus</label>
						<select class="custom-select disabled" disabled="disabled" name="work_status_employee" data-validation="required">
								<option value="1" @if ($employee->workerData->where('visible',1)->first()->workerStatus == 1) selected="selected" @endif>Activo</option>
								<option value="2" @if ($employee->workerData->where('visible',1)->first()->workerStatus == 2) selected="selected"  @endif>Baja pacial</option>
								<option value="3" @if ($employee->workerData->where('visible',1)->first()->workerStatus == 3) selected="selected"  @endif>Baja definitiva</option>
								<option value="4" @if ($employee->workerData->where('visible',1)->first()->workerStatus == 4) selected="selected"  @endif>Suspensión</option>
								<option value="5" @if ($employee->workerData->where('visible',1)->first()->workerStatus == 5) selected="selected"  @endif>Boletinado</option>
						</select>
					</p>
					<p>
						<label class="label-form">SDI (si aplica)</label>
						<input placeholder="SDI" type="text" name="work_sdi" class="input-text disabled" disabled="disabled" data-validation="number" data-validation-allowing="float" data-validation-optional="true"  value="{{ $employee->workerData->where('visible',1)->first()->sdi }}">
					</p>
					<p>
						<label class="label-form">Periodicidad</label>
						<select class="custom-select disabled" disabled="disabled" name="work_periodicity" data-validation="required">
							@foreach(App\CatPeriodicity::orderName()->get() as $per)
								@if ($employee->workerData->where('visible',1)->first()->periodicity == $per->c_periodicity) 
									<option selected="selected" value="{{ $per->c_periodicity }}">{{ $per->description }}</option>
								@else
									<option value="{{ $per->c_periodicity }}">{{ $per->description }}</option>
								@endif
							@endforeach
								
						 </select>
					</p>
					<p>
						<label class="label-form">Registro patronal</label>
						<select class="custom-select laboral-data disabled" name="work_employer_register" data-validation="required" @if(isset($employee)) disabled @endif>
							@if(isset($employee) && count($employee->workerData)>0)
								@foreach(App\EmployerRegister::where('enterprise_id',$employee->workerData->where('visible',1)->first()->enterprise)->get() as $er)
									<option value="{{$er->employer_register}}" @if($employee->workerData->where('visible',1)->first()->employer_register == $er->employer_register) selected @endif >{{$er->employer_register}}</option>
								@endforeach
							@endif
						</select>
					</p>
					<p>
						<label class="label-form">Forma de pago</label>
						<select class="custom-select laboral-data disabled" name="work_payment_way" data-validation="required" @if(isset($employee)) disabled @endif>
							@foreach(App\PaymentMethod::orderName()->get() as $pay)
								<option value="{{$pay->idpaymentMethod}}" @if(isset($employee) && count($employee->workerData)>0 && $employee->workerData->where('visible',1)->first()->paymentWay==$pay->idpaymentMethod) selected @endif>{{$pay->method}}</option>
							@endforeach
						</select>
					</p>
					<p>
						<label class="label-form">Sueldo neto</label>
						<input placeholder="Sueldo neto" type="text" name="work_net_income" class="input-text disabled" disabled="disabled" data-validation="number" data-validation-allowing="float" value="{{ $employee->workerData->where('visible',1)->first()->netIncome }}">
					</p>
					<p>
						<label class="label-form">Complemento (si aplica)</label>
						<input placeholder="Complemento" type="text" name="work_complement" class="input-text disabled" disabled="disabled" data-validation="number" data-validation-allowing="float" data-validation-optional="true" value="{{ $employee->workerData->where('visible',1)->first()->complement }}">
					</p>
					<p>
						<label class="label-form">Monto Fonacot (si aplica)</label>
						<input placeholder="Monto Fonacot" type="text" name="work_fonacot" class="input-text disabled" disabled="disabled" data-validation="number" data-validation-allowing="float" data-validation-optional="true" value="{{ $employee->workerData->where('visible',1)->first()->fonacot }}">
					</p>
				</div>
			</div>
			<p><br></p>
			<div class="table-responsive">
				<table class="table" style="min-width: 100%;">
					<thead class="thead-dark">
						<tr>
							<th colspan="2">NEGOCIACIONES DE CAMBIO DE EMPRESA</th>
						</tr>
						<tr>
							<th>Empresa Anterior</th>
							<th>Fecha de Ingreso</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td width="50%">
								<p>
									<select class="input-text" name="work_enterprise_old" multiple data-validation="required" style="width: 90%">
										@foreach(App\Enterprise::orderName()->where('status','ACTIVE')->get() as $enterprise)
											<option value="{{ $enterprise->id }}" @if(isset($employee) && count($employee->workerData->where('visible',1))>0 && $employee->workerData->where('visible',1)->first()->enterpriseOld==$enterprise->id) selected @endif>{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
										@endforeach
									</select>
								</p>
							</td>
							<td width="50%">
								<p>
									<input placeholder="Fecha" type="text" name="work_income_date_old" class="input-text disabled" data-validation="required" data-validation-allowing="range[0;100]" @if(isset($employee) && count($employee->workerData->where('visible',1))>0) value="{{$employee->workerData->where('visible',1)->first()->admissionDateOld}}" @endif @if(isset($employee)) disabled @endif>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
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
								<p>
									<input placeholder="Nómina" type="text" name="work_nomina" class="input-text disabled" disabled="disabled" data-validation="number required" value="{{ $employee->workerData->where('visible',1)->first()->nomina }}">
								</p>
							</td>
							<td>
								<p>
									<input placeholder="Bonos" type="text" name="work_bonus" class="input-text disabled" disabled="disabled" data-validation="number required" value="{{ $employee->workerData->where('visible',1)->first()->bono }}">
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<p><br></p>
			<div class="table-responsive">
				<table class="table" style="min-width: 100%;">
					<thead class="thead-dark">
						<tr>
							<th colspan="2">
								<div class="custom-control custom-switch">
									@if ($employee->workerData->where('visible',1)->first()->infonavitCredit != '') 
										<input type="checkbox" checked="checked" class="custom-control-input disabled" disabled="disabled" id="infonavit" name="infonavit">
										<label class="custom-control-label" for="infonavit">Infonavit</label>
									@else
										<input type="checkbox" class="custom-control-input disabled" disabled="disabled" id="infonavit" name="infonavit">
										<label class="custom-control-label" for="infonavit">Infonavit</label>
									@endif
								</div>
							</th>
						</tr>
					</thead>
					<tbody @if ($employee->workerData->where('visible',1)->first()->infonavitCredit == '')  style="display: none" @endif>
			 			<tr>
							<td>Número de crédito</td>
							<td>
								<p>
									<input type="text" class="input-text disabled" disabled="disabled" name="work_infonavit_credit" data-validation="required" value="{{ $employee->workerData->where('visible',1)->first()->infonavitCredit }}">
								</p>
							</td>
						</tr>
						<tr>
							<td>Descuento</td>
							<td>
								<p>
									<input type="text" class="input-text disabled" disabled="disabled" name="work_infonavit_discount" data-validation="number required" data-validation-allowing="float" value="{{ $employee->workerData->where('visible',1)->first()->infonavitDiscount }}">
								</p>
							</td>
						</tr>
						<tr>
							<td>Tipo de descuento</td>
							<td>
								<p>
									<select class="custom-select disabled" disabled="disabled" name="work_infonavit_discount_type" data-validation="required">
											<option value="1" @if ($employee->workerData->where('visible',1)->first()->infonavitDiscountType == 1)  selected="selected" @endif>VSM (Veces Salario Mínimo)</option>
											<option value="2" @if ($employee->workerData->where('visible',1)->first()->infonavitDiscountType == 2) selected="selected" @endif>Cuota fija</option>
											<option value="3" @if ($employee->workerData->where('visible',1)->first()->infonavitDiscountType == 3) selected="selected" @endif>Porcentaje</option>
						 			</select>
								</p>
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
						<tr>
							<td>
								<p>
									<input type="text" class="input-text alias" placeholder="Alias">
								</p>
							</td>
							<td>
								<p>
									<select class="input-text bank" multiple>
										@foreach(App\CatBank::orderName()->get() as $b)
											<option value="{{ $b->c_bank }}">{{ $b->description }}</option>
										@endforeach
									</select>
								</p>
							</td>
							<td>
								<p>
									<input type="text" class="input-text clabe" placeholder="CLABE" data-validation="clabe">
								</p>
							</td>
							<td>
								<p>
									<input type="text" class="input-text account" placeholder="Cuenta bancaria" data-validation="cuenta">
								</p>
							</td>
							<td>
								<p>
									<input type="text" class="input-text card" placeholder="Tarjeta" data-validation="tarjeta">
								</p>
							</td>
							<td>
								<p>
									<input type="text" class="input-text branch_office" placeholder="Sucursal">
								</p>
							</td>
							<td>
								<button class="btn btn-green" type="button" id="add-bank">+</button>
							</td>
						</tr>
					</thead>
					<tbody>
						@foreach ($employee->bankData->where('visible',1) as $b) 
							<tr>
								<td><input type="hidden" class="idbank" value="{{ $b->id }}">{{ $b->alias }}</td>
								<td>{{ $b->bank->description }}</td>
								<td>{{ $b->clabe }}</td>
								<td>{{ $b->account }}</td>
								<td>{{ $b->cardNumber }}</td>
								<td>{{ $b->branch }}</td>
								<td><button class="btn btn-red delete-bank" type="button"><span class="icon-x"></span></button></td>
							</tr>
						@endforeach
		 			</tbody>
				</table>
			</div>
			<div id="div-delete"></div>
			<center><button type="button" class="btn btn-green update-employee" title="Actualizar"><span class="icon-checkmark"></span> Actualizar</button><button type="button" class="btn btn-red exit" title="Cerrar"><span class="icon-x"></span> Cerrar</button></center><br>
		</form>
	</div>
</div>

<script src="{{ asset('js/jquery.numeric.js') }}"></script>

<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('input[name="cp"]').numeric({ negative:false});
		$('input[name="work_sdi"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		$('input[name="work_net_income"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		$('input[name="work_complement"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		$('input[name="work_fonacot"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		$('input[name="work_nomina"]').numeric({negative:false});
		$('input[name="work_bonus"]').numeric({negative:false});
		$('input[name="work_infonavit_credit"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		$('input[name="work_infonavit_discount"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		$('.clabe,.account,.card').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		$('input[name="work_alimony_discount"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		
	});
</script>