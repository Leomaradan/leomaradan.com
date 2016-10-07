@extends('frontend.site')

@section('content')
<div class="content Masonry">
    <main>
        {!! ($page->markdown == 1) ? Markdown::convertToHtml($page->content) : $page->content !!}
    </main>
</div>
@stop

@section('scripts')
<script src="{{ asset('js/lib/jquery.plugins.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {    
        $('main').masonry({
          itemSelector: '.Box'/*,
          columnWidth: 400*/
        });
    });
</script>
@stop