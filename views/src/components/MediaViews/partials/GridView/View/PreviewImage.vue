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
		<el-carousel :autoplay="false" trigger="click" indicator-position="outside" @change="onPreviewImageChange"
								 type="card" height="350px">
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
		<el-form ref="form" :label-position="labelPosition" :rules="formRules" :model="form" label-width="200px"
						 :disabled="isAllowToEdit()">

			<el-form-item label="Media Name" prop="name" required>
				<el-input placeholder="Media Name input"
									v-model="form.name"
									maxlength="100"
									minlength="3"
									show-word-limit></el-input>
			</el-form-item>

			<el-form-item label="Media Alt" prop="alt">
				<el-input placeholder="Media Alt input"
									v-model="form.alt"
									maxlength="50"
									minlength="3"
									show-word-limit></el-input>
			</el-form-item>

			<el-form-item label="Media caption" prop="caption">
				<el-input placeholder="Media Caption input"
									v-model="form.caption"
									maxlength="50"
									minlength="3"
									show-word-limit></el-input>
			</el-form-item>

			<el-form-item label="Media Description" prop="description">
				<el-input type="textarea" placeholder="Media Description input" v-model="form.description"></el-input>
			</el-form-item>

			<el-divider content-position="left">Actions</el-divider>
			<el-form-item>
				<el-button type="primary" @click="submitForm('form')" :disabled="isAllowToEdit()">Submit</el-button>
				<el-button @click="resetForm('form')" :disabled="isAllowToEdit()">Reset</el-button>
			</el-form-item>
		</el-form>
	</el-card>
</template>

<script>
	export default {
		props: ['items','selected'],
		data() {
			return {
				selectItem: this.selected,
				editMode: 'false',
				labelPosition: 'left',
				form: {
					description:  this.selected.file_info.description,
					caption: this.selected.file_info.caption,
					alt: this.selected.file_info.alt,
					name: this.selected.name
				},
				formRules: {
					alt: {min: 3, max: 50, message: 'Length should be 3 to 50', trigger: 'blur'},
					name: {required: true, min: 3, max: 100, message: 'Length should be 3 to 100', trigger: 'blur'},
					caption: {min: 3, max: 50, message: 'Length should be 3 to 50', trigger: 'blur'}
				}
			}
		},
		mounted() {
			this.updateForm();
			this.editMode = 'false';
		},
		methods: {
			isAllowToEdit() {
				return this.editMode !== 'true';
			},
			openDirectLink(item) {
				window.open(item.file_url);
			},
			onPreviewImageChange(newIdx, oldIdx) {
				this.openMessage('Please Note New preview been selected all field reset', 'warn')
				this.selectItem = this.items[newIdx];
				this.resetForm('form');
				this.updateForm();
			},
			updateForm() {
				if (this.selectItem || this.selectItem.file_info) {
					this.form.alt = this.selectItem.file_info.alt;
					this.form.name = this.selectItem.name;
					this.form.caption = this.selectItem.file_info.caption;
					this.form.description = this.selectItem.file_info.description;
				}
			},
			onEditModeChange(value) {
				if (!this.isAllowToEdit()) {
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

			submitForm(formName) {
				this.$refs[formName].validate((valid) => {
					if (valid) {
						alert('submit!');
					} else {
						console.log('error submit!!');
						return false;
					}
				});
			},
			resetForm(formName) {
				this.$refs[formName].resetFields();
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

