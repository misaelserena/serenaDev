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