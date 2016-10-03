<article itemscope itemtype="http://schema.org/BlogPosting">
        <section class="image">
            <time itemprop="dateCreated" datetime="{{ $dateISO }}">{{ $date }}</time>
            <div class="cover" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                    <img src="{{ $image_src }}" itemprop="contentUrl" alt="{{ $image_description }}">
            </div>
        </section>   
        <section class="Post Card">

            <h1 itemprop="name">{{ $title }}</h1>
            <span itemprop="author">{{ $author }}</span>

            <span class="TagsCloud">
                @foreach($tags as $tag)
                <a href="{{ route($tag_route, $tag) }}">{{ $tag->name }}</a>
                @endforeach
            </span>
            <span class="category"><a href="{{ route($category_route, $category) }}" rel="tag">{{ $category }}</a></span>

            <div itemprop="text">
                {!! Markdown::convertToHtml($content) !!}
            </div>
            @if(isset($url))
            <a href="{{ $url }}" class="HighlightLink" itemprop="url" rel="bookmark">Lire la suite</a>
            @endif

            @if(isset($disqus))
                @include('frontend.disqus', $disqus)
            @endif                    
    </section>         
</article>