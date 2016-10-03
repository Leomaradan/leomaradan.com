@section('main')    
@parent    

    @if($image)
    	@include('layouts.components.blogpost_cover', [
		'image_description' => "Image d'illustration de $title",
		'image_src' => asset('uploads/blog/' . $image),
		'author' => 'Léo',
		'tag_route' => 'blog.tag',
                'category_route' => 'blog.category'
	])
    @else
    	@include('layouts.components.blogpost', [
		'author' => 'Léo',
		'tag_route' => 'blog.tag',
                'category_route' => 'blog.category'
	])
    @endif
@stop