@extends('admin.template')

@section('content')

@include('admin.index_template', [
	'section_title' => 'Tout les tags',
	'definitions' => [
		'name' => 'Titre',
		'slug' => 'URL',
		'null' => 'Utilisations'
	],
	'view_link' => config('routes.admin._').'.'.config('routes.admin.tag').'.show',
	'update_link' => config('routes.admin._').'.'.config('routes.admin.tag').'.update',
	'destroy_link' => config('routes.admin._').'.'.config('routes.admin.tag').'.destroy',
	'destroy_key' => 'name',
	'form' => [
		'name' => 'text',
		'slug' => 'text'
	],
	'form_url' => route(config('routes.admin._').'.'.config('routes.admin.tag').'.store'),
	'elements' => $tags
])

@stop

@section('nothing')


<h1>old</h1>

@include('templates.flash_bootstrap')
@include('templates.errors_bootstrap')

<table class="table">
	<tr>
		<th>Titre</th>
		<th>URL</th>
		<th>Utilisations</th>
		<th></th>
		<th></th>
	</tr>
@foreach ($tags as $tag)
	<tr data-id="{{ $tag->id }}">
		<td><input type="text" name="name" value="{{ $tag->name }}"></td>
		<td><input type="text" name="slug" value="{{ $tag->slug }}"></td>
		<td><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.tag').'.show', $tag) }}" class="btn btn-info">Voir</a></td>
		<td><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.tag').'.update', $tag) }}" data-precall="get_table_element" data-id="{{ $tag->id }}" data-callback="jsonp.update_element" data-method="put" data-token="{{ csrf_token() }}" class="rest-link btn btn-primary">Sauver</a></td>
		<td><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.tag').'.destroy', $tag) }}" data-callback="jsonp.delete_element" data-method="delete" data-token="{{ csrf_token() }}" class="rest-link rest-link-confirm btn btn-danger" data-confirm="Supprimer {{ $tag->name }} ?">Supprimer</a></td>
	</tr>
@endforeach
	{!! Form::open() !!}
	<tr>
		<td><input type="text" name="name" value=""></td>
		<td><input type="text" name="slug" value=""></td>
		<td></td>
		<td></td>
		<td><button class="btn btn-success">Ajouter</button></td>
	</tr>
	{!! Form::close() !!}
</table>
{!! $tags->render() !!}
@stop