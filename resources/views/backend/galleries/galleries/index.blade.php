@extends('backend.template')

@section('content')

@include('backend.index_template', [
	'section_title' => 'Toutes les galleries',
	'add_url' => route('admin.galleries.create'),
	'add_title' => 'Ajouter une gallerie',
	'definitions' => [
		'title' => 'Titre',
		'coverSrc' => ['title' => 'Couverture', 'type' => 'image'],
                'public' => ['title' => 'Public ?', 'type' => 'boolean']
	],
	//'view_link' => 'admin.galleries.view',
	//'view_link_modal' => true,
	'edit_link' => 'admin.galleries.edit',
	'destroy_link' => 'admin.galleries.destroy',
	'destroy_key' => 'title',
	'elements' => $galleries
])
@stop