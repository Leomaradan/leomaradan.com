@extends('templates.frontend')

@section('meta')
<link type="application/rss+xml" rel="alternate" title="RSS - Articles" href="{{ route(config('routes.blog').'.feed') }}" />
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/front/blog.min.css') }}">
@endsection

@section('menu')
  <nav class="blog-nav">
    <a class="blog-nav-item active" href="{{ route(config('routes.blog').'.index') }}">Blog</a>
    <a class="blog-nav-item" href="#">Liens</a>
    <a class="blog-nav-item" href="#">Photos</a>
    <a class="blog-nav-item" href="#">Projets</a>
  </nav>
@stop

@section('main')
@parent
      <div class="blog-header">
        <h1 class="blog-title">Léo Maradan</h1>
        <p class="lead blog-description">Web, technologies &amp; autres joyeusetés</p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">

          @yield('content')

          <!-- <nav>
            <ul class="pager">
              <li><a href="#">Previous</a></li>
              <li><a href="#">Next</a></li>
            </ul>
          </nav> -->

        </div><!-- /.blog-main -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          @yield('sidebar')

        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->
@stop

@section('footer')
    <footer class="blog-footer">
      <p>Leomaradan.com par Léo Maradan</p>
      <p>template basé sur celui de <a href="https://twitter.com/mdo">@mdo</a></p>
      <p>
        <a href="#">Ne cliquez pas ici</a>
      </p>
    </footer>
@stop