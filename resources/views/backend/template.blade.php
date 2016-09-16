@extends('layouts.backend')

@section('menu')
  <bootstrap-navmenu :items="items"></bootstrap-navmenu>
@endsection

@section('article')
    <header>
        <h1>@yield('title', 'Leomaradan.com')</h1>
    </header>
    <section>
        @yield('content')
    </section>
@endsection