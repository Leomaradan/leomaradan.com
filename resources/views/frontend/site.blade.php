@extends('layouts.frontend')

@section('styles')

@endsection

@section('menu')
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Page</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Liens</a></li>
            <li><a href="#">Gallerie</a></li>
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