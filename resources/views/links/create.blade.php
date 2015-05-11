@extends('links.template')

@section('content')
	<form action="{{ route(Config::get('routes.link').'.store') }}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="url" name="url" placeholder="{{ trans('link.addlink') }}" class="form-control" autofocus required autocomplete="off">
		<input type="submit" class="metal">
	</form>
@stop