@extends('frontend.site')

@section('content')
    <div class="content">
        <main>
            <article itemscope itemtype="http://schema.org/Article">
                <h1 itemprop="name">{{ $page->title }}</h1>

                <div itemprop="text">{!! ($page->markdown == 1) ? Markdown::convertToHtml($page->content) : $page->content !!}</div>
            </article>
        </main>
    </div>
@endsection