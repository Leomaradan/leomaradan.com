@extends('frontend.site')

@section('content')
<div class="content Masonry">
    <main>
        @yield('main')
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
            @elseif ($item['type'] == 'gallery')
                <masonry-box image="{{ $item['elem']->coverThumbnail }}" link="{{ route('gallery.show',$item['elem']) }}"><h1>{{ $item['elem']->title }}</h1></masonry-box>
            @elseif ($item['type'] == 'image')
                <masonry-box class="fancybox" image="{{ $item['elem']->thumbnail }}" link="{{ $item['elem']->image }}" image-alt="{{ $item['elem']->description }}"><h1>{{ $item['elem']->description }}</h1></masonry-box>
            @endif
        @endforeach
        <template v-for="box in infiniteScrollData">
            <masonry-box class="lazy-loaded"
                          v-bind:is-fancybox="box.isFancybox"
                          v-bind:is-post="box.isPost" 
                          v-bind:is-link="box.isLink" 
                          v-bind:image="box.image" 
                          v-bind:image-alt="box.title"
                          v-bind:link="box.link" 
                          v-bind:link-label="box.linkLabel" 
                          v-bind:link-target="box.linkTarget">@{{{ box.content }}}</masonry-box>
        </template>        
            
        </div>
    </main>
</div>
@stop

@section('scripts')
<script src="{{ asset('js/lib/jquery.plugins.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {    
        var $grid = $('main .BoxContainer').masonry({
            fitWidth: true,
          itemSelector: '.Box',
          columnWidth: 300
        });
        
        $(".fancybox a").fancybox({
            beforeShow : function() {
                var alt = this.element.find('img').attr('alt');

                this.inner.find('img').attr('alt', alt);

                this.title = alt;
            }            
        });
     
        
        /*$grid.imagesLoaded().progress( function(e) {
            console.log(e);
            //$grid.masonry('layout');
        });  */ 

        app.infiniteScrollCallback = function() {
            $('main .BoxContainer').imagesLoaded( function(e) {
                console.log(e);
                app.infiniteScrollInProgress = false;
                $grid.masonry('reloadItems');
                $('main .BoxContainer').masonry('layout');
                
                $(".lazy-loaded.fancybox a").fancybox({
                    beforeShow : function() {
                        var alt = this.element.find('img').attr('alt');

                        this.inner.find('img').attr('alt', alt);

                        this.title = alt;
                    }            
                });                
                //$grid.masonry( 'addItems', $('main .BoxContainer .lazy-loaded'));
                $('main .BoxContainer .lazy-loaded').removeClass('lazy-loaded');
            });  
        };
        app.infiniteScrollUrl = {!! isset($infiniteScrollUrl) ? "'$infiniteScrollUrl'" : 'null' !!};
        
        if(app.infiniteScrollUrl !== null) {
            $('main .BoxContainer').addClass('InfinitScroll');
        }
        
    });
</script>
@stop