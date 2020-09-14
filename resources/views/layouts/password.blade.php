@extends('layouts.layout')
@section('title', $title)
@section('content')
<a class="block back-button"
	@if(isset($option_id))
		href="{{ url(App\Module::find($child_id)->url) }}"
	@else
		href="{{ url(App\Module::find($id)->url) }}"
	@endif
	>« Regresar</a>
<div class="title-config">
		<h1>{{ $title }}</h1>
		</div>
		<center>
			<i style="color: #B1B1B1">{{ $details }}</i>
		</center>
		<br>
		<hr>
		<br>
		<div class="data-container">
			<form method="POST" action="{{ route('profile.password.update') }}">
		        @csrf

		        <div class="form-container">
		        	<div class="div-form-group">
		        		<p>
				        	<label class="label-form">Contraseña Actual</label>
				        	<input type="password" name="password_current" class="input-text{{ $errors->has('password') ? ' is-invalid' : '' }}" data-validation='required'>
			        	</p>
		        		<p>
				        	<label class="label-form">Nueva Contraseña</label>
				        	<input type="password" name="password" class="input-text{{ $errors->has('password') ? ' is-invalid' : '' }}" data-validation='required'>
			        	</p>

			        	<p>
			        		<label class="label-form">Confirmar Contraseña</label>
			        		<input type="password" name="password_confirmation" class="input-text{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" data-validation="required">
			        	</p>

			        	<p>
			        		<input type="submit" name="send" class="btn btn-red" value="Cambiar Contraseña">
			        		<a 
								@if(isset($option_id))
									href="{{ url(App\Module::find($child_id)->url) }}"
								@else
									href="{{ url(App\Module::find($id)->url) }}"
								@endif
							><button class="btn" type="button">REGRESAR</button></a>
			        	</p>
		        	</div>
		        </div>

		       
		    </form>
		</div>
@endsection
@section('scripts')
	@if(isset($alert))
		<script type="text/javascript">
			{!! $alert !!}
		</script>
	@endif
@endsection
