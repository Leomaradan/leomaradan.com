@extends('backend.template')

@section('content')

@include('backend.index_template', [
	'section_title' => 'Tout les liens',
	'definitions' => [
		'title' => 'Titre',
		'url' => 'URL',
                'description' => 'Description',
                'permalink' => ['title' => 'Permalien', 'type' => 'readonly']               
	],
	'update_link' => 'admin.links.update',
	'destroy_link' => 'admin.links.destroy',
	'destroy_key' => 'permalink',
	'form' => [
		'title' => 'text',
		'url' => 'text',
                'description' => 'text'
	],
	'form_url' => route('admin.links.store'),
	'elements' => $links
])

@stop