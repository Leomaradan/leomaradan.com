@section('content')

	

	@include('templates.flash_bootstrap')
	@include('templates.errors_bootstrap')

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
	<link href="{{ asset('css/bootstrap/bootstrap-markdown.min.css') }}" rel="stylesheet"></link>
	<link href="{{ asset('css/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"></link>
	<link href="{{ asset('css/jquery-ui/bootstrap-theme.css') }}" rel="stylesheet"></link>
	<link href="{{ asset('css/jquery-ui/jquery-ui-timepicker-addon.css') }}" rel="stylesheet"></link>
	<link href="{{ asset('css/tag-basic-style.css') }}" rel="stylesheet"></link>
@stop

@section('scripts')
	<script src="{{ asset('js/lib/markdown.js') }}"></script>
	<script src="{{ asset('js/lib/to-markdown.js') }}"></script>
	<script src="{{ asset('js/bootstrap/bootstrap-markdown.js') }}"></script>
	<script src="{{ asset('js/jquery/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('js/jquery/jquery-ui-timepicker-addon.js') }}"></script>
	<script src="{{ asset('js/plugins/tagging.min.js') }}"></script>
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