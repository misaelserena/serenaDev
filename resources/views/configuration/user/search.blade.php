@extends('layouts.child_module')
  
@section('data')
	<center>
		{!! Form::open(['route' => 'configuration.user.edit', 'method' => 'GET']) !!}	
		<div class="card">
			<div class="card-header">
				BÚSQUEDA
			</div>
			<div class="card-body">				
				<div class="form-group">
					<div class="md-form">
						<label for="name">Nombre</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ isset($name) ? $name : '' }}">
					</div>
				</div>
				<div class="form-group">
					<div class="md-form">
						<label for="email">Email</label>
						<input type="text" class="form-control" id="email" name="email" value="{{ isset($email) ? $email : '' }}">
					</div>
				</div>

				<div class="form-group">
					<div>
						<select class="form-control" name="type" multiple="multiple" title="Tipo de usuario">
							<option value="0" @if(isset($type) && $type == 0) selected="selected" @endif>Empleado</option>
							<option value="1" @if(isset($type) && $type == 1) selected="selected" @endif>Usuario del sistema</option>
						</select>
					</div>
				</div>
				<button class="btn btn-success" type="submit">
					<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
				</button>
			</div>
		</div>
		{!! Form::close() !!}
	</center>
	<br>
	@if(count($users) > 0)
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="text-align-center thead-dark">
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Correo Electrónico</th>
						<th>Estado</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody class="text-align-center">
					@foreach($users as $user)
						<tr>
							<td>{{ $user->id }}</td>
							<td>{{ $user->name.' '.$user->last_name.' '.$user->scnd_last_name }}</td>
							<td>{{ $user->email }}</td>
							<td>
								@if($user->status=="ACTIVE" || $user->status=="NO-BOLETIN") 
									Activo 
								@elseif($user->status=="RE-ENTRY" ||$user->status=="RE-ENTRY-NO-MAIL") 
									Reingreso
								@elseif($user->status=="SUSPENDED") 
									Suspendido
								@else
									Baja
								@endif
							</td>
							<td>
								<a href="{{ route('configuration.user.show',$user->id) }}" class='btn btn-info' alt='Editar' title='Editar'>
									<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#pencil") }}"></use></svg>
								</a> 
								@if($user->status=="ACTIVE" || $user->status=="NO-BOLETIN" || $user->status=="RE-ENTRY" ||$user->status=="RE-ENTRY-NO-MAIL")
									<a href="{{ route('configuration.user.delete',$user->id) }}" class='btn-destroy-user btn btn-danger' alt='Baja' title='Baja'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#trash-fill") }}"></use></svg>
									</a> 
									<a href="{{ route('configuration.user.suspend',$user->id) }}" class='btn-suspend-user btn btn-warning' alt='Suspender' title='Suspender'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#person-dash") }}"></use></svg>
									</a>
								@elseif($user->status=="SUSPENDED")
									<a href="{{ route('configuration.user.delete',$user->id) }}" class='btn-destroy-user btn btn-danger' alt='Baja' title='Baja'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#trash-fill") }}"></use></svg>
									</a> 
									<a href="{{ route('configuration.user.reentry',$user->id) }}" class='btn-reentry-user btn btn-success' alt='Reingresar' title='Reingresar'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#person-plus") }}"></use></svg>
									</a>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
		<center>
			{{ $users->appends(['name'=> $name,'email'=> $email,'type' => $type])->render() }}
		</center>
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
			$('[name="type"]').select2(
			{
				placeholder				: 'Tipo de Usuario',
				language				: "es",
				maximumSelectionLength	: 1,
				width 					: '100%'
			});
			$(document).on('click','.btn-destroy-user',function(e)
			{
				e.preventDefault();
				attr = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea dar de baja definitiva al usuario",
					icon		: "warning",
					buttons		:
					{
						cancel:
						{
							text		: "Cancelar",
							value		: null,
							visible		: true,
							closeModal	: true,
						},
						confirm:
						{
							text		: "Baja",
							value		: true,
							closeModal	: false
						}
					},
					dangerMode	: true,
				})
				.then((a) => {
					if (a)
					{
						window.location.href=attr;
					}
				});
			})
			.on('click','.btn-suspend-user',function(e)
			{
				e.preventDefault();
				attr = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea suspender el usuario",
					icon		: "warning",
					buttons		:
					{
						cancel:
						{
							text		: "Cancelar",
							value		: null,
							visible		: true,
							closeModal	: true,
						},
						confirm:
						{
							text		: "Suspender",
							value		: true,
							closeModal	: false
						}
					},
					dangerMode	: true,
				})
				.then((a) => {
					if (a)
					{
						window.location.href=attr;
					}
				});
			})
			.on('click','.btn-reentry-user',function(e)
			{
				e.preventDefault();
				attr = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea reingresar el usuario",
					icon		: "warning",
					buttons		:
					{
						cancel:
						{
							text		: "Cancelar",
							value		: null,
							visible		: true,
							closeModal	: true,
						},
						confirm:
						{
							text		: "Reingresar",
							value		: true,
							closeModal	: false
						}
					},
					dangerMode	: true,
				})
				.then((a) => {
					if (a)
					{
						window.location.href=attr;
					}
				});
			});
		}); 
	</script>
@endsection
