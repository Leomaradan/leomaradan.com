@extends('layouts.bootstrap.bootstrap')
@section('title')
Backend {{ config('app.name') }}
@endsection
@section('appname')
Admin
@endsection
@section('appurl')
{{ url('/admin') }}
@endsection