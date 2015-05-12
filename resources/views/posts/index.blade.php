@extends('posts.template')

@section('content')
	@foreach($posts as $post)
	@include('posts.post', [
		'titre' => $post->title,
		'contenu' => $post->lead,
		'date' => $post->published_at->formatLocalized('%A %e %B %Y, à %k:%M'),
		'url' => route(config('routes.blog').'.show', $post),
	])
	@endforeach
@stop

{!! $posts->render() !!}