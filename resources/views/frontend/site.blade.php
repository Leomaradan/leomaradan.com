@extends('layouts.frontend')

@section('styles')

@endsection

@section('menu')
    <nav>
	<div class="HorizontaleMenu-ResponsiveIcon"></div>
	<input type="checkbox" class="HorizontaleMenu-ResponsiveToggle">	        
        <ul>
            @foreach(App\Models\Menu::getMenu('main') as $menu)
                <li><a href="{{ $menu['href'] }}">{{ $menu['title'] }}</a></li>
            @endforeach
        </ul>
    </nav>
@stop

@section('wrapper')
@parent
    <div class="SiteHeader">
            <div class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('img/cover.jpg') }}" data-z-index="10"></div>
            <h1>Léo Maradan</h1>
    </div>


          @yield('content')

@stop