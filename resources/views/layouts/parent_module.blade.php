@extends('layouts.layout')
@section('title', $title)
@section('content')
	<br>
	<div class="container-blocks-all">
		<div class="title-config">
			<h1>{{ $title }}</h1>
		</div>
		<i style="color: #B1B1B1">{{ $details }}</i>
		<hr>
		@if(Auth::user()->module->where('father',$id)->where('category','!=',NULL)->count()>0)
			@php
				$categoryModule	= '';
			@endphp
			<div class="container-blocks-category">
				@foreach(Auth::user()->module->where('father',$id)->where('category','!=',NULL)->sortBy(function($item) {return $item->itemOrder.' '.$item->category.'-'.$item->name;}) as $key)
					@if($key['category'] != '' && $categoryModule != $key['category'])
						@php
							$categoryModule	= $key['category'];
						@endphp
						<h2>{{$categoryModule}}</h2>
						<hr>
					@endif
					<a class="btn btn-father" href="{{ url($key['url']) }}">{{ $key['name'] }}</a>
				@endforeach
			</div>
		@endif
		@if(Auth::user()->module->where('father',$id)->where('category',NULL)->count()>0)
			<div class="container-blocks">
				@foreach(Auth::user()->module->where('father',$id)->where('category',NULL)->sortBy(function($item) {return $item->itemOrder.' '.$item->name;}) as $module)
					<a class="btn btn-father" href="{{ url($module['url']) }}">{{ $module['name'] }}</a>
				@endforeach
			</div>
		@endif
	</div>
@endsection
