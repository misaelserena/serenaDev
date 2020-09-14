@extends('layouts.child_module')
  
@section('data')
	<center>
		{!! Form::open(['route' => 'configuration.module.edit', 'method' => 'GET']) !!}			
			<div class="container">
				<div class="form-group">
					<div class="col-md-6 mb-3 text-align-left">
						<label for="name">Nombre</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="{{ isset($name) ? $name : '' }}">
					</div>
				</div>
			</div>
			<button class="btn btn-success" type="submit">
				<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
			</button>
		{!! Form::close() !!}
	</center>
	<br>
	@if(count($modules) > 0)
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="text-align-center thead-dark">
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody class="text-align-center">
					@foreach($modules as $module)
						<tr>
							<td>{{ $module->id }}</td>
							<td>{{ $module->name }}</td>
							<td>
								<a href="{{ route('configuration.module.show',$module->id) }}" class='btn btn-info' alt='Editar' title='Editar'>
									<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#pencil") }}"></use></svg>
								</a> 
								<a href="{{ route('configuration.module.delete',$module->id) }}" class='btn btn-danger' alt='Baja' title='Baja'>
									<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#trash-fill") }}"></use></svg>
								</a> 
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
		<center>
			{{ $modules->appends(['name'=> $name])->render() }}
		</center>
		<br>
		@else
			<div class="alert alert-danger" role="alert">Resultado no encontrado</div>
		@endif
@endsection

@section('scripts')
	<script>
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function()
		{
			
		}); 
	</script>
@endsection
