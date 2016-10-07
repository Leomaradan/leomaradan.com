@extends('frontend.posts.template')

@section('main')
<template v-for="post in posts">
    <blog-posting :title="post.title" :author="post.author" :image="post.image" :image-caption="post.imageCaption" :date="post.date" :url="post.url" :tags="post.tags" :category="post.category">@{{{ post.content }}}</blog-posting>
</template>
<script>
    var posts = [
	@foreach($posts as $post)
        {!! json_encode([
            'title' => $post->title,
            'author' => 'Léo',
            'image' => isset($post->image) ? asset('uploads/blog/' . $post->image) : null,
            'imageCaption' => 'Image d\'illustration de '. $post->title,
            'date' => $post->published_at->formatLocalized('%A %e %B %Y, à %k:%M'),
            'url' => route('blog.show', $post),
            'tags' => [],
            'category' => '',
            'content' => Markdown::convertToHtml($post->lead)                
        ]) !!},
	@endforeach
        ];
        </script>
@stop

@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {    
            app.posts = posts;
    });
</script>
@endsection