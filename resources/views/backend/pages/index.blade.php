@extends('backend.template')

@section('content')

@include('backend.index_template', [
	'section_title' => 'Toutes les pages',
	'add_url' => route('admin.pages.create'),
	'add_title' => 'Ajouter une page',
	'definitions' => [
		'title' => 'Titre',
		'slug' => 'URL'
	],
	'view_link' => 'pages',
	'view_link_modal' => true,
	'edit_link' => 'admin.pages.edit',
	'destroy_link' => 'admin.pages.destroy',
	'destroy_key' => 'title',
	'elements' => $pages
])
@stop