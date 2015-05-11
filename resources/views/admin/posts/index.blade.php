@extends('admin.template')

@section('content')

@include('admin.index_template', [
	'section_title' => (isset($filter)) ? $filter : 'Tout les articles',
	'add_url' => route(config('routes.admin._').'.'.config('routes.admin.blog').'.create'),
	'add_title' => 'Ajouter un article',
	'definitions' => [
		'title' => 'Titre',
		'category_name' => 'Catégorie',
		'tags_list' => 'Tag',
		'published_at' => 'Date publication'
	],
	'edit_link' => config('routes.admin._').'.'.config('routes.admin.blog').'.edit',
	'destroy_link' => config('routes.admin._').'.'.config('routes.admin.blog').'.destroy',
	'destroy_key' => 'title',
	'elements' => $posts
])
@stop