@extends('links.template')

@section('page_title', trans('link.showurl_title'))

@section('content')
	{{ trans('link.showurl') }} <a href="{{ route(Config::get('routes.url').'.show', $link) }}">{{ route(Config::get('routes.url').'.show', $link) }}</a>
@stop