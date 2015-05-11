<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <title>@yield('title', 'Laravel')</title>
        
        <meta name="author" content="Léo Maradan">
        
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="{{ asset('css/responsive/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive/main.css') }}">
        @yield('styles')

        <!--[if lt IE 9]>
            <script src="{{ asset('js/vendor/html5-3.6-respond-1.1.0.min.js') }}"></script>
        <![endif]-->
    </head>
    <body>

        <div class="header-container">
            <header class="wrapper clearfix">
                @yield('header')
            </header>
        </div>

        <div class="main-container">
            <div class="main wrapper clearfix">
                <article>
                    @yield('article')
                </article>
                        
                @yield('sidebar')       

            </div> <!-- #main -->
        </div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper">
                <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png" /></a><div id="footer-cctext"><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">@yield('project', 'Web Site')</span> by <span xmlns:cc="http://creativecommons.org/ns#" property="cc:attributionName">Léo Maradan</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</div>
            </footer>
        </div>

        <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>

        @yield('scripts')
    </body>
</html>