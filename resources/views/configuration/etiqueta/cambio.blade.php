@extends('layouts.child_module')
@section('data')
	{!! Form::open(['route' => ['labels.update', $label->idlabels], 'method' => 'PUT', 'id' => 'container-alta']) !!}
		<div class="container-blocks" id="container-data">
			<div class="div-form-group">
				<label class="label-form">Descripción</label><br>
				<p><input type="text" class="input-text" name="description" placeholder="Nombre de la empresa" value="{{ $label->description }}" data-validation="required server" data-validation-url="{{ url('configuration/labels/validate') }}" data-validation-req-params="{{ json_encode(array('oldLabel'=>$label->description)) }}"></p>
			</div>
			<div class="form-container">
				<input class="btn btn-red" type="submit" name="enviar" value="GUARDAR CAMBIOS"> 
				<input class="btn" type="reset" name="borra" value="Borrar campos">
			</div>
		</div>
    {!! Form::close() !!}

@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
		modules		: 'security',
		form: '#container-alta',
	});
</script>
@endsection