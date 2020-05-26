<template>
	<div class="content-page">
		<el-row>
			<el-col :span="24">
				<div class="flex flex-col bg-gray-200">
					<div class="nav-page px-4 py-2 m-2" v-if="true == 0">
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
							<el-menu mode="horizontal" class="el-menu-horizontal-actions">
								<el-submenu index="1">
									<template slot="title">
										<i class="el-icon-upload"></i>
										<span slot="title">New</span>
									</template>
									<el-menu-item index="1-1" @click="onCreateFolder">Create Folder</el-menu-item>
									<el-menu-item index="1-2">Upload File/s</el-menu-item>
								</el-submenu>
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

		<el-dialog title="New Folder" center destroy-on-close	:visible.sync="newFolderDigLoaded"  @close="onCreateFolderDialogClose()">
			<new-folder />
		</el-dialog>
	</div>
</template>

<script>
	import GridView from "./MediaViews/GridView";
	import NewFolder from "./partials/dialogs/NewFolder";
	import {mapGetters} from "vuex";

	export default {
		computed: {
			...mapGetters({
				newFolderDigLoaded: 'newFolderDigLoaded',
				parentFolderId: 'parentFolderId'
			}),
		},
		data() {
			return {
				activeMenuSelectedIndex: "1",
			};
		},
		components: {
			GridView,
			NewFolder
		},
		methods: {
			onCreateFolder() {
				this.$store.dispatch('openNewFolder', {folder_id: null});
			},
			onCreateFolderDialogClose() {
				this.$store.dispatch('closeNewFolder');
			},
			onUploadFiles() {}
		}
	};
</script>

<style type="postcss" scoped>
	.el-menu-item.is-active {
		color: inherit;
	}
</style>
