@extends('backend.template')

@section('content')

<h1>Tout les menus</h1>

@include('layouts.backend_flash')
@include('layouts.backend_errors')

<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
                            <th>Zones</th>
			</tr>
		</thead>
                <tbody>
                    @foreach($zones as $zone)
                        <tr>
                            <td><a href="{{ route('admin.menus.edit', $zone) }}">{{ ucfirst($zone) }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
@stop