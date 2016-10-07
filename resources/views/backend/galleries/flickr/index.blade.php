@extends('backend.template')

@section('content')

@include('backend.index_template', [
	'section_title' => 'Albums Flickr',
	'definitions' => [
		'title' => ['title' => 'Titre', 'type' => 'readonly'],
		'description' => ['title' => 'Description', 'type' => 'readonly'],
                'imported' => ['title' => 'Importé ?', 'type' => 'boolean']
	],
	'update_link' => 'admin.flickr.import',
        'update_label' => 'Importer',
	'elements' => $flickr
])
@stop