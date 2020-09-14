<div class='modal-content'>
	<div class='modal-header'>
		<span class='close exit'>&times;</span>
	</div>
	<div class='modal-body'>
    
    <div class="profile-table-center">
			<div class="profile-table-center-header">
				{{ $title }}
      </div>
      @foreach ($table_data as $key => $value)
      <div class="profile-table-center-row">
				<div class="left">
					{{ $key }}
				</div>
				<div class="right">
					<p>{{ $value }}</p>
				</div>
			</div>
      @endforeach
			
    </div>

   @switch($request->kind)
    @case(11)
      @include('reporte.administracion.partial.movimiento_entre_cuentas.ajuste_datos_origen') 
      @break
    @case(12)
      @include('reporte.administracion.partial.movimiento_entre_cuentas.prestamo') 
      @break
    @case(13)
      @include('reporte.administracion.partial.movimiento_entre_cuentas.inter_empresas') 
      @break
    @case(14)
      @include('reporte.administracion.partial.movimiento_entre_cuentas.grupos') 
      @break
    @case(15)
      @include('reporte.administracion.partial.movimiento_entre_cuentas.misma_empresa') 
      @break
    @default
  @endswitch
    
	</div>
	<center>
		<button class="btn btn-red exit">Cerrar</button>
	</center>
</div>
