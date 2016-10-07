@section('content')

	

	@include('layouts.backend_flash')
	@include('layouts.backend_errors')

	{!! Form::model($page, $form) !!}
		<div class="form-group">
			{!! Form::label('title', 'Titre') !!}
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('slug', 'URL') !!}
			{!! Form::text('slug', null, ['class' => 'form-control']) !!}
		</div>	
        
                <div class="form-group">
        		{!! Form::label('layout', 'Layout') !!}
                        {!! Form::select('layout', [
                            null => '---', 
                            'frontend.pages.template' => 'Page', 
                            'frontend.pages.bloglayout' => 'Blog',
                            'frontend.pages.masonrylayout' => 'Masonry'
                        ], null, ['class' => 'form-control combobox']); !!}
                </div>

		<div class="form-group">
			{!! Form::label('content', 'Contenu') !!}
			{!! Form::textarea('content', null, ['class' => 'form-control', 'data-provide' => 'markdown', 'rows' => '10']) !!}
		</div>									

		<button class="btn btn-primary">Sauver</button>		

	{!! Form::close() !!}
@stop

@section('styles')
	<link href="{{ asset('css/lib/markdown.css') }}" rel="stylesheet"></link>
	<link href="{{ asset('css/lib/jquery-ui.css') }}" rel="stylesheet"></link>   
@stop

@section('scripts')
	<script src="{{ asset('js/lib/markdown.js') }}"></script>
	<script src="{{ asset('js/lib/jquery-ui.js') }}"></script>
	<script type="text/javascript">
        $(document).ready(function(){
          $('.combobox').combobox();
        });        
        </script>
@stop