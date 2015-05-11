@section('content')

	@include('templates.flash_bootstrap')
	@include('templates.errors_bootstrap')

	{!! Form::model($user, $form) !!}
		<div class="form-group">
			{!! Form::label('name', 'Nom') !!}
			{!! Form::text('name', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('email', 'E-Mail') !!}
			{!! Form::email('email', null, ['class' => 'form-control']) !!}
		</div>	

		<div class="form-group">
			{!! Form::label('password', 'Mot de passe') !!}
			{!! Form::password('password', ['class' => 'form-control']) !!}
		</div>	

		<div class="form-group">
			<label>
				{!! Form::checkbox('admin', 1, $user->admin) !!} Admin ?
			</label>		
		</div>									

		<button class="btn btn-primary">Sauver</button>		

	{!! Form::close() !!}
@stop