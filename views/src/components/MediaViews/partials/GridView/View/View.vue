<template>
	<div v-if="dataLoad">
		<div class="grid grid-cols-4 grid-flow-row-dense">
			<view-item :type="'folder'" v-for="item in folders" v-bind:key="item.id" :item="item"/>
			<view-item :type="'file'" v-for="item in files" v-bind:key="item.id" :item="item"/>
		</div>

		<el-dialog title="Preview File" :visible.sync="dialogPreview">
			<preview-image :items="image_files"/>
		</el-dialog>
	</div>
	<Loader v-else/>

</template>

<script>
	import ViewItem from "./ViewItem";
	import PreviewImage from "./PreviewImage";
	import Loader from "../../../../partials/Loader.vue";

	export default {
		created() {
			this.$on('start_preview', function(item){
				this.image_files =[];
				this.onDisplayPreview(item)
			});
		},
		data() {
			return {
				dialogPreview: false,
				image_files: []
			};
		},
		methods: {
			onDisplayPreview(item) {
				this.image_files = this.files.filter(val => val.file_mine_type.toLowerCase().indexOf('image') != -1 && item.id != val.id);
				this.image_files.unshift(item);
				console.log(this.image_files );
				this.dialogPreview = true;
			}
		},
		components: {
			ViewItem,
			PreviewImage,
			Loader
		},
		props: ['files', 'folders', "dataLoad"],
	}
</script>


<style type="postcss" scoped>
</style>
