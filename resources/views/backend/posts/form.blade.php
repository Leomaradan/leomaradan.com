@section('content')

	@include('layouts.backend_flash')
	@include('layouts.backend_errors')

	{!! Form::model($post, $form) !!}
		<div class="form-group">
			{!! Form::label('title', 'Titre') !!}
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('slug', 'URL') !!}
			{!! Form::text('slug', null, ['class' => 'form-control']) !!}
		</div>	

		<div class="form-group">
			{!! Form::label('category', 'Catégorie') !!}
			{!! Form::text('category', ($post->category) ? $post->category->name : null, ['class' => 'form-control autocomplete', 'data-autocomplete-list' => $categories]) !!}
		</div>	

		<div class="form-group">
			{!! Form::label('lead', 'Chapô') !!}
			{!! Form::textarea('lead', null, ['class' => 'form-control', 'data-provide' => 'markdown', 'rows' => '10']) !!}
		</div>	

		<div class="form-group">
			{!! Form::label('image', 'Image de titre') !!}
			@if($post->image)
			<br><div class="thumbnail"><img src='{{ asset('images/blog/' . $post->image) }}'></div>
			@endif
			{!! Form::file('image') !!}
		</div>	

		<div class="form-group">
			{!! Form::label('content', 'Contenu') !!}
			{!! Form::textarea('content', null, ['class' => 'form-control', 'data-provide' => 'markdown', 'rows' => '10']) !!}
		</div>		

		<div class="form-group">
			
			{!! Form::label('tags_list', 'Tag') !!}
			<div data-tags-input-name="tags_list" class="tagBox form-control">{{ $post->tags_list }}</div>
				
		</div>	

		<div class="form-group">
			{!! Form::label('published_at', 'Date publication') !!}
			{!! Form::text('published_at', null, ['class' => 'form-control datetimepicker']) !!}			
		</div>									

		<button class="btn btn-primary">Sauver</button>		

	{!! Form::close() !!}
@stop

@section('styles')
	<link href="{{ asset('css/lib/markdown.css') }}" rel="stylesheet"></link>
	<link href="{{ asset('css/lib/jquery-ui.css') }}" rel="stylesheet"></link>
	<link href="{{ asset('css/lib/jquery.plugins.css') }}" rel="stylesheet"></link>
@stop

@section('scripts')
	<script src="{{ asset('js/lib/markdown.js') }}"></script>
	<script src="{{ asset('js/lib/jquery-ui.js') }}"></script>
	<script src="{{ asset('js/lib/jquery.plugins.js') }}"></script>
	<script type="text/javascript">
	$(function() {

		$(".tagBox").tagging({
    		"no-duplicate": true,
    		"no-duplicate-callback": window.alert,
    		"no-duplicate-text": "Duplicate tags",
    		"type-zone-class": "type-zone",
    		"tag-box-class": "tagging",
    		"pre-tags-separator": " ",
    		"forbidden-chars": [",", ".", "_", "?", " "]
		});

		$( ".autocomplete" ).each(function() {
			var elements = $(this).data("autocomplete-list");
			$(this).autocomplete({
				source: elements.split(',')
			});
		});

		$('.datetimepicker').datetimepicker();
	    	
	});  
	</script>
@stop