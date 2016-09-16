<template>
	<li v-for="item in items" v-bind:class="{ 'dropdown': item.submenu }">
		<a v-if="!item.submenu" href="{{item.href}}">{{item.name}}</a>
		<template v-if="item.submenu">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{item.name}} <span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li v-for="subitem in item.submenu" v-bind:class="{ 'divider': subitem.divider }">
					<a href="{{subitem.href}}">{{subitem.name}}</a>
				</li>
			</ul>
		</template>		
	</li>
</template>

<script>

	export default {

		name: 'Bootstrap-Navmenu',

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