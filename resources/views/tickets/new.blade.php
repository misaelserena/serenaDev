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
	{!! Form::open(['route' => 'tickets.new.save', 'method' => 'POST','id'=>'container-alta','files'=>true]) !!}
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th colspan="2">NUEVO TICKET</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<label class="label-form">Sección</label>
						</td>
						<td>
							<p>
								<select class="custom-select" name="section" data-validation="required">
									<option></option>
									@foreach(App\SectionTickets::orderName()->get() as $section)
										<option value="{{ $section->idsectionTickets}}"> {{ $section->section}} </option>
									@endforeach
								</select>
								<br>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<label class="label-form">Tipo de ticket</label>
						</td>
						<td>
							<p>
								<select class="custom-select" name="type" data-validation="required">
									<option></option>
									@foreach(App\TicketType::orderName()->get() as $type)
										<option value="{{ $type->idTypeTickets}}"> {{ $type->type}} </option>
									@endforeach
								</select>
								<br>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<label class="label-form">Prioridad</label>
						</td>
						<td>
							<p>
								<select class="custom-select removeselect" name="priority" data-validation="required">
									<option></option>
									@foreach(App\TicketPriority::orderName()->get() as $priority)
										<option value="{{ $priority->idPriorityTickets}}"> {{ $priority->priority}} </option>
									@endforeach
								</select>
								<br>
							</p>
						</td>
					</tr>
					<tr>
						<td width="20%">
							<label class="label-form">Asunto:</label>
						</td>
						<td width="80%">
							<p>
								<input type="text" id="subject" name="subject" class="new-input-text" name="subject" placeholder="Asunto" data-validation="required">
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<label class="label-form">Mensaje:</label>
						</td>
						<td>
							<textarea class="new-input-text" name="question" rows="4" placeholder="Escriba aquí..." data-validation="required"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<label class="label-form">Archivo adjunto (opcional)</label>
						</td>
						<td>
							<div id="documents"></div>
							<p>
								<button type="button" name="addDoc" id="addDoc"><div class="btn_plus">+</div> Agregar documento</button>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<center>
			<input type="submit" name="save" class="btn btn-red" value="ENVIAR">
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
		modules : 'file',
		form: '#container-alta',
		onError   : function($form)
		{
			swal('', 'Por favor llene todos los campos que son obligatorios.', 'error');
		},
		onSuccess : function($form)
		{
			
			swal({
				icon: '{{ url('images/load.gif') }}',
				button: false,
				closeOnClickOutside: false,
				closeOnEsc: false
			});
			return true;
		}
	});
	$(document).ready(function()
	{
		$('.js-types').select2(
		{
			placeholder				: 'Tipo',
			allowClear				: false,
			language				: "es",
			maximumSelectionLength	: 1
		});
		$('.js-priority').select2(
		{
			placeholder				: 'Prioridad',
			allowClear				: false,
			language				: "es",
			maximumSelectionLength	: 1
		});
		$('.js-sections').select2(
		{
			placeholder				: 'Sección',
			allowClear				: false,
			language				: "es",
			maximumSelectionLength	: 1
		});
		$(document).on('click','#addDoc',function()
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
	});
	 @if(isset($alert)) 
      {!! $alert !!} 
    @endif 
</script>
@endsection