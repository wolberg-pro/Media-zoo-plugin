<template>
	<div class="content-page">
		<el-row>
			<el-col :span="24">
				<div class="flex flex-col bg-gray-200">
					<div class="nav-page px-4 py-2 m-2">
						<el-menu mode="horizontal" class="el-menu-horizontal-actions" @select="handleSelect">
							<el-menu-item index="2">
								<i class="el-icon-menu"></i>
								<span slot="title">Views</span>
							</el-menu-item>
							<el-menu-item index="3">
								<i class="el-icon-picture-outline"></i>
								<span slot="title">Image Tools</span>
							</el-menu-item>
						</el-menu>
					</div>
					<el-card class="box-card">
						<div slot="header" class="clearfix">
							<span>Media Zoo Assest Control</span>
						</div>
						<div class="actions px-4 py-2 m-2">
							<el-breadcrumb separator-class="el-icon-arrow-right">
								<el-breadcrumb-item :to="{ path: '/' }">root</el-breadcrumb-item>
							</el-breadcrumb>
							<el-menu mode="horizontal" class="el-menu-horizontal-actions" @select="handleSelect" v-if="true == 0">
								<el-menu-item index="1">
									<i class="el-icon-upload"></i>
									<span slot="title">Add New Files</span>
								</el-menu-item>
								<el-menu-item index="1">
									<i class="el-icon-remove"></i>
									<span slot="title">Delete Selected</span>
								</el-menu-item>
								<el-menu-item index="2">
									<i class="el-icon-menu"></i>
									<span slot="title">Action A</span>
								</el-menu-item>
								<el-menu-item index="3">
									<i class="el-icon-menu"></i>
									<span slot="title">Action B</span>
								</el-menu-item>
								<el-menu-item index="4">
									<i class="el-icon-menu"></i>
									<span slot="title">Action C</span>
								</el-menu-item>
								<el-menu-item index="5">
									<i class="el-icon-menu"></i>
									<span slot="title">Action D</span>
								</el-menu-item>
							</el-menu>
							<div class="nav-page px-4 py-2 m-2">
								<el-row>
									<el-col :span="24">
										<GridView />
									</el-col>
								</el-row>
							</div>
						</div>
					</el-card>
				</div>
			</el-col>
		</el-row>
	</div>
</template>

<script>
	import GridView from "./MediaViews/GridView";

	export default {
		data() {
			return {
				activeMenuSelectedIndex: "1",
			};
		},
		components: {
			GridView,
		},
		methods: {
			handleSelect(key, keyPath) {
				console.log(key, keyPath);
			}
		}
	};
</script>

<style type="postcss" scoped>
	.el-menu-item.is-active {
		color: inherit;
	}
</style>
