@extends('frontend.pages.template')

@section('content')
	<div class="blog-post">
		<h1 class="blog-post-title">{{ $page->title }}</h1>

		{!! Markdown::convertToHtml($page->content) !!}

	</div>
@stop