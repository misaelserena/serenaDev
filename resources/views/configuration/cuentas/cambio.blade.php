@extends('layouts.child_module')
@section('data')
	{!! Form::open(['route' => ['account.update',$account->idAccAcc],'method' => 'PUT', 'id' => 'container-alta']) !!}

<div class="container-blocks" id="container-data">
			<div class="search-table-center">
				<div class="search-table-center-row">
					<p>
						<select class="js-enterprises removeselect" name="enterprise_id" multiple="multiple" id="multiple-enterprises select2-selection--multiple" style="width: 98%; max-width: 150px;" data-validation="required"> 
							@foreach(App\Enterprise::orderName()->get() as $enterprise) 
							<option value="@if($account->idEnterprise == $enterprise->id) 
								{{ $enterprise->id }}" selected="selected">{{ $enterprise->name }}</option> 
								@else
								{{ $enterprise->id }}">{{ $enterprise->name }}</option> 
								@endif
							@endforeach 
						</select><br>
					</p>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form" >Número de cuenta</label>
					</div>
					<div class="right">
						<p>
							<input type="text" class="input-text-large account" name="account" placeholder="Número de cuenta" value="{{ $account->account }}" data-validation="required server" data-validation-url="{{ url('configuration/account/validate') }}" data-validation-req-params="{{ json_encode(array('oldNumber'=>$account->idAccAcc,'enterprise_id'=>$account->idEnterprise)) }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Cuenta</label>
					</div>
					<div class="right">
						<p>
							<textarea class="input-text-large description" name="description" id="description" placeholder="Nombre de la cuenta" rows="3" data-validation="required">{{ $account->description }}</textarea>
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Tipo de gasto</label>
					</div>
					<div class="right">
						<p>
							<textarea class="input-text-large content" name="content" id="content" placeholder="Nombre de la cuenta" rows="3">{{ $account->content }}</textarea>
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<br><label class="label-form">Saldo</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="balance" id="balance" placeholder="$0.00" class="input-text-large" value="{{ $account->balance }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<p>
						<label class="label-form">Visible</label><br><br>
						<input type="radio" name="selectable" id="novisible" value="0" @if($account->selectable == 0) checked="true" @endif>
						<label for="novisible">No</label> 
						<input type="radio" name="selectable" id="visible" value="1" @if($account->selectable == 1) checked="true" @endif>
						<label for="visible">Sí</label>
						<br><br>
					</p>
				</div>
		</div>
	</div>
	<div class="form-container">
		<input class="btn btn-red" type="submit" name="enviar" value="GUARDAR CAMBIOS">
		<a 
			@if(isset($option_id)) 
				href="{{ url(App\Module::find($option_id)->url) }}" 
			@else 
				href="{{ url(App\Module::find($child_id)->url) }}" 
			@endif 
		><button class="btn" type="button">REGRESAR</button></a>
	</div>
		
	{!! Form::close() !!}
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript">
	$.ajaxSetup(
	{
		headers:
		{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.validate(
	{
		modules: 'security',
		form: '#container-alta',
	});
	$(document).ready(function() {

		$('input[name="balance"]').numeric({ altDecimal: ".", decimalPlaces: 2, negative:false});
		$('.account').numeric(false);
		$('.js-enterprises').select2({
			placeholder: 'Seleccione la Empresa',
			language: "es",
			maximumSelectionLength: 1
		});

		$(document).on('change','.js-enterprises',function()
		{
			enterpriseid = $('select[name="enterprise_id"] option:selected').val();
			if(enterpriseid===undefined)
			{
				enterpriseid=0;
			}
			account = $('input[name="account"]').attr('data-validation-req-params');
			oldAccount = JSON.parse(account);
			$('input[name="account"]').attr('data-validation-req-params','{"enterprise_id":'+enterpriseid+',"oldNumber":'+oldAccount.oldNumber+'}').val('');
		})
	});
</script>
@endsection