@extends('frontend.pages.dashboard')

@section('main')
<article>
    <h1>{{ $gallery->title }}</h1>
    <p>{{ $gallery->description }}</p>
    <a class="HighlightLink" href="{{ route('gallery.index') }}">Retour aux galleries</a>
</article>
@stop

