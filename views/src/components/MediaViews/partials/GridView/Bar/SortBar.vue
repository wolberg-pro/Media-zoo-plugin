<template>
	<div class="grid-content border bg-purple-light rounded-md">
		<div class="sortBar flex flex-wrap justify-between content-around px-4 py-2 m-2 bg-gray-300">
			<div class="search">
				<el-autocomplete
					class="inline-input"
					placeholder="File / Folder search"
				></el-autocomplete>
			</div>
			<div class="sortContiner">
				<div class="flex flex-wrap content-around justify-between">
					<div class="self-center space-x-10">
						<el-select
							v-model="value"
							filterable
							default-first-option
							placeholder="Choose tags for your article">
							<el-option
								v-for="item in options"
								:key="item.value"
								:label="item.label"
								:value="item.value">
							</el-option>
						</el-select>
					</div>
					<div class="self-center px-4">
						<a href="javascript:void(0)">
							<i class="el-icon-arrow-up"/>
						</a>
					</div>
					<div class="self-center px-4">
						<a href="javascript:void(0)">
							<i class="el-icon-arrow-down"/>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['options'],
		data() {
			return {
				value: null
			}
		}
	}
</script>


<style type="postcss" scoped>
</style>
