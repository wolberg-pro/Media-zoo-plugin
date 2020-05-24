<template>
	<div class="h-40 divide-y divide-gray-400">
		<div class="flex  flex-col px-4 py-2 m-2" v-if="type == 'file'" @click="previewImages(item)" >
			<div class="avatar">
				<el-avatar v-if="isFileImage(item)" class="cursor-pointer" shape="square" :size="120" :src="item.file_thumb_url"></el-avatar>
				<i  v-else class="el-icon-files text-5xl"></i>
			</div>
			<div class="flex flex-col bg-gray-200">
				<div class="text-gray-700 text-justify">{{ item.title }}</div>
				<div class="text-gray-700 text-justify">{{ item.registerDateTime }}</div>
			</div>
		</div>

		<div class="flex flex-col px-4 py-2 m-2" v-else>
			<div class="avatar">
				<i class="el-icon-folder text-5xl"></i>
			</div>
			<div class="flex flex-col bg-gray-200">
				<div class="text-gray-700 text-justify">{{ item.name }}</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['item', 'type'],
		methods: {
			previewImages(item) {
				if (this.isFileImage(item)) {
					this.$parent.$emit("start_preview", item);
				}
			},
			isFileImage(item ) {
				return item.file_mine_type.toLowerCase().indexOf('image') != -1;
			}
		}

	}
</script>


<style type="postcss" scoped>
</style>
