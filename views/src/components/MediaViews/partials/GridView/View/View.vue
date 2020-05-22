<template>
	<div v-if="dataLoad">
		<div class="grid grid-cols-4 grid-flow-row-dense" style="overflow:auto">
			<view-item v-for="item in folders" v-bind:key="item.id" :item="item"/>
			<view-item v-for="item in files" v-bind:key="item.id" :item="item"/>
		</div>+
	</div>
	<Loader v-else/>
</template>

<script>
	import ViewItem from "./ViewItem";
	import Loader from "../../../../partials/Loader.vue";

	export default {
		components: {
			ViewItem,
			Loader
		},
		props: ['files', 'folders', "dataLoad"],
	}
</script>


<style type="postcss" scoped>
</style>
