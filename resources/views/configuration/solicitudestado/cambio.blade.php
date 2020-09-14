@extends('layouts.child_module')
@section('data')
	{!! Form::open(['route' => ['status.update', $status->idrequestStatus], 'method' => 'PUT', 'id' => 'container-alta']) !!}
		<div class="container-blocks" id="container-data">
			<div class="div-form-group">
				<label class="label-form">Descripción</label><br>
				<p><input type="text" name="description" class="input-text" value="{{ $status->description }}" data-validation="length" data-validation-length="min1"></p><br><br>
			</div>
			<div class="form-container">
				<input class="btn btn-red" type="submit" name="enviar" value="GUARDAR CAMBIOS"> 
				<input class="btn" type="reset" name="borra" value="Borrar campos">
			</div>
		</div>
    {!! Form::close() !!}

@endsection