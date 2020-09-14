@extends('layouts.child_module')

@section('data')
<form>
	<div id="container-cambio" class="div-search">
		<center>
			<strong>BUSCAR</strong>
		</center>
		<div class="divisor">
			<div class="gray-divisor"></div>
			<div class="orange-divisor"></div>
			<div class="gray-divisor"></div>
		</div>
		<center>
			<div class="search-table-center">
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Folio:</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="folio" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($folio) ? $folio : '' }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Título:</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="title_request" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($title_request) ? $title_request : '' }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Operación" name="operation[]" class="js-operation" multiple="multiple" style="width: 98%;">
							<option value="Entrada" @if(isset($operation) && in_array('Entrada', $operation)) selected="selected" @endif>Entrada</option>
							<option value="Salida" @if(isset($operation) && in_array('Salida', $operation)) selected="selected" @endif>Salida</option>
						</select>
					</p>
				</div>
			</div>
		</center>
		<center>
			<button class="btn 	btn-search send" type="submit" title="Buscar"><span class="icon-search"></span> Buscar</button> 
		</center>
		<br><br>
	</div>

@if(isset($requests) && count($requests)>0)
	<div style='float: right'><label class='label-form'>Exportar a Excel: <label><button class='btn btn-green export' type='submit'  formaction="{{ route('report.group.commissions.excel') }}"><span class='icon-file-excel'></span></button></div>
</form>
	<div class="table-responsive table-striped">
		<table class="table">
			<thead class="thead-dark">
				<th width="5%">Folio</th>
				<th>Título</th>
				<th>Tipo de operación</th>
				<th>Importe Total</th>
				<th>Comisión</th>
				<th>Importe a retomar</th>
			</thead>
			<tbody>
				@foreach($requests as $req)
					<tr>
						<td>
							{{ $req->folio }}
						</td>
						<td>
							{{$req->groups->first()->title}} {{$req->groups->first()->datetitle}}
						</td>
						<td>
							{{ $req->groups->first()->operationType }}
						</td>
						<td>
							$ {{number_format($req->groups->first()->amountMovement,2)}}
						</td>
						<td>
							$ {{number_format($req->groups->first()->commission,2)}}
						</td>
						<td>
							$ {{number_format($req->groups->first()->amountRetake,2)}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<center>
		{{ $requests->appends([
				'title_request'	=> $title_request,
				'folio'			=> $folio,
				'operation'		=> $operation
			])->render() }}
	</center><br><br><br>
@else
	<div id="not-found" style="display:block;">Resultado no encontrado</div>
	</form>
@endif

@endsection

@section('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('input[name="folio"]').numeric(false);
		$('.js-operation').select2(
		{
			placeholder : 'Seleccione una operación',
			language 	: 'es',
		});
	});
</script> 
@endsection


