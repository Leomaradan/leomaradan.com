@extends('templates.bootstrap')

@section('menu')
        <li><a href="{{ url(config('routes.admin._').'/') }}">Admin</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Blog <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.blog').'.create') }}">Ajouter un article</a></li>          	
            <li><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.blog').'.index') }}">Liste des articles</a></li>
			<li class="divider"></li>
            <li><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.category').'.index') }}">Liste des catégories</a></li>
            <li class="divider"></li>
            <li><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.tag').'.index') }}">Liste des tags</a></li>
          </ul>         
        </li>
        <li class="dropdown">     
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Comptes <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.user').'.create') }}">Ajouter un compte</a></li>           
            <li><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.user').'.index') }}">Liste des comptes</a></li>
          </ul> 
      </li>
@endsection

@section('article')
    <header>
        <h1>@yield('title', 'Laravel')</h1>
    </header>
    <section>
        @yield('content')
    </section>
@endsection