@extends('layouts.child_module')
@section('data')
	<center>
		{!! Form::open(['route' => 'account.search', 'method' => 'GET', 'id'=>'formsearch']) !!}			
			<center>
				<div class="search-table-center">
					<div class="search-table-center-row">
						<div class="left">
							<label class="label-form">Número de cuenta:</label>
						</div>
						<div class="right">
							<p><input type="text" name="accountNumber" value="{{ isset($accountNumber) ? $accountNumber : '' }}" class="input-text-search" id="input-search" placeholder="Escribe aquí..."></p>
						</div>
					</div>
					<div class="search-table-center-row">
						<div class="left">
							<label class="label-form">Cuenta:</label>
						</div>
						<div class="right">
							<p><input type="text" name="acc" value="{{ isset($acc) ? $acc : '' }}" class="input-text-search" id="input-search" placeholder="Escribe aquí..."></p>
						</div>
					</div>
					<div class="search-table-center-row">
					<p>
						<select title="Empresa" name="enterpriseid" class="js-enterprise" multiple="multiple" style="width: 98%; max-width: 50px;">
							@foreach(App\Enterprise::orderName()->get() as $enterprise)
								@if(isset($enterpriseid) && $enterpriseid == $enterprise->id)
									<option value="{{ $enterprise->id }}" selected>{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,40).'...' : $enterprise->name }}</option>
								@else
									<option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,40).'...' : $enterprise->name }}</option>
								@endif
							@endforeach
						</select>
					</p>
				</div>
				</div>
			</center>
			<center>
				<button class="btn btn-search" type="submit"><span class="icon-search"></span> Buscar</button>
			</center>
		{!! Form::close() !!}
	</center>
	<br>
	@if(count($accounts) > 0)
		<div class="table-responsive">
		  	<table id='table' class='table table-striped'>
		  		<thead class="thead-dark">
		  			<tr>
		  				<th>ID</th>
		  				<th>Número de Cuenta</th>
		  				<th>Cuenta</th>
		  				<th>Empresa</th>
		  				<th>Acci&oacute;n</th>
		  			</tr>
		  		</thead>
		  		<tbody>
				  	@foreach($accounts as $account)
						<tr>
							<td>{{ $account->idAccAcc }}</td>
							<td>{{ $account->account }}</td>
							<td>{{ $account->description }}</td>
							<td>{{ $account->enterprise->name }}</td>
							<td><a title='Editar Cuenta' href="{{ route('account.edit',$account->idAccAcc) }}" class='btn btn-green'><span class='icon-pencil'></span></a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<center>
			{{ $accounts->appends(['accountNumber'=> $accountNumber,'acc'=> $acc,'enterpriseid' => $enterpriseid])->render() }}
		</center>
		@else
			<div id="not-found" style="display:block;">Resultado no encontrado</div>
		@endif
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function(){
			
			$('input[name="accountNumber"]').numeric(false);

			$('#input-search').on('keyup',function(){
				$text = $(this).val();
				if ($text == "" || $text == " " || $text == "  " || $text == "   ") {
					$('#not-found').stop().show();
					$('#not-found').html("RESULTADO NO ENCONTRADO");
					$('#table').stop().hide();
				}else{
					$('#not-found').stop().hide();
					$.ajax({
						type	: 'get',
						url		: '{{ url("configuration/account/search/search") }}',
						data 	: {'search':$text},
						success:function(data){
							$('.table-responsive').html(data);
						}
					});
				}
			});
			$('.js-enterprise').select2(
			{
				placeholder				: 'Seleccione una empresa',
				language				: "es",
				maximumSelectionLength	: 1,
			});
		});
	</script>
	<script type="text/javascript"> 
      @if(isset($alert)) 
      {!! $alert !!} 
      @endif 
    </script> 
@endsection