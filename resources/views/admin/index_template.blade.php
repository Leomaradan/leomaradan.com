@extends('admin.template')

@section('content')

<h1>{{ $section_title }}</h1>

@include('templates.flash_bootstrap')
@include('templates.errors_bootstrap')

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
	@foreach ($elements as $element)
		<tbody>
			<tr data-id="{{ $element->id }}">
				@foreach($definitions as $k => $v)
					@if($k !== 'null')
						@if(is_array($v))
							<td>@include('templates.format_bootstrap', ['type' => $v['type'], 'value' => $element->$k, 'data' => $v['data']])</td>
						@else
							<td>{{ $element->$k }}</td>
						@endif
					@endif
				@endforeach
				@if(isset($view_link))
					<td><a href="{{ route($view_link, $element) }}" class="btn btn-primary">Voir</a></td>
				@endif
				@if(isset($edit_link))
					<td><a href="{{ route($edit_link, $element) }}" class="btn btn-primary">Editer</a></td>
				@endif
				@if(isset($update_link))
					<td><a href="{{ route($update_link, $element) }}" data-precall="get_table_element" data-id="{{ $element->id }}" data-callback="jsonp.update_element" data-method="put" data-token="{{ csrf_token() }}" class="rest-link btn btn-primary">Sauver</a></td>
				@endif		
				<td><a href="{{ route($destroy_link, $element) }}" data-callback="jsonp.delete_element" data-method="delete" data-token="{{ csrf_token() }}" class="rest-link rest-link-confirm btn btn-danger" data-confirm="Supprimer {{ $element->$destroy_key }} ?">Supprimer</a></td>
			</tr>
			@endforeach
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