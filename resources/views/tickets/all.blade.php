@extends('layouts.layout')
@section('title', $title)
@section('content')

<!-- QUITAR CAMBIOS!!!! BUSCAR LA PAGINACION CON AJAX -->
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
			@php
				foreach(Auth::user()->inReview as $review)
			 	{ 
			 		$idSection[] = $review->idsectionTickets; 
			 	}
			@endphp
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
							<input type="text" name="id" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($idticket) ? $idticket : '' }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Asunto:</label>
					</div>
					<div class="right">
						<p>
							<input type="text" name="subject" class="input-text-search" id="input-search" placeholder="Escribe aquí..." value="{{ isset($subject) ? $subject : '' }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<div class="left">
						<label class="label-form">Rango de fechas:</label>
					</div>
					<div class="right-date">
						<p>
							<input type="text" name="mindate" step="1" class="input-text-date datepicker" placeholder="Desde" value="{{ isset($mindate) ? date('d-m-Y',strtotime($mindate)) : '' }}"> - <input type="text" name="maxdate" step="1" class="input-text-date datepicker" placeholder="Hasta" value="{{ isset($maxdate) ? date('d-m-Y',strtotime($maxdate)) : '' }}">
						</p>
					</div>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Asignado a" class="js-assign" multiple="multiple" style="width: 98%; max-width: 150px;">
							<option @if($assign == 'Sin asignar') selected @endif value="Sin asignar">Sin asignar</option>
							@foreach (App\User::orderName()->select('users.id','users.name','users.last_name','users.scnd_last_name')
										->join('user_has_module','users.id','user_has_module.user_id')
										->join('user_review_ticket','users.id','user_review_ticket.user_id')
										->whereIn('user_review_ticket.section_tickets_idsectionTickets',$idSection)
										->where('user_has_module.module_id',106)
										->where(function($query)
											{
												$query->where('users.status','ACTIVE')->orWhere('users.status','RE-ENTRY');
											})
										->distinct()
										->get()  as $u)
								@if(isset($assign) && $assign == $u->id)
									<option selected value="{{ $u->id }}">{{ $u->name.' '.$u->last_name.' '.$u->scnd_last_name }}</option>
								@else
									<option value="{{ $u->id }}">{{ $u->name.' '.$u->last_name.' '.$u->scnd_last_name  }}</option>
								@endif
							@endforeach
						</select>
						<input type="hidden" name="assign" value="{{ isset($assign) ? $assign : '' }}">
					</p>
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Sección" class="js-section" multiple="multiple" style="width: 98%; max-width: 150px;">
							@foreach($sections as $sec)
								 @if(isset($section) && $section == $sec->idsectionTickets)
								 	<option selected value="{{ $sec->idsectionTickets }}">{{ $sec->section }}</option>
								 @else
									<option value="{{ $sec->idsectionTickets }}">{{ $sec->section }}</option>
								@endif
							@endforeach
						</select>
					</p>
					<input type="hidden" name="section" value="{{ isset($section) ? $section : '' }}">
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Tipo" class="js-type" multiple="multiple" style="width: 98%; max-width: 150px;">
							@foreach(App\TicketType::orderName()->get() as $types)
								 @if(isset($type) && $type == $types->idTypeTickets)
									<option selected value="{{ $types->idTypeTickets }}">{{ $types->type }}</option>
								@else
									<option value="{{ $types->idTypeTickets }}">{{ $types->type }}</option>
								@endif
							@endforeach
						</select>
					</p>
					<input type="hidden" name="type" value="{{ isset($type) ? $type : '' }}">
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Prioridad" class="js-priority" multiple="multiple" style="width: 98%; max-width: 150px;">
							@foreach(App\TicketPriority::orderName()->get() as $p)
								@if(isset($priority) && $priority == $p->idPriorityTickets)
									<option selected value="{{ $p->idPriorityTickets }}">{{ $p->priority }}</option>
								@else
									<option value="{{ $p->idPriorityTickets }}">{{ $p->priority }}</option>
								@endif
							@endforeach
						</select>
					</p>
					<input type="hidden" name="priority" value="{{ isset($priority) ? $priority : '' }}">
				</div>
				<div class="search-table-center-row">
					<p>
						<select title="Estado" class="js-status" multiple="multiple" style="width: 98%; max-width: 150px;">
							@foreach(App\TicketStatus::orderName()->get() as $s)
								@if(isset($status) && $status == $s->idStatusTickets)
									<option selected value="{{ $s->idStatusTickets }}">{{ $s->status }}</option>
								@else
									<option value="{{ $s->idStatusTickets }}">{{ $s->status }}</option>
								@endif
							@endforeach
						</select>
					</p>
					<input type="hidden" name="status" value="{{ isset($status) ? $status : '' }}">
				</div>
			</div>
		</center>
		<center>
			<button class="btn btn-search" type="submit"><span class="icon-search"></span> Buscar</button>
		</center>
	{!! Form::close() !!}
<br><br>
</div>
<br>

@if(count($tickets) > 0)
	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="thead-dark">
				<th width="10%">#</th>
				<th width="10%">Asunto</th>
				<th width="10%">Solicitante</th>
				<th width="10%">Fecha</th>
				<th width="10%">Sección</th>
				<th width="10%">Tipo</th>
				<th width="10%">Prioridad</th>
				<th width="10%">Asignado</th>
				<th width="10%">Estado</th>
				<th width="10%">Acción</th>
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
					<td>{{ $ticket->sectionTicket->section }}</td>
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
					@if($ticket->assigned_id != null)
						@foreach(App\User::where('id',$ticket->assigned_id)->get() as $user)
							<td>{{ $user->name }} {{ $user->last_name }} {{ $user->scnd_last_name }}</td>
						@endforeach
					@else
						<td>Sin Asignar</td>
					@endif
					<td>
						{{ $ticket->statusTicket->status }}
					</td>
					<td>
						@if($ticket->assigned_id == null && $ticket->idStatusTickets == 1)
							{!! Form::open(['route' => ['tickets.all.view', $ticket->idTickets], 'method' => 'get']) !!}
								<button title="Ver Ticket" alt="Ver Ticket" class="btn follow-btn" type="submit">
									<span class="icon-search"></span>
								</button>
							{!! Form::close() !!}
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	</div>

	<center>
		{{ $tickets->appends(['idticket'=>$idticket,'subject'=>$subject,'type'=> $type,'priority'=> $priority,'status'=> $status,'section'=> $section,'mindate'=> $mindate,'maxdate'=> $maxdate,'assign'=> $assign])->render() }}
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
		$('.js-section').select2(
		{
			placeholder : 'Seleccione la sección',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$('.js-assign').select2(
		{
			placeholder : 'Asignado a',
			language 	: 'es',
			maximumSelectionLength : 1,

		});
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
		$(document).on('change','.js-assign',function()
		{
			$('input[name="assign"]').val($(this).val());
		})
		.on('change','.js-section',function()
		{
			$('input[name="section"]').val($(this).val());
		})
		.on('change','.js-type',function()
		{
			$('input[name="type"]').val($(this).val());
		})
		.on('change','.js-priority',function()
		{
			$('input[name="priority"]').val($(this).val());
		})
		.on('change','.js-status',function()
		{
			$('input[name="status"]').val($(this).val());
		});
	});
	@if(isset($alert))
		{!! $alert !!}
	@endif
</script>
@endsection