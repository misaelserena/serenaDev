@extends('layouts.layout')
@section('title', $title)
@section('content')
	<br>
	<div class="container-blocks-all">
		<div class="title-config">
			<h1>{{ $title }}</h1>
		</div>
		<center>
			<i style="color: #B1B1B1;">{{ $details }}</i>
		</center>
		<br>
		<hr>
		<br>
		@if(Auth::user()->module->where('father',$child_id)->where('category','!=',NULL)->count()>0)
			@php
				$categoryModule	= '';
			@endphp
			<div class="container-blocks-category">
				@foreach(Auth::user()->module->where('father',$child_id)->where('category','!=',NULL)->sortBy(function($item) {return $item->itemOrder.' '.$item->category.'-'.$item->name;}) as $categItem)
					@if($categItem['category'] != '' && $categoryModule != $categItem['category'])
						@php
							$categoryModule	= $categItem['category'];
						@endphp
						<h2>{{$categoryModule}}</h2>
						<hr>
					@endif
					<a
					@if(isset($option_id) && $option_id==$categItem['id'])
						class="btn-child child-active"
					@else
						class="btn-child"
					@endif
					href="{{ url($categItem['url'].'#moduleContent') }}">{{ $categItem['name'] }}</a>
				@endforeach
			</div>
		@endif
		@if(Auth::user()->module->where('father',$child_id)->where('category',NULL)->count()>0)
			<div class="container-blocks">
				@foreach(Auth::user()->module->where('father',$child_id)->where('category',NULL)->sortBy(function($item) {return $item->itemOrder.' '.$item->name;}) as $key)
					<a
					@if(isset($option_id) && $option_id==$key['id'])
						class="btn-child child-active"
					@else
						class="btn-child"
					@endif
					href="{{ url($key['url']) }}">{{ $key['name'] }}</a>
				@endforeach
			</div>
		@endif
		<p><br><br></p>
		<div class="data-container" id="moduleContent">
			@yield('header')
			@yield('data')
			@yield('pay-form')
		</div>
	</div>
	@php
		$day	= date('j');
		$month	= '';
		switch (date('n'))
		{
			case 1:
				$month = 'enero';
				break;
			case 2:
				$month = 'febrero';
				break;
			case 3:
				$month = 'marzo';
				break;
			case 4:
				$month = 'abril';
				break;
			case 5:
				$month = 'mayo';
				break;
			case 6:
				$month = 'junio';
				break;
			case 7:
				$month = 'julio';
				break;
			case 8:
				$month = 'agosto';
				break;
			case 9:
				$month = 'septiembre';
				break;
			case 10:
				$month = 'octubre';
				break;
			case 11:
				$month = 'noviembre';
				break;
			case 12:
				$month = 'diciembre';
				break;
		}
		if(isset($_COOKIE['follow']))
		{
			$following	= json_decode(base64_decode($_COOKIE['follow']),true);
		}
		$cookieArray		= array();
		$tempArray			= array();
		$tempArray['name']	= $title;
		$tempArray['id']	= $child_id;
		$tempArray['date']	= $day.' de '.$month;
		$cookieArray[]		= $tempArray;
		if(isset($following))
		{
			foreach ($following as $key => $value)
			{
				if($value['id'] != $child_id)
				{
					$cookieArray[] = $value;
				}
				if(count($cookieArray)>4)
				{
					break;
				}
			}
		}
		$cookie	= base64_encode(json_encode($cookieArray));
		setcookie('follow',$cookie,time()+60*60*24*365,'/');
	@endphp
@endsection