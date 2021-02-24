@extends('layouts.child_module')
  
@section('data')
		{!! Form::open(['route' => 'configuration.product.edit', 'method' => 'GET']) !!}	
		<div class="card">
			<div class="card-header">
				BÚSQUEDA
			</div>
			<div class="card-body">		
				<div class="form-group">
					<div class="md-form">
						<label for="description">Descripción</label>
						<input type="text" class="form-control" id="description" name="description" value="{{ isset($description) ? $description : '' }}">
					</div>
					<div class="md-form">
						<label for="code">Código</label>
						<input type="text" class="form-control" id="code" name="code" value="{{ isset($code) ? $code : '' }}">
					</div>
				</div>
				<button class="btn btn-success" type="submit">
					<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
				</button>
			</div>
		</div>
		{!! Form::close() !!}
	<br>
	@if(count($products) > 0)
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="text-align-center thead-dark">
					<tr>
						<th>ID</th>
						<th>Código</th>
						<th>Descripción</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody class="text-align-center">
					@foreach($products as $product)
						<tr>
							<td>{{ $product->id }}</td>
							<td>{{ $product->code }}</td>
							<td>{{ $product->nameProduct() }}</td>
							<td>
								@if($product->status == 1)
									<a href="{{ route('configuration.product.show',$product->id) }}" class='btn btn-info' alt='Editar' title='Editar'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#pencil") }}"></use></svg>
									</a> 
									<a href="{{ route('configuration.product.delete',$product->id) }}" class='btn-suspend-product btn btn-danger' alt='Baja' title='Baja'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#trash-fill") }}"></use></svg>
									</a> 
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
		<center>
			{{ $products->appends([
					'description'	=> $description,
					'code'			=> $code,
				])->render() }}
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
			$('[name="provider_id[]"]').select2(
			{
				placeholder				: 'Seleccione uno o varios',
				language				: "es"
			});
			$(document).on('click','.btn-suspend-product',function(e)
			{
				e.preventDefault();
				attr = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea dar de baja el producto",
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
			});
		}); 
	</script>
@endsection
