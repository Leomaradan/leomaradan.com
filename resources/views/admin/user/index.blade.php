@extends('admin.template')
 
@section('content')

@include('admin.index_template', [
    'section_title' => 'Tout les comptes',
    'add_url' => route(config('routes.admin._').'.'.config('routes.admin.user').'.create'),
    'add_title' => 'Ajouter un compte',    
    'definitions' => [
        'name' => 'Nom',
        'email' => 'E-Mail',
        'status' => ['title' => 'Status', 'type' => 'enum', 'data' => [
                'inactive' => 'Inactif', 
                'user' => 'Utilisateur', 
                'moderator' => 'Modérateur', 
                'admin' => 'Admin'
            ]]
    ],
    'edit_link' => config('routes.admin._').'.'.config('routes.admin.user').'.edit',
    'destroy_link' => config('routes.admin._').'.'.config('routes.admin.user').'.destroy',
    'destroy_key' => 'name',
    'elements' => $users
])

@stop