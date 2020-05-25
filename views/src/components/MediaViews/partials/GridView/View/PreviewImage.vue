<template>
	<el-card class="box-card">
		<div slot="header" class="clearfix">
			<div class="inline-block float-right">
				<span>Edit Mode</span>
				<el-tooltip :content="'Click here for disable or enable Edit Mode'" placement="top">
					<el-switch
						v-model="editMode"
						active-color="#13ce66"
						inactive-color="#ff4949"
						@change="onEditModeChange"
						active-value="true"
						inactive-value="false">
					</el-switch>
				</el-tooltip>
			</div>
			<div class="clearfix"></div>
		</div>
		<el-carousel :autoplay="false" trigger="click" indicator-position="outside" type="card" height="350px">
			<el-carousel-item v-for="item in items" :key="item.id">
				<el-card :body-style="{ padding: '0px' }">
					<el-image
						:src="item.file_url"
						:fit="'fit'"></el-image>
					<div style="padding: 14px;">
						<span>{{ item.name }}</span>
						<div class="bottom clearfix">
							<time class="time">{{ item.registerDateTime }}</time>
							<div>
								<el-tooltip :content="'Click here will open new tab/window to direct media'" placement="top">
									<el-link @click="openDirectLink(item)" type="primary">Direct Link</el-link>
								</el-tooltip>
							</div>
						</div>
					</div>
				</el-card>
			</el-carousel-item>
		</el-carousel>
		<el-divider content-position="left">Image Meta Data</el-divider>
		<el-form ref="form" :model="form" label-width="120px" :disabled="allowToEdit()">
			<el-collapse accordion>
				<el-collapse-item name="1">
					<template slot="title">
						Consistency<i class="header-icon el-icon-info"></i>
					</template>
					<div>Consistent with real life: in line with the process and logic of real life, and comply with languages
						and
						habits that the users are used to;
					</div>
					<div>Consistent within interface: all elements should be consistent, such as: design style, icons and texts,
						position of elements, etc.
					</div>
				</el-collapse-item>
			</el-collapse>

			<el-divider content-position="left">Actions</el-divider>
			<el-form-item >
				<el-button type="primary" @click="onSubmit" :disabled="allowToEdit()">Create</el-button>
				<el-button :disabled="allowToEdit()">Cancel</el-button>
			</el-form-item>
		</el-form>
	</el-card>
</template>

<script>
	export default {
		props: ['items'],
		data() {
			return {
				editMode: 'false',
				form: {
					name: '',
					caption: '',
					alt: ''
				}
			}
		},
		methods: {
			allowToEdit() {
				return this.editMode ==='true';
			},
			openDirectLink(item) {
				window.open(item.file_url);
			},
			onEditModeChange(value) {
				if (value === 'true') {
					this.openMessage('Preview Set the edit mode ON', 'warn');
				} else {
					this.openMessage('Preview set the edit mode OFF', 'success')
				}
			},
			openMessage(message, type, duration = 3000) {
				this.$message({
					showClose: true,
					duration,
					message: message,
					type: type
				});
			},
			onSubmit() {
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

