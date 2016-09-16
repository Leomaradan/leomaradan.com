@extends('backend.template')

@section('content')

@include('backend.index_template', [
	'section_title' => (isset($filter)) ? $filter : 'Tout les articles',
	'add_url' => route('admin.posts.create'),
	'add_title' => 'Ajouter un article',
	'definitions' => [
		'title' => 'Titre',
		'category_name' => 'Catégorie',
		'tags_list' => 'Tag',
		'published_at' => 'Date publication'
	],
	'edit_link' => 'admin.posts.edit',
	'destroy_link' => 'admin.posts.destroy',
	'destroy_key' => 'title',
	'elements' => $posts
])
@stop