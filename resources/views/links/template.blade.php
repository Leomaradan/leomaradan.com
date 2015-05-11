@extends('templates.responsive')

@section('title', trans('link.sitename'))

@section('header')
    <h1 class="title"><a href=".">@yield('title')</a></h1>
    <nav>
        <ul>
            <li><a href="{{ route(Config::get('routes.link').'.create') }}">{{ trans('link.shortlink') }}</a></li>
            <li><a href="{{ route(Config::get('routes.link').'.about') }}">{{ trans('link.about') }}</a></li>
        </ul>
    </nav>
@endsection               

@section('article')
    <header>
        <h1>@yield('page_title', trans('link.default_title'))</h1>
    </header>
    <section>
        @yield('content')
    </section>
@endsection

@section('sidebar')
    <aside>
        <h3>{{ trans('link.presentation_title') }}</h3>
        <p>{{ trans('link.presentation') }}</p>
    </aside>
@endsection