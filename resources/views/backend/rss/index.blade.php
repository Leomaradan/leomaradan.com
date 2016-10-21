@extends('backend.template')

@section('content')

@include('backend.index_template', [
	'section_title' => 'Tout les flux rss',
	'definitions' => [
		'title' => 'Titre',
		'url' => 'URL',
                'category' => 'Catégorie'
	],
	'update_link' => 'admin.rss.update',
	'destroy_link' => 'admin.rss.destroy',
	'destroy_key' => 'title',
	'form' => [
		'title' => 'text',
		'url' => 'text',
                'category' => 'text'
	],
	'form_url' => route('admin.rss.store'),        
	'elements' => $fluxes
])
@stop