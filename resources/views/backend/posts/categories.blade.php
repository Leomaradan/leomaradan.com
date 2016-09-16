@extends('backend.template')

@section('content')

@include('backend.index_template', [
	'section_title' => 'Toutes les catégories',
	'definitions' => [
		'name' => 'Titre',
		'slug' => 'URL',
		'null' => 'Utilisations'
	],
	'view_link' => 'admin.posts.categories.show',
	'update_link' => 'admin.posts.categories.update',
	'destroy_link' => 'admin.posts.categories.destroy',
	'destroy_key' => 'name',
	'form' => [
		'name' => 'text',
		'slug' => 'text'
	],
	'form_url' => route('admin.posts.categories.store'),
	'elements' => $categories
])

@stop