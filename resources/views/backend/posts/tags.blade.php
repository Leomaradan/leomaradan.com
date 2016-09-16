@extends('backend.template')

@section('content')

@include('backend.index_template', [
	'section_title' => 'Tout les tags',
	'definitions' => [
		'name' => 'Titre',
		'slug' => 'URL',
		'null' => 'Utilisations'
	],
	'view_link' => 'admin.posts.tags.show',
	'update_link' => 'admin.posts.tags.update',
	'destroy_link' => 'admin.posts.tags.destroy',
	'destroy_key' => 'name',
	'form' => [
		'name' => 'text',
		'slug' => 'text'
	],
	'form_url' => route('admin.posts.tags.store'),
	'elements' => $tags
])

@stop