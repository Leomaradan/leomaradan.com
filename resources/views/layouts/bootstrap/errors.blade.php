@if($errors->any())
	@foreach($errors->all() as $error)
	<alert type="danger" style="display: none">{{ $error }}</alert>
	@endforeach
@endif
<alert type="danger" v-for="error in errors" style="display: none" dismissable>
	<ul v-if="Array.isArray(error)">
		<li v-for="error-line in error">@{{ error-line }}</li>
	</ul>
	<p v-else>@{{ error }}</p>
</alert>