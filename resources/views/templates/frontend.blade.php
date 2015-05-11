<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="author" content="Léo Maradan">
    <link rel="icon" href="../../favicon.ico">

    <title>@yield('title', 'Léo Maradan')</title>


    <link rel="stylesheet" href="{{ asset('css/front/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front/blog.min.css') }}">
    @yield('styles')
    <!-- Bootstrap core CSS -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="blog-masthead navbar navbar-fixed-top">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="#">Blog</a>
          <a class="blog-nav-item" href="#">Liens</a>
          <a class="blog-nav-item" href="#">Photos</a>
          <a class="blog-nav-item" href="#">Projets</a>
        </nav>
      </div>
    </div>

    <div class="container page-main">

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

    </div><!-- /.container -->

    <footer class="blog-footer">
      <p>Leomaradan.com par Léo Maradan</p>
      <p>template basé sur celui de <a href="https://twitter.com/mdo">@mdo</a></p>
      <p>
        <a href="#">Ne cliquez pas ici</a>
      </p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>
    @yield('scripts')    
  </body>
</html>