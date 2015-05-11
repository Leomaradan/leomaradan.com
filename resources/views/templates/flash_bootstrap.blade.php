@if(Session::has('success'))
	<div class="alert alert-success">
		{{ Session::get('success') }}
	</div>
@endif
<div class="success" data-surround-element="div" data-surround-class="alert alert-success"></div>