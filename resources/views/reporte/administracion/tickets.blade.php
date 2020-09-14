@extends('layouts.child_module')
@section('data')
<div id="container-cambio" class="div-search">
	<center>
		<strong>BUSCAR TICKETS</strong>
	</center>
	<div class="divisor">
		<div class="gray-divisor"></div>
		<div class="orange-divisor"></div>
		<div class="gray-divisor"></div>
	</div>
	<center>
		{!! Form::open(['route' => 'report.tickets.excel', 'method' => 'GET', 'id'=>'formsearch']) !!}
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
				@php
					$idSection = [];
					foreach(Auth::user()->inReview as $review)
					{ 
						$idSection[] = $review->idsectionTickets; 
					}

					$sections 	= App\SectionTickets::orderName()->whereIn('idsectionTickets',$idSection)->get();
				@endphp
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
			</div>
		</center>
	<center>
		<button class="btn 	btn-search send" type="submit" title="Buscar"><span class="icon-search"></span> Exportar</button> 
	</center>
	{!! Form::close() !!}
	<br><br>
</div>

<br>
<div id="table-return">
	
</div>

<div id="myModal" class="modal">

</div>
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
		$('input[name="id"]').numeric(false);
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
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});

	$(document).on('click','.detail', function()
	{

		$folio = $(this).parents('tr').find('.folio').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/tickets/detail") }}',
			data : {'folio':$folio},
			success : function(data)
			{
				$('#myModal').show().html(data);
				//$('#detail').slideDown().html(data);
				//$('#table-purchase').slideUp();
				$('.detail').attr('disabled','disabled');
			}
		})
	})
	.on('click','.exit',function()
	{
		$('#detail').slideUp();
		$('#myModal').hide();
		$('.detail').removeAttr('disabled');
	});
	
	@if(isset($alert)) 
		{!! $alert !!} 
	@endif 
</script> 
@endsection


