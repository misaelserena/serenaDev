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
	<br>
	
	{!! Form::open(['route' => ['tickets.assigned.update', $ticket->idTickets], 'method' => 'put', 'id' => 'container-alta','files'=>true]) !!}
			<center>
				<div class="table-responsive">
					<br><br>
					<center>
					<table class="table">
						<thead class="thead-dark">
							<th colspan="2">
								DATOS DEL TICKET #{{ $ticket->idTickets }}
							</th>
						</thead>
						<tbody>
							<tr>
								<td style="text-align: right;"><label class="label-form"># Ticket</label></td>
								<td style="text-align: left;">{{ $ticket->idTickets }}</td>
							</tr>
							<tr>
								<td style="text-align: right;"><label class="label-form">Solicitante: </label></td>
								<td style="text-align: left;"> {{ $ticket->requestUser->name.' '.$ticket->requestUser->last_name.' '.$ticket->requestUser->scnd_last_name }} </td>
							</tr>
							<tr>
								<td style="text-align: right;"><label class="label-form">Sección: </label></td>
								<td style="text-align: left;"> {{ $ticket->sectionTicket->section }} </td>
							</tr>
							<tr>
								<td style="text-align: right;"><label class="label-form">Tipo: </label></td>
								<td style="text-align: left;"> {{ $ticket->typeTicket->type }} </td>
							</tr>
							<tr>
								<td style="text-align: right;"><label class="label-form">Prioridad: </label></td>
								<td style="text-align: left;"> {{ $ticket->priorityTicket->priority }}</td>
							</tr>
							<tr>
								<td style="text-align: right;"><label class="label-form">Estado: </label></td>
								<td style="text-align: left;">{{ $ticket->statusTicket->status }}</td>
							</tr>
							<tr>
								<td style="text-align: right;"><label class="label-form">Asunto: </label></td>
								<td style="text-align: left;">{{ $ticket->subject }}</td>
							</tr>
							<tr>
								<td style="text-align: right;"><label class="label-form">Mensaje: </label></td>
								<td style="text-align: left;">{!! nl2br($ticket->question) !!}</td>
							</tr>
							<tr>
								<td style="text-align: right;"><label class="label-form">Archivo(s): </label></td>
								<td style="text-align: left;">
									@if($ticket->documentsTickets()->count()>0)
										@foreach($ticket->documentsTickets as $document)
											<a title="{{ $document->path }}" href="{{ url('docs/tickets/'.$document->path)}}" target="_blank">{{ $document->path }}</a><br><br>
										@endforeach
									@else
										Sin archivos
									@endif
								</td>
							</tr>
							@if (count($ticket->answerTicket) > 0)
								@foreach ($ticket->answerTicket as $answer)
									<tr style="border-top: 1px solid #c6c6c6;">
										<td style="text-align: right;"><label class="label-form">Respuesta de {{ $answer->answerUser->name.' '.$answer->answerUser->last_name }}: </label>
											<br>
										</td>
										<td style="text-align: left;"> {!! nl2br($answer->answer) !!} <br> <br>
											@if ($answer->path != null)
												<b>Archivo adjunto:</b> <a href="{{ url('docs/tickets/'.$answer->path)}}" target="_blank">{{ $answer->path}}</a><br><br>
											@endif
											<p style="text-align: right;">
												<b>Fecha y hora:</b> {{ date('d-M-Y H:i:s',strtotime($answer->date)) }}
											</p>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
					<br>
						<input type="submit" name="save" class="btn btn-red" value="TOMAR TICKET">
						<a 
								@if(isset($option_id)) 
									href="{{ url(App\Module::find($option_id)->url) }}" 
								@else 
									href="{{ url(App\Module::find($child_id)->url) }}" 
								@endif 
							><button class="btn" type="button">REGRESAR</button></a>
					</center>
					<br><br>
				</div>
			</center>	
			{!! Form::close() !!}
		<br>
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
	$.ajaxSetup(
	{
		headers:
		{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.validate(
	{
		form		: '#container-alta',
		modules		: 'security',
		onSuccess	: function($form)
		{
			status = $('input[name="status"]').is(':checked');
			if(status == false)
			{
				swal('', 'Debe seleccionar un tipo de usuario', 'error');
				return false;
			}
			else
			{
				return true;
			}
		
		}
	});
	$(document).ready(function()
	{
		$('.js-users').select2(
		{
			placeholder				: 'Asignar usuario',
			allowClear				: false,
			language				: "es",
			maximumSelectionLength	: 1
		});
	});
	$(document).on('change','input[name="status"]',function()
	{
		if ($('input[name="status"]:checked').val() == "1") 
		{
			$(".show-answer").slideDown('slow');
		}
		if ($('input[name="status"]:checked').val() == "2") 
		{
			$(".show-answer").slideUp('slow');
		}
	});
	 @if(isset($alert)) 
      {!! $alert !!} 
    @endif 
</script>
@endsection	