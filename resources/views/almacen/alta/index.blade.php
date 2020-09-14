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
		@foreach(Auth::user()->module->where('father',41)->sortBy('created_at') as $key)
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
<center>
  <input checked class="r_alta" type="radio" name="r_alta" id="r_alta" value="0">
  <label for="r_alta">Alta</label>
  <input class="r_alta" type="radio" name="r_alta" id="r_masiva" value="1">
  <label for="r_masiva">Alta masiva</label>
</center>
<br>
<br>

<div id="alta" >
  @include('almacen.alta.alta')
</div>

<div id="masiva" hidden>
  @include('almacen.alta.masiva')
</div>

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/jquery.numeric.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script>

$.ajaxSetup(
{
  headers:
  {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('input[name=r_alta]').change(function(){
  

  var value = $( 'input[name=r_alta]:checked' ).val();
  if(value == 0){
    $('#alta').show();
    $('#masiva').hide();
    updateSelectsAlta();
  }
  if(value == 1){
    $('#alta').hide();
    $('#masiva').show();
    updateSelectsAlta();
  }
});

</script>

<script>

$.validate(
{
  form: '#container-alta',
  modules		: 'security',
  onSuccess : function($form)
  {
    path = $('.path').val();
    total = parseFloat($('input[name="total"]').val());
    total_articles = parseFloat($('input[name="total_articles"]').val());
    countbody = $('#body tr').length;
    if(total_articles == "" || countbody <= 0)
    {
      swal({
        title: "Error",
        text: "Debe agregar mínimo un artículo.",
        icon: "error",
        buttons: 
        {
          confirm: true,
        },
      });
      return false;
    }
    else if (total_articles > total || total_articles < total)
    {
      swal({
        title: "Error",
        text: "La inversión de artículos no coincide con el monto del ticket/factura.",
        icon: "error",
        buttons: 
        {
          confirm: true,
        },
      });
      return false;
    }
    else if (path == undefined || path == "") 
    {
      swal({
        title: "Error",
        text: "Debe agregar al menos un ticket de compra.",
        icon: "error",
        buttons: 
        {
          confirm: true,
        },
      });
      return false;
    }
    else
    {
      return true;
    }
  }
});
</script>

@include('almacen.alta.scripts_alta')
@include('almacen.alta.scripts_masiva')
<script>
  updateSelectsAlta();
</script>
@endsection

@endsection