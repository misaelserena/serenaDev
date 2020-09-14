@extends('layouts.child_module')
@section('css')
	<style type="text/css">
		.table .thead-dark th
		{
			padding		: 10px !important;
		}
		.container 
		{
			display				: block;
			position			: relative;
			padding-left		: 35px;
			margin-bottom		: 12px;
			cursor				: pointer;
			font-size			: 15px;
			-webkit-user-select	: none;
			-moz-user-select	: none;
			-ms-user-select		: none;
			user-select			: none;
		}

		.container input 
		{
			opacity	: 0;
			cursor	: pointer;
			height	: 0;
			width	: 0;
		}

		.checkmark 
		{
			position			: absolute;
			top					: 0;
			left				: 0;
			height				: 25px;
			width				: 25px;
			background-color	: #eee;
		}

		.container:hover input ~ .checkmark 
		{
			background-color	: #ccc;
		}

		.container input:checked ~ .checkmark 
		{
			background-color	: #343a40;
		}

		.checkmark:after 
		{
			content		: "";
			position	: absolute;
			display		: none;
		}

		.container input:checked ~ .checkmark:after 
		{
			display	: block;
		}

		.container .checkmark:after 
		{
			left				: 9px;
			top					: 6px;
			width				: 5px;
			height				: 10px;
			border				: solid white;
			border-width		: 0 3px 3px 0;
			-webkit-transform	: rotate(45deg);
			-ms-transform		: rotate(45deg);
			transform			: rotate(45deg);
		}
	</style>
@endsection
@section('data')
	@if(isset($group))
		{!! Form::open(['route'	=> ['account-concentrated.update',$group->id], 'method' => 'PUT', 'id' => 'container-alta']) !!}
	@else
		{!! Form::open(['route'	=> 'account-concentrated.store', 'method' => 'POST', 'id' => 'container-alta']) !!}
	@endif
		Para agregar una nueva agrupación es necesario colocar los siguientes campos:
		<br><br>
		<div class="form-row px-3">
			<div class="form-group col-md-6 mb-4">
				<label for="name"><b>Nombre de Agrupación</b></label>
				<input type="text" class="form-control name" name="name" id="name" data-validation="required" placeholder="Escribe aquí" @if(isset($group)) value="{{ $group->name }}" @endif>
			</div>
		</div>
		<div class="form-row px-3">	
			<div class="form-group col-md-6 mb-4">
				<label for="idEnterprise"><b>Empresa</b></label>
				<select class="form-control" name="idEnterprise" id="idEnterprise" multiple data-validation="required">
					@foreach(App\Enterprise::orderName()->get() as $enterprise)
						<option value="{{ $enterprise->id }}" @if(isset($group) && $group->idEnterprise == $enterprise->id) selected="selected" @endif>{{ $enterprise->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<th colspan="3">
						SELECCIONE LAS CUENTAS
					</th>
				</thead>
				<tbody id="tbody-account">
					@if(isset($group))
						@php
							$countTD		= 0;
							$arrayIdAccAcc	= [];
							$countIdAccAcc	= 0;
							foreach ($group->hasAccount as $g) 
							{
								$arrayIdAccAcc[$countIdAccAcc] = $g->idAccAcc;
								$countIdAccAcc++;
							}

							$accountExist = App\GroupingHasAccount::select('idAccAcc')->where('idEnterprise',$group->idEnterprise)->where('idGroupingAccount','!=',$group->id)->get();
						@endphp
						@foreach(App\Account::where('idEnterprise',$group->idEnterprise)->where('account','like','5%')->whereNotIn('idAccAcc',$accountExist)->orderBy('account','ASC')->get() as $acc)
							@if($countTD == 0)
								<tr>
							@endif
								@if ($acc->level == 3) 
									<td style="text-align: left;">
										<label class="container">
											<input type="checkbox" name="idAccAcc[]" multiple="multiple" value="{{ $acc->idAccAcc }}" @if(isset($group->hasAccount) && in_array($acc->idAccAcc, $arrayIdAccAcc)) checked="checked" @endif>
											<span class="checkmark"></span>{{ $acc->account }} - {{ $acc->description }} ({{ $acc->content }})
										</label>
									</td>
									@php
										$countTD++;
									@endphp
								@endif
							@if($countTD == 3)
								</tr>
								@php
									$countTD = 0;
								@endphp
							@endif
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
		<br><br><br>
		
		<div class="form-container">
			<input type="submit" name="enviar" value="GUARDAR AGRUPACIÓN" class="btn btn-red">
		</div>
	{!! Form::close() !!}
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script src="{{asset('js/jquery.mask.js')}}"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script type="text/javascript">
	$.ajaxSetup(
	{
		headers:
		{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function() 
	{
		$('[name="idEnterprise"]').select2(
		{
			placeholder				: 'Seleccione una o varias empresas',
			language				: "es",
			maximumSelectionLength	: 1
		});
		
		$(document).on('change','[name="idEnterprise"]',function()
		{
			$('#tbody-account').empty();
			idEnterprise	= $(this).val();
			
			$.ajax(
			{
				type 	: 'get',
				url 	: '{{ url("configuration/account-concentrated/get-accounts") }}',
				data 	: {'idEnterprise':idEnterprise},
				success : function(data)
				{
					$('#tbody-account').append(data)
				}
			});
		})
	});
	{{ isset($alert) }}
</script>
@endsection