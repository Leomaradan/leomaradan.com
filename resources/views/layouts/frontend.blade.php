<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="author" content="Léo Maradan">
    <link rel="icon" href="../../favicon.ico">
    @yield('meta')

    <title>@yield('title', 'Léo Maradan')</title>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|Source+Serif+Pro" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
    <!-- Bootstrap core CSS -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <header class="HorizontaleMenu">

        @yield('menu')
    </header>
    <div class="HorizontaleMenu-Background"></div>      


    <div class="wrapper">
      @yield('wrapper')
    </div><!-- /.wrapper -->

    @yield('footer')

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>    
    <script src="{{ asset('js/lib/jquery.js') }}"></script>    
    <script src="{{ asset('js/lib.js') }}"></script>  
    <script src="{{ asset('js/app.js') }}"></script>


    @yield('scripts')    
  </body>
</html>