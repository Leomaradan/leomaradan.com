@section('content')

	@include('layouts.backend_flash')
	@include('layouts.backend_errors')

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
			{!! Form::label('status', 'Status') !!}
			{!! Form::select('status', [
				'inactive' => 'Inactif', 
				'user' => 'Utilisateur', 
				'moderator' => 'Modérateur', 
				'admin' => 'Admin'
			], null) !!}
		</div>								

		<button class="btn btn-primary">Sauver</button>		

	{!! Form::close() !!}
@stop