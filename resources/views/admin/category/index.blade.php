@extends('admin.template')

@section('content')

@include('admin.index_template', [
	'section_title' => 'Toutes les catégories',
	'definitions' => [
		'name' => 'Titre',
		'slug' => 'URL',
		'null' => 'Utilisations'
	],
	'view_link' => config('routes.admin._').'.'.config('routes.admin.category').'.show',
	'update_link' => config('routes.admin._').'.'.config('routes.admin.category').'.update',
	'destroy_link' => config('routes.admin._').'.'.config('routes.admin.category').'.destroy',
	'destroy_key' => 'name',
	'form' => [
		'name' => 'text',
		'slug' => 'text'
	],
	'form_url' => route(config('routes.admin._').'.'.config('routes.admin.category').'.store'),
	'elements' => $categories
])

@stop

@section('nothing')


<h1>Toutes les catégories</h1>

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
@foreach ($categories as $category)
	<tr data-id="{{ $category->id }}">
		<td><input type="text" name="name" value="{{ $category->name }}"></td>
		<td><input type="text" name="slug" value="{{ $category->slug }}"></td>
		<td><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.category').'.show', $category) }}" class="btn btn-info">Voir</a></td>
		<td><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.category').'.update', $category) }}" data-precall="get_table_element" data-id="{{ $category->id }}" data-callback="jsonp.update_element" data-method="put" data-token="{{ csrf_token() }}" class="rest-link btn btn-primary">Sauver</a></td>
		<td><a href="{{ route(config('routes.admin._').'.'.config('routes.admin.category').'.destroy', $category) }}" data-callback="jsonp.delete_element" data-method="delete" data-token="{{ csrf_token() }}" class="rest-link rest-link-confirm btn btn-danger" data-confirm="Supprimer {{ $category->name }} ?">Supprimer</a></td>
	</tr>
@endforeach
	{!! Form::open(['url' => route(config('routes.admin._').'.'.config('routes.admin.category').'.store')]) !!}
	<tr>
		<td><input type="text" name="name" value=""></td>
		<td><input type="text" name="slug" value=""></td>
		<td></td>
		<td></td>
		<td><button class="btn btn-success">Ajouter</button></td>
	</tr>
	{!! Form::close() !!}
</table>
{!! $categories->render() !!}
@stop