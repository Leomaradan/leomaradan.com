@extends('admin.template')
 
@section('content')

@include('admin.index_template', [
    'section_title' => 'Tout les comptes',
    'add_url' => route(config('routes.admin._').'.'.config('routes.admin.user').'.create'),
    'add_title' => 'Ajouter un compte',    
    'definitions' => [
        'name' => 'Nom',
        'email' => 'E-Mail',
        'admin' => ['title' => 'Admin ?', 'type' => 'boolean']
    ],
    'edit_link' => config('routes.admin._').'.'.config('routes.admin.user').'.edit',
    'destroy_link' => config('routes.admin._').'.'.config('routes.admin.user').'.destroy',
    'destroy_key' => 'name',
    'elements' => $users
])

@stop