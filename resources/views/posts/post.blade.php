@section('content')    
@parent    
          <div class="blog-post">
            <h2 class="blog-post-title">{{ $titre }}</h2>
            <p class="blog-post-meta">le {{ $date }} par <a href="#">Léo</a></p>

			{!! Markdown::convertToHtml($contenu) !!}
			
			@if(isset($url))
			<p><a href="{{ $url }}">Lire la suite</a></p>			
			@endif
          </div>
@stop