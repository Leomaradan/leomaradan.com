@if(Session::has('success'))
	<alert type="success">{{ Session::get('success') }}</alert>
@endif
<alert type="success" v-for="success in successes" style="display: none" dismissable>
	<ul v-if="Array.isArray(success)">
		<li v-for="success-line in success">@{{ success-line }}</li>
	</ul>
	<p v-else>@{{ success }}</p>
</alert>
