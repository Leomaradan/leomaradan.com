@extends('admin.template')

@section('content')

@include('admin.index_template', [
	'section_title' => 'Toutes les pages',
	'add_url' => route(config('routes.admin._').'.'.config('routes.admin.pages').'.create'),
	'add_title' => 'Ajouter une page',
	'definitions' => [
		'title' => 'Titre',
		'slug' => 'URL'
	],
	'edit_link' => config('routes.admin._').'.'.config('routes.admin.pages').'.edit',
	'destroy_link' => config('routes.admin._').'.'.config('routes.admin.pages').'.destroy',
	'destroy_key' => 'title',
	'elements' => $pages
])
@stop