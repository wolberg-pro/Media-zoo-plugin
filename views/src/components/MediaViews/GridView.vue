<template>
	<div>
		<sort-bar :options="options"/>
		<comp-view :data="ScreenMediaIOData"/>
	</div>
</template>

<script>
	import SortBar from './partials/GridView/Bar/SortBar';
	import View from './partials/GridView/View/View';

	export default {
		components: {
			compView: View,
			SortBar
		},
		props: {},
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

		methods: {

			mockMediaData() {
				const data = [];
				// let mock folder data
				for (let i = 0; i < 4; i++) {
					data.push({
						id: i + 141,
						name: 'Media Folder' + i,
						type: 'folder'
					})
				}
				// let mock file data
				const images = [
					'https://vignette.wikia.nocookie.net/monster/images/6/6e/DragonRed.jpg/revision/latest?cb=20160809235604',
					'https://thoughtcatalog.files.wordpress.com/2018/08/dragons.jpg?w=1920&h=1280&crop=1&resize=1920,1280&quality=95&strip=all',
					'https://www.ancient-origins.net/sites/default/files/field/image/Knight-and-dragon-.jpg',
					'https://cdn.mos.cms.futurecdn.net/rZgUH5JiEpSxCve2RPK3T3-1200-80.jpg',
					'https://www.sciencenewsforstudents.org/wp-content/uploads/2019/11/860-dragon-header-iStock-494839519.gif',
					'https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Chinese_dragon_asset_heraldry.svg/1200px-Chinese_dragon_asset_heraldry.svg.png'
				]

				for (let i = 0; i <= this.getRandomArbitrary(15, 35); i++) {
					data.push({
						id: i + 741,
						name: 'Dragon ' + i,
						type: 'file',
						path: '/var/www/imgs/image' + i + '.png',
						folder_id: null,
						filename: 'image' + i + '.png',
						media_url: images[this.getRandomArbitrary(0, images.length - 1)]
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
