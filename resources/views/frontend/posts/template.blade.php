@extends('frontend.site')

@section('sidebar')
  <div class="SidebarModule">
    <h1>A propos</h1>
    <div class="thumbnail"><img src="{{ asset('images/blog.jpg') }}"></div>
    <p>Développeur web, gamer depuis (trop?) longtemps, geek invertebré, ce modeste blog me sert à exprimer mes idées, coups de gueule et banalités du quotidien</p>
  </div>

  <div class="SidebarModule">
    <h1>Catégories</h1>
    <ul class="MenuList">
      @foreach($all_categories as $category)
      <li><a href="{{ route('blog.category', $category) }}">{{ $category->name }} <span class="Badge">{{ $category->nbUses }}</span></a></li>
      @endforeach
    </ul>
  </div>

  <div class="SidebarModule">
    <h1>Hashtags</h1>
    <ul class="TagsCloud">
      @foreach($all_tags as $tag)
      <li><a href="{{ route('blog.tag', $tag) }}">{{ $tag->name }} <span class="Badge">{{ $tag->nbUses }}</span></a></li>
      @endforeach
    </ul>
  </div> 

  <div class="SidebarModule">
    <h1>Liens</h1>
    <ul class="MenuList">
      <li><a href="https://www.youtube.com/user/leomaradan">YouTube</a></li>
      <li><a href="https://twitter.com/mcradane">Twitter</a></li>
      <li><a href="https://www.facebook.com/lmaradan">Facebook</a></li>
      <li><a href="https://github.com/Leomaradan">GitHub</a></li>
    </ul>
  </div>
@stop

@section('content')
    <div class="content BlogLayout">
        <main>
            @yield('main')
        </main>
        
        <aside>
            @yield('sidebar')
        </aside>
        

    </div>
@endsection