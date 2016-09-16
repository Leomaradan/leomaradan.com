<template>
	<tr v-for="item in items" data-id="{{ item.id }}">
		<td v-for="value in definitions">
			{{ value }}
		</td>

		<td v-if="view_url"><a href="{{ view_url }}/{{ item.id }}" class="btn btn-primary">Voir</a></td>

		<td v-if="edit_url"><a href="{{ edit_url }}/{{ item.id }}" class="btn btn-primary">Editer</a></td>

		
		<td v-if="update_url" ><a href="{{ update_url }}/{{ item.id }}" data-precall="get_table_element" data-id="{{ item.id }}" data-callback="jsonp.update_element" data-method="put" class="rest-link btn btn-primary">Sauver</a></td>
						
		<td><a href="{{url}}/{{item.id}}" data-callback="jsonp.delete_element" data-method="delete" class="rest-link rest-link-confirm btn btn-danger" data-confirm="Supprimer {{ item.title }} ?">Supprimer</a></td>
	</tr>
</template>

<script>

	export default {

		name: 'Collection',

		props: {
			items: Array,
			view_url: String,
			edit_url: String,
			update_url: String,
			destroy_url: String,
			definitions: Array
		},

		data () {
			return {
				item: []
			}
		}
	}
</script>