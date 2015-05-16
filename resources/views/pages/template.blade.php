@extends('templates.site')

@section('article')
    <header>
        <h1>@yield('title', 'Léo Maradan')</h1>
    </header>
    <section>
        @yield('content')
    </section>
@endsection