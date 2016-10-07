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
				@if(isset($view_link))
                                    <th></th>
				@endif
				@if(isset($edit_link))
                                    <th></th>
				@endif
				@if(isset($update_link))
                                    <th></th>
				@endif	
                                @if(isset($destroy_link))
                                    <th></th>
                                @endif
			</tr>
		</thead>
	
		<tbody>
			@foreach ($elements as $element)
			<tr data-id="{{ $element->id }}">
				@foreach($definitions as $k => $v)
					@if($k !== 'null')
						@if(is_array($v))
							<td>@include('layouts.backend_formater', 
							['type' => $v['type'], 'value' => $element->$k, 'data' => (isset($v['data']) ? $v['data'] : null), 'editable' => isset($update_link)])</td>
						@else
							@if(isset($update_link))
								<td><input type="text" name="{{ $k }}" value="{{ $element->$k }}" class="inline-edit"></td>
							@else
								<td>{{ $element->$k }}</td>
							@endif
						@endif
					@endif
				@endforeach
				@if(isset($view_link))
					@if(isset($view_link_modal))
					<td><a href="#" data-src="{{ route($view_link, $element) }}" class="modal-link btn btn-primary" data-toggle="modal" data-target="#modal_link_frame">Voir</a></td>
					@else
					<td><a href="{{ route($view_link, $element) }}" class="btn btn-primary">Voir</a></td>
					@endif
				@endif
				@if(isset($edit_link))
					<td><a href="{{ route($edit_link, $element) }}" class="btn btn-primary">{{ $edit_label or 'Editer' }}</a></td>
				@endif
				@if(isset($update_link))
					<td><a href="{{ route($update_link, $element) }}" data-precall="get_table_element" data-id="{{ $element->id }}" data-callback="jsonp.update_element" data-method="put" data-token="{{ csrf_token() }}" class="rest-link btn btn-primary">{{ $update_label or 'Sauver' }}</a></td>
				@endif	
                                @if(isset($destroy_link))
				<td><a href="{{ route($destroy_link, $element) }}" data-callback="jsonp.delete_element" data-method="delete" data-token="{{ csrf_token() }}" class="rest-link rest-link-confirm btn btn-danger" data-confirm="Supprimer {{ $element->$destroy_key }} ?">Supprimer</a></td>
                                @endif
			</tr>
			@endforeach
			@if(isset($form))
				{!! Form::open(['url' => $form_url]) !!}
				<tr>
					@foreach($form as $k => $v)
						<td><input type="{{ $v }}" name="{{ $k }}" value="" placeholder="{{ $definitions[$k] }}"></td>
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

<div class="modal fade" id="modal_link_frame" tabindex="-1" role="dialog"  aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
     <div class="modal-body">
          <iframe frameborder="0"></iframe>
     </div>
    </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@if(isset($add_url))
<a href="{{ $add_url }}"  class="btn btn-success">{{ $add_title }}</a>
@endif

@if(!is_array($elements))
{!! $elements->render() !!}
@endif
@stop