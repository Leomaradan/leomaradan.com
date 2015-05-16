@extends('posts.template')

@section('content')
	@include('posts.post', [
		'titre' => $post->title,
		'contenu' => $post->content,
		'image' => $post->image,		
		'date' => $post->published_at->formatLocalized('%A %e %B %Y, à %k:%M'),
		'disqus' => [
			'id' => $post->slug,
			'url' => route(config('routes.blog').'.show', $post)
		]
	])

@stop

