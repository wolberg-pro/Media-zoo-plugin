<template>
	<div v-if="dataLoad">
		<div class="grid grid-cols-4 grid-flow-row-dense">
			<view-item :type="'folder'" v-for="item in folders" v-bind:key="item.id" :item="item"/>
			<view-item :type="'file'" v-for="item in files" v-bind:key="item.id" :item="item"/>
		</div>

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
