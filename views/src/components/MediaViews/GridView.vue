<template>
	<div>
		<sort-bar :options="options" v-if="true == 0"/>
		<comp-view v-if="allFiles.length > 0" :files="allFiles" :folders="ScreenMediaIOData.folders" :dataLoad="allFilesLoaded"/>
		<div v-else>No Files Uploaded</div>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex';
	import SortBar from './partials/GridView/Bar/SortBar';
	import View from './partials/GridView/View/View';

	export default {
		computed: {
			...mapGetters({
				allFiles: 'allFiles',
				allFilesLoaded: 'allFilesLoaded',
			}),
		},
		components: {
			compView: View,
			SortBar
		},
		data() {
			return {
				options: [
					{label: 'Field 1', value: 'field_1'},
					{label: 'Field 2', value: 'field_2'},
					{label: 'Field 3', value: 'field_3'},
				],
				ScreenMediaIOData: this.mockMediaData()
			};
		},

		mounted() {
			this.$store.dispatch('getFiles');
		},
		methods: {
			mockMediaData() {
				const data = {
					folders: [],
					files: []
				};
				// let mock folder data
				for (let i = 0; i < 0; i++) {
					data.folders.push({
						id: i + 141,
						name: 'Media Folder' + i,
						type: 'folder'
					})
				}
				return data;
			},
			getRandomArbitrary(min, max) {
				return Math.random() * (max - min) + min;
			}
		}
	}
</script>


<style type="postcss" scoped>

</style>
