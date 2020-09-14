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
	
	{!! Form::open(['route' => ['tickets.solve.follow', $ticket->idTickets], 'method' => 'put', 'id' => 'container-alta','files'=>true]) !!}
			
		<table class="table">
			<thead class="thead-dark">
				<th colspan="2">
					DATOS DEL TICKET #{{ $ticket->idTickets }}
				</th>
			</thead>
			<tbody>
				<tr>
					<td width="20%" style="text-align: right;"><label class="label-form"># Ticket</label></td>
					<td width="80%" style="text-align: left;">{{ $ticket->idTickets }}</td>
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
					<td style="text-align: left;">{!!  nl2br($ticket->question) !!}</td>
				</tr>
				<tr>
					<td style="text-align: right;"><label class="label-form">Archivo: </label></td>
					<td style="text-align: left;">
						@if($ticket->documentsTickets()->count()>0)
							@foreach($ticket->documentsTickets as $document)
								<a title="{{ $document->path }}" href="{{ url('docs/tickets/'.$document->path)}}" target="_blank">{{ $document->path }}</a><br><br>
							@endforeach
						@else
							Sin archivo
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
								<b>Archivo(s) adjunto(s):</b><br>
								@if($answer->documentsTickets()->count()>0)
									@foreach($answer->documentsTickets as $document)
										<a title="{{ $document->path }}" href="{{ url('docs/tickets/'.$document->path)}}" target="_blank">{{ $document->path }}</a><br><br>
									@endforeach
								@else
									Sin archivo
								@endif
								<p style="text-align: right;">
									<b>Fecha y hora:</b> {{ date('d-M-Y H:i:s',strtotime($answer->date)) }}
								</p>
							</td>
						</tr>
					@endforeach
				@endif
				@if (count($ticket->answerTicket) == 0 && $ticket->idStatusTickets == 1)
					<tr class="show-answer" style="display: table-row;">
						<td style="vertical-align: top; text-align: right;"><label class="label-form">Respuesta: </label></td>
						<td style="text-align: left;"><textarea name="answer" class="new-input-text" rows="6"></textarea></td>
					</tr>
					<tr class="show-answer" style="display: table-row;">
						<td style="text-align: right;"><label class="label-form">Archivo adjunto (opcional)</label></td>
						<td style="text-align: left;">
							<div id="documents"></div>
							<center>
								<button type="button" name="addDoc" id="addDoc"><div class="btn_plus">+</div> Agregar documento</button>
							</center>
						</td>
					</tr>
				@endif
				@if (count($ticket->answerTicket) >= 1 && $ticket->idStatusTickets == 1)
					<tr class="show-answer" style="display: table-row;">
						<td style="vertical-align: top; text-align: right;"><label class="label-form">Respuesta: </label></td>
						<td style="text-align: left;"><textarea name="answer" class="new-input-text" rows="6"></textarea></td>
					</tr>
					<tr class="show-answer" style="display: table-row;">
						<td style="text-align: right;"><label class="label-form">Archivo adjunto (opcional)</label></td>
						<td style="text-align: left;">
							<div id="documents"></div>
							<center>
								<button type="button" name="addDoc" id="addDoc"><div class="btn_plus">+</div> Agregar documento</button>
							</center>
						</td>
					</tr>
				@endif
				@if (count($ticket->answerTicket) >= 1 && ($ticket->idStatusTickets == 2 || $ticket->idStatusTickets == 3))
					@if ($ticket->idStatusTickets == 1 || $ticket->idStatusTickets == 2 || $ticket->idStatusTickets == 3)
						<tr>
							<td style="text-align: right;">
								<label class="label-form">¿Resolvió su problema?</label>
							</td>
							<td style="text-align: left;">
								<br>
								<input type="radio" name="status" id="no" value="1">
								<label for="no">No</label> 
								<input type="radio" name="status" id="si" value="2">
								<label for="si">Sí</label>
								<br><br>
							</td>
						</tr>
						<tr class="show-answer" style="display: none;">
							<td style="vertical-align: top; text-align: right;"><label class="label-form">Respuesta: </label></td>
							<td style="text-align: left;"><textarea name="answer" class="new-input-text" rows="6"></textarea></td>
						</tr>
						<tr class="show-answer" style="display: none;">
							<td style="text-align: right;"><label class="label-form">Archivo adjunto (opcional)</label></td>
							<td style="text-align: left;">
								<div id="documents"></div>
								<center>
									<button type="button" name="addDoc" id="addDoc"><div class="btn_plus">+</div> Agregar documento</button>
								</center>
							</td>
						</tr>
					@endif
				@endif
			</tbody>
		</table>
		<br>
		<center>
			@if ($ticket->idStatusTickets == 1 || $ticket->idStatusTickets == 2 || $ticket->idStatusTickets == 3)
				<input type="submit" name="save" class="btn btn-red" value="RESPONDER">
				<a 
						@if(isset($option_id)) 
							href="{{ url(App\Module::find($option_id)->url) }}" 
						@else 
							href="{{ url(App\Module::find($child_id)->url) }}" 
						@endif 
					><button class="btn" type="button">REGRESAR</button></a>
			@endif
		</center>
		<br><br>
		@if ($ticket->idStatusTickets == 4)
			<center>
				<input type="submit" name="save" class="btn btn-red" value="REABRIR" formaction="{{ route('tickets.reopen',$ticket->idTickets) }}">
				<a 
					@if(isset($option_id)) 
						href="{{ url(App\Module::find($option_id)->url) }}" 
					@else 
						href="{{ url(App\Module::find($child_id)->url) }}" 
					@endif 
				><button class="btn" type="button">REGRESAR</button></a>
			</center>
		@endif
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
	@if (count($ticket->answerTicket) >= 1 && ($ticket->idStatusTickets == 2 || $ticket->idStatusTickets == 3))
		@if ($ticket->idStatusTickets == 1 || $ticket->idStatusTickets == 2 || $ticket->idStatusTickets == 3)
			$.validate(
			{
				form		: '#container-alta',
				onSuccess	: function($form)
				{
					status = $('input[name="status"]').is(':checked');
					if(status == "false")
					{
						swal('', 'Debe seleccionar si resolvió o no su problema', 'error');
						return false;
					}
					else
					{
						swal({
							icon: '{{ url('images/load.gif') }}',
							button: false,
							closeOnClickOutside: false,
							closeOnEsc: false
						});
						return true;
					}
				}
			});
		@endif
	@endif
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
 	})
 	.on('click','#addDoc',function()
	{
		newdoc	= $('<div class="docs-p" style="width: 85%;"></div>')
					.append($('<div class="docs-p-l"></div>')
						.append($('<div class="uploader-content"></div>')
							.append($('<input type="file" name="path" class="input-text pathActioner">'))	
						)
						.append($('<input type="hidden" name="realPath[]" class="path">')
							)
					)
					.append($('<div class="docs-p-r"></div>')
						.append($('<button class="delete-doc" type="button"><span class="icon-x delete-span"></span></button>')
						)
					);
		$('#documents').append(newdoc);
	})
	.on('click','.delete-doc',function()
	{
		swal(
		{
			icon	: '{{ url('images/load.gif') }}',
			button	: false
		});
		actioner		= $(this);
		uploadedName	= $(this).parent('.docs-p-r').siblings('.docs-p-l').children('input[name="realPath[]"]');
		formData		= new FormData();
		formData.append(uploadedName.attr('name'),uploadedName.val());
		$.ajax(
		{
			type		: 'post',
			url			: '{{ url("/tickets/upload") }}',
			data		: formData,
			contentType	: false,
			processData	: false,
			success		: function(r)
			{
				swal.close();
				actioner.parent('.docs-p-r').parent('.docs-p').remove();
			},
			error		: function()
			{
				swal.close();
				actioner.parent('.docs-p-r').parent('.docs-p').remove();
			}
		});
		$(this).parents('div.docs-p').remove();
	})
	.on('change','.input-text.pathActioner',function(e)
	{
		filename		= $(this);
		uploadedName 	= $(this).parent('.uploader-content').siblings('input[name="realPath[]"]');
		extention		= /\.jpg|\.jpeg|\.png|\.doc|\.docx|\.ppt|\.pptx|\.xls|\.xlsx|\.zip|\.pdf/i;
		
		if (this.files[0].size>315621376)
		{
			swal('', 'El tamaño máximo de su archivo no debe ser mayor a 300Mb', 'warning');
		}
		else
		{
			$(this).css('visibility','hidden').parent('.uploader-content').addClass('loading').removeClass(function (index, css)
			{
				return (css.match (/\bimage_\S+/g) || []).join(' '); // removes anything that starts with "image_"
			});
			formData	= new FormData();
			formData.append(filename.attr('name'), filename.prop("files")[0]);
			formData.append(uploadedName.attr('name'),uploadedName.val());
			$.ajax(
			{
				type		: 'post',
				url			: '{{ url("/tickets/upload") }}',
				data		: formData,
				contentType	: false,
				processData	: false,
				success		: function(r)
				{
					if(r.error=='DONE')
					{
						$(e.currentTarget).removeAttr('style').parent('.uploader-content').removeClass('loading').addClass('image_'+r.extention);
						$(e.currentTarget).parent('.uploader-content').siblings('input[name="realPath[]"]').val(r.path);
					}
					else
					{
						swal('',r.message, 'error');
						$(e.currentTarget).removeAttr('style').parent('.uploader-content').removeClass('loading');
						$(e.currentTarget).val('');
						$(e.currentTarget).parent('.uploader-content').siblings('input[name="realPath[]"]').val('');
					}
				},
				error: function()
				{
					swal('', 'Ocurrió un error durante la carga del archivo, intente de nuevo, por favor', 'error');
					$(e.currentTarget).removeAttr('style').parent('.uploader-content').removeClass('loading');
					$(e.currentTarget).val('');
					$(e.currentTarget).parent('.uploader-content').siblings('input[name="realPath[]"]').val('');
				}
			})
		}
	});
	 @if(isset($alert)) 
      {!! $alert !!} 
    @endif 
</script>
@endsection