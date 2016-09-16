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
			{!! Form::label('content', 'Contenu') !!}
			{!! Form::textarea('content', null, ['class' => 'form-control', 'data-provide' => 'markdown', 'rows' => '10']) !!}
		</div>									

		<button class="btn btn-primary">Sauver</button>		

	{!! Form::close() !!}
@stop

@section('styles')
	<link href="{{ asset('css/bootstrap/bootstrap-markdown.min.css') }}" rel="stylesheet"></link>
@stop

@section('scripts')
	<script src="{{ asset('js/lib/markdown.js') }}"></script>
	<script src="{{ asset('js/lib/to-markdown.js') }}"></script>
	<script src="{{ asset('js/bootstrap/bootstrap-markdown.js') }}"></script>
@stop