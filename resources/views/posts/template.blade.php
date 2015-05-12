@extends('templates.frontend')

@section('article')
    <header>
        <h1>@yield('title', 'Léo Maradan')</h1>
    </header>
    <section>
        @yield('content')
    </section>
@endsection

@section('sidebar')
  <div class="sidebar-module sidebar-module-inset">
    <h4>A propos</h4>
    <a href="#" class="thumbnail"><img src="{{ asset('images/blog.jpg') }}"></a>
    <p>Développeur web, gamer depuis (trop?) longtemps, geek invertebré, ce modeste blog me sert à exprimer mes idées, coups de gueule et banalités du quotidien</p>
  </div>
  <!--<div class="sidebar-module">
    <h4>Archives</h4>
    <ol class="list-unstyled">
      <li><a href="#">March 2014</a></li>
      <li><a href="#">February 2014</a></li>
      <li><a href="#">January 2014</a></li>
      <li><a href="#">December 2013</a></li>
      <li><a href="#">November 2013</a></li>
      <li><a href="#">October 2013</a></li>
      <li><a href="#">September 2013</a></li>
      <li><a href="#">August 2013</a></li>
      <li><a href="#">July 2013</a></li>
      <li><a href="#">June 2013</a></li>
      <li><a href="#">May 2013</a></li>
      <li><a href="#">April 2013</a></li>
    </ol>
  </div>-->
  <div class="sidebar-module">
    <h4>Catégories</h4>
    <ol class="list-unstyled">
      @foreach($categories as $category)
      	<li><a href="{{ route(config('routes.blog').'.category', $category) }}">{{ $category->name }}</a></li>
      @endforeach
    </ol>
  </div>
  <div class="sidebar-module">
    <h4>Hashtags</h4>
    <ol class="list-unstyled in-block">
      @foreach($tags as $tag)
      	<li><a href="{{ route(config('routes.blog').'.tag', $tag) }}">#{{ $tag->name }}</a></li>
      @endforeach
    </ol>
  </div> 
  <div class="sidebar-module">
    <h4>Liens</h4>
    <ol class="list-unstyled">
      <li><a href="https://www.youtube.com/user/leomaradan">YouTube</a></li>
      <li><a href="https://twitter.com/mcradane">Twitter</a></li>
      <li><a href="https://www.facebook.com/lmaradan">Facebook</a></li>
      <li><a href="https://github.com/Leomaradan">GitHub</a></li>
    </ol>
  </div>
@stop