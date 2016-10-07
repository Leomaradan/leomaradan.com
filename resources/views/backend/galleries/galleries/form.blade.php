@section('content')

	@include('layouts.backend_flash')
	@include('layouts.backend_errors')

	{!! Form::model($gallery, $form) !!}
		<div class="form-group">
			{!! Form::label('title', 'Titre') !!}
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('description', 'URL') !!}
			{!! Form::text('description', null, ['class' => 'form-control']) !!}
		</div>	
        
                <div class="form-group">
        		{!! Form::label('public', 'Public ?') !!}
                        {!! Form::checkbox('public', '1') !!}
                </div>

		<button class="btn btn-primary">Sauver</button>		

	{!! Form::close() !!}
@stop