@extends(is_null($page->layout) ? 'frontend.pages.template' : $page->layout)

@section('main')
    <div class="grid-sizer"></div>
    @foreach($gallery->images() as $image)
        <div class="grid-item">
          <img src="{{ $image->image }}" />
        </div>
    @endforeach
@stop