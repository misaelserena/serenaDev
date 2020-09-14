@extends('layouts.child_module')
  
@section('data')
		{!! Form::open(['route' => 'administration.warehouse.edit', 'method' => 'GET']) !!}	
			<div class="card">
				<div class="card-header">
					BÚSQUEDA DE INVENTARIO
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="md-form">
							<label class="label-form" for="name">Fecha</label>
							<input type="text" class="form-control" id="date" name="date" @if(isset($date)) value="{{ $date }}" @endif placeholder="Fecha">
						</div>
						<div class="md-form">
							<label class="label-form" for="name">Producto</label>
							<select class="form-control" id="product_id" name="product_id[]" multiple="multiple">
								@foreach(App\Products::where('products.status',1)->orderDescription()->get() as $cat)
									<option value="{{ $cat->id }}" @if(isset($product_id) && in_array($cat->id, $product_id)) selected="selected" @endif>{{ $cat->code }} - {{ $cat->description }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<button class="btn btn-success" type="submit">
						<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#search") }}"></use></svg> Buscar
					</button>
					<button class="btn btn-info" type="submit" formaction="{{ route('administration.warehouse.export') }}">
						<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#file-spreadsheet") }}"></use></svg> Exportar
					</button>
				</div>
			</div>
		{!! Form::close() !!}
	
	<br>
	@if(count($warehouse) > 0)
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="text-align-center thead-dark">
					<tr>
						<th>ID</th>
						<th>Cantidad</th>
						<th>Producto</th>
						<th>Fecha</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody class="text-align-center">
					@foreach($warehouse as $ware)
						<tr>
							<td>{{ $ware->id }}</td>
							<td>{{ $ware->quantity_ex }}</td>
							<td>{{ $ware->product->description }}</td>
							<td>
								{{ $ware->date }}
							</td>
							<td>
								@if($ware->status == 1)
									<a href="{{ route('administration.warehouse.show',$ware->id) }}" class='btn btn-info' alt='Editar' title='Editar'>
										<svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="{{ asset("images/bootstrap-icons.svg#pencil") }}"></use></svg>
									</a> 
									<a href="{{ route('administration.warehouse.delete',$ware->id) }}" class='btn-suspend-ware btn btn-danger' alt='Baja' title='Baja'>
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
			{{ $warehouse->appends(['product_id'=> $product_id,'date'=>$date])->render() }}
		</center>
		@else
			<div class="alert alert-danger" role="alert">Resultado no encontrado</div>
		@endif
		<br><br>
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
			$(function() 
			{
				$("#date").datepicker({ dateFormat: "yy-mm-dd" });
			});
			$('[name="product_id[]"]').select2(
			{
				placeholder				: 'Seleccione un o varios productos',
				language				: "es",
			});
			$(document).on('click','.btn-suspend-ware',function(e)
			{
				e.preventDefault();
				attr = $(this).attr('href');
				swal({
					title		: "",
					text		: "Confirme que desea suspender el producto del inventario",
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
