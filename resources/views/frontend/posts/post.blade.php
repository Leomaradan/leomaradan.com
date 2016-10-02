@section('main')    
@parent    

    <article itemscope itemtype="http://schema.org/BlogPosting">

        @if ($image) 
            <section class="image">
                <time itemprop="dateCreated" datetime="2012-11-20T20:00">{{ $date }}</time>
                <div class="cover" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                        <img src="{{ asset('uploads/blog/' . $image) }}" itemprop="contentUrl" alt="Image d'illustration de {{ $title }}">
                </div>
            </section>   
            <section class="Post Card">
        @else
            <section class="Post">
                <time itemprop="dateCreated" datetime="2012-11-20T20:00">{{ $date }}</time>
        @endif
        
                <h1 itemprop="name">{{ $title }}</h1>
                <span itemprop="author">Léo</span>

                <span class="TagsCloud">
                    @foreach($tags as $tag)
                    <a href="{{ route('blog.tag', $tag) }}">{{ $tag->name }}</a>
                    @endforeach
                </span>
                <span class="category"><a href="#" rel="tag">Tag1</a></span>

                <div itemprop="text">
                    {!! Markdown::convertToHtml($content) !!}
                </div>
                @if(isset($url))
                <a href="{{ $url }}" itemprop="url" rel="bookmark">Lire la suite</a>
                @endif

                @if(isset($disqus))
                    @include('frontend.disqus', $disqus)
                @endif                    
        </section>         
    </article>
@stop