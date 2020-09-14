@extends('layouts.child_module')
  
@section('data')
	<center>
		{!! Form::open(['route' => 'account-concentrated.search', 'method' => 'GET', 'id'=>'formsearch']) !!}			
		<center>
			<div class="search-table-center">
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Nombre:</label>
					</div>
					<div class="right">
						<p><input type="text" name="name" value="{{ isset($name) ? $name : '' }}" class="new-input-text" id="input-search" placeholder="Escribe aquí..."></p>
					</div>
					<div class="search-table-center-row">
						<p>
							<select class="js-enterprises form-control" name="enterprise_id[]" multiple="multiple">
								@foreach(App\Enterprise::orderName()->get() as $ent)
									<option value="{{ $ent->id }}" @if(isset($enterprise_id) && in_array($ent->id, $enterprise_id))  selected="selected" @endif>{{ $ent->name }}</option>
								@endforeach
							</select><br>
						</p>
					</div>
				</div>
			</div>
		</center>
		<center>
			<button class="btn btn-search" type="submit"><span class="icon-search"></span> Buscar</button>
		</center>
		{!! Form::close() !!}
	</center>
	<br>
	@if(count($groups) > 0)
		<div class="table-responsive">
			<table id='table' class='table table-striped'>
				<thead class="thead-dark">
					<tr>
						<th>Nombre</th>
						<th>Empresa</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody>
					@foreach($groups as $g)
						<tr>
							<td>{{ $g->name }}</td>
							<td>{{ $g->enterprise->name }}</td>
							<td>
								<a href="{{ route('account-concentrated.edit',$g->id) }}" class='btn btn-green' alt='Editar' title='Editar'><span class='icon-pencil'></span></a>
								<a href="{{ route('account-concentrated.delete',$g->id) }}" class='btn btn-red' alt='Eliminar' title='Eliminar'><span class='icon-bin'></span></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<center>
			{{ $groups->appends(['enterprise_id'=> $enterprise_id,'name'=> $name])->render() }}
		</center>
	@else
		<div id="not-found" style="display:block;">Resultado no encontrado</div>
	@endif
@endsection

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.js-enterprises').select2(
		{
			placeholder				: 'Seleccione la Empresa',
			language				: "es",
		});
	});
</script>
@endsection
