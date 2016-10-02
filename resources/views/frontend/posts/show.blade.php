@extends('frontend.posts.template')

@section('main')
	@include('frontend.posts.post', [
		'title' => $post->title,
		'content' => $post->content,
		'image' => $post->image,		
		'date' => $post->published_at->formatLocalized('%A %e %B %Y, à %k:%M'),		
                'dateISO' => $post->published_at->toIso8601String(),
                'tags' => $post->tags,

		'disqus' => [
			'id' => $post->slug,
			'url' => route('blog.show', $post),
                        'title' => $post->title
		]
	])

@stop