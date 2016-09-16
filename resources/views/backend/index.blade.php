@extends('backend.template')

@section('content')

<h1>Administration</h1>

<list-menu :items="items"></list-menu>

@include('layouts.backend_flash')
@include('layouts.backend_errors')

@stop