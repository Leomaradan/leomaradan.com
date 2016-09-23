@extends('frontend.pages.template')

@section('content')
<div class="content">
    <main>
        <article itemscope itemtype="http://schema.org/Article">
            <h1 itemprop="name">{{ $page->title }}</h1>

            <div itemprop="text">{!! Markdown::convertToHtml($page->content) !!}</div>
        </article>
    </main>
</div>
@stop