<template>
	<template v-for="item in items">
		<h2 v-if="!item.submenu">
		<a href="{{item.href}}">{{item.title}}</a></h2>
		<template v-if="item.submenu">
			<h2>{{item.title}}</h2>
			<ul>
				<li v-for="subitem in item.submenu" v-if="!subitem.divider">
					<a href="{{subitem.href}}">{{subitem.title}}</a>
				</li>
			</ul>
		</template>		
	</template>
</template>

<script>

	export default {

		name: 'List-Menu',

		props: {
			items: Array
		},

		data () {
			return {
				item: []
			}
		}
	}
</script>