@extends('frontend.posts.template')

@section('main')
<template v-for="post in posts">
    <blog-posting class="SingleArticle" 
                  v-bind:title="post.title" 
                  v-bind:author="post.author" 
                  v-bind:image="post.image" 
                  v-bind:image-caption="post.imageCaption" 
                  v-bind:date="post.date" 
                  v-bind:url="post.url" 
                  v-bind:tags="post.tags" 
                  v-bind:category="post.category">@{{{ post.content }}}</blog-posting>
</template>
<script>
    var posts = [
        {!! json_encode([
            'title' => $post->title,
            'author' => 'Léo',
            'image' => isset($post->image) ? asset('uploads/blog/' . $post->image) : null,
            'imageCaption' => 'Image d\'illustration de '. $post->title,
            'date' => [
                'ISO' => $post->published_at->format('Y-m-d\TH:i:sO'),
                'localized' => $post->published_at->format('j-F-Y')
            ],
            'tags' => $post->tagsJson,
            'category' => isset($post->category) ? ['name' => $post->category->name, 'link' => route('blog.category', $post->category)] : null,
            'content' => Markdown::convertToHtml($post->content),
        ]) !!},
        ];
    //var disqus = ;
</script>
@stop

@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {    
            app.posts = posts;
    });
</script>
@endsection