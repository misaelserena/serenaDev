@extends('layouts.layout')
@section('title', $title)
@section('content')
	<div class="container-blocks-all">
		<div class="title-config">
			<h1>{{ $title }}</h1>
		</div>
		<center>
			<i style="color: #B1B1B1">{{ $details }}</i>
		</center>
		<br>
		<hr>
		<h4>Acciones: </h4>
		<div class="container-sub-blocks">
			@foreach(Auth::user()->module->where('father',105)->sortBy('created_at') as $key)
				<a
				
				@if(isset($option_id) && $option_id==$key['id'])
					class=" sub-block sub-block-active"
				@else
					class="sub-block"
				@endif
				href="{{ url($key['url']) }}">{{ $key['name'] }}</a>
			@endforeach
		</div>
	</div>
	<div id="container-cambio" class="div-search">
	{!! Form::open(['route' => 'tickets.all', 'method' => 'GET', 'id'=>'formsearch']) !!}
		<center>
			<strong>BUSCAR TICKETS</strong>
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
						<br><label class="label-form">Número de Ticket:</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="id" class="input-text-search" id="input-search" placeholder="Escribe aquí...">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Asunto:</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="subject" class="input-text-search" id="input-search" placeholder="Escribe aquí...">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Tipo" class="js-type" multiple="multiple" name="type" style="width: 98%; max-width: 150px;">
							@foreach(App\TicketType::all() as $type)
								<option value="{{ $type->idTypeTickets }}">{{ $type->type }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Prioridad" class="js-priority" multiple="multiple" name="priority" style="width: 98%; max-width: 150px;">
							@foreach(App\TicketPriority::all() as $priority)
								<option value="{{ $priority->idPriorityTickets }}">{{ $priority->priority }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Estado" class="js-status" multiple="multiple" name="status" style="width: 98%; max-width: 150px;">
							@foreach(App\TicketStatus::all() as $status)
								<option value="{{ $status->idStatusTickets }}">{{ $status->status }}</option>
							@endforeach
						</select>
					</p>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Rango de fechas:</label>
					</div>
					<div class="right-date">
						<p>
							<input type="text" name="mindate" step="1" class="input-text-date datepicker" placeholder="Desde"> - <input type="text" name="maxdate" step="1" class="input-text-date datepicker" placeholder="Hasta">
						</p>
					</div>
				</div>
			</div>
		</center>
		<center>
			<button class="btn 	btn-search" type="submit"><span class="icon-search"></span> Buscar</button>
		</center>
	{!! Form::close() !!}
<br><br>
</div>
<br>

@if(count($tickets) > 0)
	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="thead-dark">
				<th width="11.11"># Ticket</th>
				<th width="11.11">Asunto</th>
				<th width="11.11">Solicitante</th>
				<th width="11.11">Fecha</th>
				<th width="11.11">Tipo</th>
				<th width="11.11">Prioridad</th>
				<th width="11.11">Estado</th>
				<th width="11.11">Acción</th>
				
			</thead>
			@foreach($tickets as $ticket)
				<tr>
					<td>{{ $ticket->idTickets }}</td>
					<td> {{ $ticket->subject }} </td>
					
					@foreach(App\User::where('id',$ticket->request_id)->get() as $user)
						<td>{{ $user->name }} {{ $user->last_name }} {{ $user->scnd_last_name }}</td>
					@endforeach
					@php	
						$time	= strtotime($ticket->request_date);
						$date	= date('d-m-Y H:i',$time);
					@endphp 
					<td>{{ $date  }}</td>
					
					<td> {{ $ticket->typeTicket->type }} </td>
					<td><label class="
						@switch($ticket->priorityTicket->priority)
							@case('Urgente')
								priority-red
								@break
							@case('Alta')
								priority-orange
								@break
							@case('Normal')
								priority-yellow
								@break
							@case('Baja')
								priority-green
								@break
							@default
						@endswitch
						">{{ $ticket->priorityTicket->priority }}</label></td>
					<td>
						{{ $ticket->statusTicket->status }}
					</td>
					<td>
						<a alt="Asignar Ticket" title="Asignar Ticket" href="{{ route('tickets.assigned',$ticket->idTickets) }}" class='btn follow-btn'><span class='icon-user-plus'></span></a>
					</td>
					
				</tr>
			@endforeach
		</table>
	</div>

	<center>
		{{ $tickets->render() }}
	</center><br><br><br>
@else
	<div id="not-found" style="display:block;">Resultado no encontrado</div>
@endif
@endsection
@section('scripts')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script type="text/javascript"> 
	$(document).ready(function()
	{
		$('#input-search').numeric(false);
		$('.js-type').select2(
		{
			placeholder : 'Seleccione el tipo',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$('.js-priority').select2(
		{
			placeholder : 'Seleccione la prioridad',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$('.js-status').select2(
		{
			placeholder : 'Seleccione el estado',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});
	@if(isset($alert))
		{!! $alert !!}
	@endif
</script>
@endsection