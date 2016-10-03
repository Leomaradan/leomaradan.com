@extends('backend.template')

@section('content')

<h1>Administration</h1>

<list-menu :items="currentMenu"></list-menu>

@include('layouts.backend_flash')
@include('layouts.backend_errors')

@stop

@section('scripts')
	<script type="text/javascript">
            isAdminHome = true;
	</script>
@stop