<template>
	<div class="h-40 divide-y divide-gray-400">
		<div class="flex  flex-col px-4 py-2 m-2" v-if="item.type == 'file'">
			<div class="avatar">
				<el-avatar shape="square" :size="120" :src="item.media_url"></el-avatar>
			</div>
			<div class="flex flex-col bg-gray-200">
				<div class="text-gray-700 text-justify">{{ item.filename }}</div>
				<div class="text-gray-700 text-justify">{{ item.name }}</div>
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
		props: ['item'],
		data() {
			return {
				value: null
			}
		}
	}
</script>


<style type="postcss" scoped>
</style>
