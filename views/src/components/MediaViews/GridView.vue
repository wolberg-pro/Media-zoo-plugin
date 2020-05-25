<template>
	<div>
		<sort-bar :options="options" v-if="true == 0"/>
		<comp-view v-if="allFiles.length > 0" :files="allFiles" :folders="allFolders" :dataLoad="allFilesLoaded"/>
		<div v-else>No Files Uploaded</div>

		<el-dialog title="Preview File" width="80%" center destroy-on-close	:visible.sync="previewLoaded"  @close="onDisplayPreviewClose()">
			<preview-image :items="previewFiles"/>
		</el-dialog>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex';
	import SortBar from './partials/GridView/Bar/SortBar';
	import View from './partials/GridView/View/View';
	import PreviewImage from './partials/GridView/View/PreviewImage';

	export default {
		computed: {
			...mapGetters({
				allFiles: 'allFiles',
				allFolders: 'allFolders',
				previewLoaded: 'previewLoaded',
				previewFiles: 'perviewFiles',
				allFilesLoaded: 'allFilesLoaded',
			}),
		},
		components: {
			compView: View,
			PreviewImage,
			SortBar
		},
		data() {
			return {
				options: [
					{label: 'Field 1', value: 'field_1'},
					{label: 'Field 2', value: 'field_2'},
					{label: 'Field 3', value: 'field_3'},
				]
			};
		},

		mounted() {
			this.$store.dispatch('getFiles');
		},
		methods: {
			onDisplayPreview(item) {
				this.image_files = this.files.filter(val => val.file_mine_type.toLowerCase().indexOf('image') != -1 && item.id != val.id);
				this.image_files.unshift(item);
				console.log(this.image_files );
				this.dialogPreview = true;
			},
			onDisplayPreviewClose(){
				this.$store.dispatch('stopPreview');
			}
		}
	}
</script>


<style type="postcss" scoped>

</style>
