@extends('backend.template')

@section('content')
<div class="flexbox">
    <aside>
        <span class="highlight" data-value="{{$highlight}}"></span>
        @foreach($categories as $category_name => $fluxes)
        <a href="{{ route('admin.rss.read.category',$fluxes[0]['id']) }}" data-category="">{{ $category_name }}</a>
        <ul>
            @foreach($fluxes as $flux)
                <li><a href="{{ $flux['link'] }}">{{ $flux['title'] }}</a></li>
            @endforeach
        </ul>
        @endforeach
    </aside>
    <section class="scrollable">
        {{ $articles->links() }}
        @foreach($articles as $article)
        <article>
            <h1>{{$article->title}}</h1>
            <div>{!! $article->description !!}</div>
            <span class="article_info"><time>{{$article->published_at->format('j-F-Y')}}</time>  <a href="{{$article->link}}" target="_blank">{{$article->link}}</a></span>
        </article>
        @endforeach
        {{ $articles->links() }}
    </section>
</div>
@stop

@section('scripts')
<script>
    $(document).ready(function() {
        var link = $('.highlight').data('value');
        
        $('a[href="'+link+'"]').css('font-weight','bold');
    });
</script>
@endsection