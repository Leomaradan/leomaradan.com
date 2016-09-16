@extends('backend.template')

@section('content')

<h1>{{ $section_title }}</h1>

@include('layouts.backend_flash')
@include('layouts.backend_errors')

<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				@foreach($definitions as $k => $v)
					@if(is_array($v))
						<th>{{ $v['title'] }}</th>
					@else
						<th>{{ $v }}</th>
					@endif				
				@endforeach
				<th></th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			<collection view-url="" edit-url="" update-url="" destroy-url="" definitions="{{$definitions}}"></collection>
			@if(isset($form))
				{!! Form::open(['url' => $form_url]) !!}
				<tr>
					@foreach($form as $k => $v)
						<td><input type="{{ $v }}" name="{{ $k }}" value=""></td>
					@endforeach

					@for($i = 0; $i < count($definitions) - count($form) + 1; $i++)
						<td></td>
					@endfor
					<td><button class="btn btn-success">Ajouter</button></td>
				</tr>
				{!! Form::close() !!}
			@endif
		</tbody>
	</table>
</div>

@if(isset($add_url))
<a href="{{ $add_url }}"  class="btn btn-success">{{ $add_title }}</a>
@endif

{!! $elements->render() !!}
@stop