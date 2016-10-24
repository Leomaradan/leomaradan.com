<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <base href="{{ url('/') }}">

    <title>@yield('title', config('app.name'))</title>

  <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/backend.css') }}">
  @yield('styles')

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="@yield('appurl', url('/'))">@yield('appname', config('app.name'))</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            @yield('menu')
            <li>
                <a href="{{ url('/admin/logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>                
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">

      <div class="starter-template" style="padding-top: 100px">


        @yield('content')

      </div>

    </div><!-- /.container -->

    <script src="{{ asset('js/lib/jquery.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.js') }}"></script>
    <script src="{{ asset('js/lib.js') }}"></script>
    <script src="{{ asset('js/backend.js') }}?v=2"></script>
    @yield('scripts')
  </body>
</html>