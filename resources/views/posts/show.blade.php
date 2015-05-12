@extends('posts.template')

@section('content')
	@include('posts.post', [
		'titre' => $post->title,
		'contenu' => $post->content,
		'date' => $post->published_at->formatLocalized('%A %e %B %Y, à %k:%M')
	])

@stop

