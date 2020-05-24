<template>
	<el-carousel :autoplay="false" indicator-position="outside" type="card" >
		<el-carousel-item v-for="item in items" :key="item">
			<el-card :body-style="{ padding: '0px' }">
				<el-image
					:src="item.file_url"
					:fit="'fit'"></el-image>
				<div style="padding: 14px;">
					<span>{{ item.name }}</span>
					<div class="bottom clearfix">
						<time class="time">{{ item.registerDateTime }}</time>
					</div>
				</div>
			</el-card>
		</el-carousel-item>
	</el-carousel>
</template>

<script>
	export default {
		props: ['items'],
		data() {
			return {
				value: null
			}
		}
	}
</script>


<style type="postcss" scoped>
	.el-carousel__item h3 {
		color: #475669;
		font-size: 14px;
		opacity: 0.75;
		line-height: 20px;
		margin: 0;
	}

</style>

