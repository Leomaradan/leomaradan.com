@extends('posts.template')

@section('content')
	<h1>{{ $post->title }}</h1>
	<p>{!! Markdown::convertToHtml($post->content) !!}</p>
	@include('posts.post', [
		'titre' => $post->title,
		'contenu' => $post->content,
		'date' => '8 mai 2015'
	])

@stop

