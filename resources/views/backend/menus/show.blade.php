@extends('backend.template')

@section('content')

<h1>Menus "{{$zone}}"</h1>

<a href="{{ route('admin.menus.edit', $zone) }}" class="btn btn-primary">Editer</a>

<list-menu :items="currentMenu"></list-menu>
@stop  

@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {    
            app.currentMenu = {!! json_encode($menus) !!};
    });
</script>
@endsection