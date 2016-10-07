@extends('frontend.site')

@section('content')
<div class="content Masonry">
    <main>
        <div class="BoxContainer">
        @foreach ($recent as $item)
            @if ($item['type'] == 'post')
                <masonry-box is-post="true" image="{{ isset($item['elem']->image) ? asset('uploads/blog/' . $item['elem']->image) : '' }}" link="{{ route('blog.show', $item['elem']) }}">
                    <h1>{{ $item['elem']->title }}</h1>
                    {!! Markdown::convertToHtml($item['elem']->lead) !!}
                </masonry-box>
            @elseif ($item['type'] == 'tweet')
                <masonry-box is-tweet="true" link="">{{ $item['elem']->text }}</masonry-box>
            @elseif ($item['type'] == 'image')
            <masonry-box image="{{ isset($item['elem']->coverSrc) ? $item['elem']->coverSrc : '' }}"><h1>{{ $item['elem']->title }}</h1></masonry-box>
            @endif
        @endforeach
        
        @foreach ($old as $item)
            @if ($item['type'] == 'post')
                <masonry-box is-post="true" image="{{ isset($item['elem']->image) ? asset('uploads/blog/' . $item['elem']->image) : '' }}" link="{{ route('blog.show', $item['elem']) }}">
                    <h1>{{ $item['elem']->title }}</h1>
                    {!! Markdown::convertToHtml($item['elem']->lead) !!}
                </masonry-box>
            @elseif ($item['type'] == 'tweet')
                <masonry-box is-tweet="true" link="">{!! $item['elem']->text !!}</masonry-box>
            @elseif ($item['type'] == 'image')
            <masonry-box image="{{ isset($item['elem']->coverSrc) ? $item['elem']->coverSrc : '' }}"><h1>{{ $item['elem']->title }}</h1></masonry-box>
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