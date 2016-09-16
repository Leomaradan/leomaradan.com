@extends('layouts.frontend')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/front.css') }}">
@endsection

@section('menu')
  <nav class="blog-nav">
    <a class="blog-nav-item active" href="{{ route('index') }}">Accueil</a>
    <a class="blog-nav-item" href="#">Liens</a>
    <a class="blog-nav-item" href="#">Photos</a>
    <a class="blog-nav-item" href="#">Projets</a>
  </nav>
@stop

@section('main')
@parent
      <div class="blog-header">
        <h1 class="blog-title">Léo Maradan</h1>
      </div>

      <div class="row blog-main">

          @yield('content')

      </div><!-- /.row -->
@stop

@section('footer')
    <footer class="blog-footer">
      <p>Leomaradan.com par Léo Maradan</p>
    </footer>
@stop