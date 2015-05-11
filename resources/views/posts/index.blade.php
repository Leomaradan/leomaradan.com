@extends('posts.template')

@section('content')
	@foreach($posts as $post)
	@include('posts.post', [
		'titre' => $post->title,
		'contenu' => $post->lead,
		'date' => '8 mai 2015',
		'url' => route(config('routes.blog').'.show', $post),
	])
	@endforeach
@stop

{!! $posts->render() !!}