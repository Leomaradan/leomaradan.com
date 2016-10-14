@extends('frontend.site')

@section('content')
<div class="content Masonry">
    <main>
        <div class="BoxContainer">
        @foreach ($data as $item)
            @if ($item['type'] == 'post')
                <masonry-box is-post="true" image="{{ isset($item['elem']->image) ? asset('uploads/blog/' . $item['elem']->image) : '' }}" link="{{ route('blog.show', $item['elem']) }}">
                    <h1>{{ $item['elem']->title }}</h1>
                    {!! Markdown::convertToHtml($item['elem']->lead) !!}
                </masonry-box>
            @elseif ($item['type'] == 'tweet')
                <masonry-box is-link="true" link="https://twitter.com/{{ $item['elem']->user_id }}/status/{{ $item['elem']->id_twitter }}" link-label="Tweet" link-target="_blank">{!! $item['elem']->text  !!}</masonry-box>
            @elseif ($item['type'] == 'link')
            <masonry-box is-link="true" link="{{ route('link.permalink', $item['elem']) }}" link-label="permalink" link-target="_blank"><h1>{!! $item['elem']->title !!}</h1><p>{!! $item['elem']->description  !!}</p></masonry-box>
            @elseif ($item['type'] == 'image')
                <masonry-box image="{{ isset($item['elem']->coverSrc) ? $item['elem']->coverSrc : '' }}" link="{{ isset($item['elem']->flickr_id) ? 'https://www.flickr.com/photos/leomaradan/albums/' . $item['elem']->flickr_id : '' }}" link-target="_blank"><h1>{{ $item['elem']->title }}</h1></masonry-box>
            @endif
        @endforeach
            
        </div>
    </main>
</div>
@stop

@section('scripts')
<script src="{{ asset('js/lib/jquery.plugins.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {    
        $('main .BoxContainer').masonry({
            fitWidth: true,
          itemSelector: '.Box'/*,
          columnWidth: 400*/
        });
    });
</script>
@stop