@extends('frontend.posts.template')

@section('main')
	@foreach($posts as $post)
	@include('frontend.posts.post', [
		'title' => $post->title,
		'content' => $post->lead,
		'image' => $post->image,
		'date' => $post->published_at->formatLocalized('%A %e %B %Y, à %k:%M'),
                'dateISO' => $post->published_at->toIso8601String(),
		'url' => route('blog.show', $post),
                'tags' => $post->tags,
                'category' => $post->category
	])
	@endforeach
@stop

{!! $posts->render() !!}