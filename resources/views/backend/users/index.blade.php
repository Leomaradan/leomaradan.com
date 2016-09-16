@extends('backend.template')
 
@section('content')

@include('backend.index_template', [
    'section_title' => 'Tout les comptes',
    'add_url' => route('admin.users.create'),
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
    'edit_link' => 'admin.users.edit',
    'destroy_link' => 'admin.users.destroy',
    'destroy_key' => 'name',
    'elements' => $users
])

@stop