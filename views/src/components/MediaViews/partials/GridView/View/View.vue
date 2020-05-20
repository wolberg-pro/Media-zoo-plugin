<template>
	<div class="grid grid-rows-6 grid-flow-col sm:grid-flow-row md:grid-flow-col-dense lg:grid-flow-row-dense xl:grid-flow-col">
		<view-item v-for="item in data" :item="item" />
	</div>
</template>

<script>
	import ViewItem from "./ViewItem";
	export default {
		components: {ViewItem},
		props: ['data'],
		data() {
			return {
				value: null
			}
		}
	}
</script>


<style type="postcss" scoped>
</style>
