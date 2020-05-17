<template>
	<!--	<div class="nav-page">-->
	<!--		<el-tabs v-model="activeName" @tab-click="handleClick">-->
	<!--			<el-tab-pane label="User" name="first">User</el-tab-pane>-->
	<!--			<el-tab-pane label="Config" name="second">Config</el-tab-pane>-->
	<!--			<el-tab-pane label="Role" name="third">Role</el-tab-pane>-->
	<!--			<el-tab-pane label="Task" name="fourth">Task</el-tab-pane>-->
	<!--		</el-tabs>-->
	<!--	</div>-->
	<!--	<div class="content-page">-->
	<!--		<el-row>-->
	<!--			<el-col :span="12"><div class="grid-content bg-purple"></div></el-col>-->
	<!--			<el-col :span="12"><div class="grid-content bg-purple-light"></div></el-col>-->
	<!--		</el-row>-->
	<!--	</div>-->

	<!--	<div class="footer-page">-->
	<!--	</div>-->
	<div class="page page--home">
		<a href="https://vuewordpress.com">
			<img src="https://res.cloudinary.com/evanagee/image/upload/c_scale,w_700/v1580244758/VueWP/VWP-hero.png"/>
		</a>
		<h1 class="mt-6">Welcome!</h1>
		<p>
			You'll probably want to remove all of this stuff, but hey it at least it works!
		</p>
		<p>If you'd like to edit the contents of this page take a look at <code>src/components/Home.vue</code></p>
		<p class="mb-10">
			~
			<a href="https://evanagee.com/">Evan Agee</a>
		</p>
		<recent-posts-widget limit="5" class="mb-10">Recent Posts</recent-posts-widget>
		<pages-widget limit="5">Pages</pages-widget>
	</div>
</template>

<script>
	import RecentPostsWidget from './widgets/RecentPosts.vue';
	import PagesWidget from './widgets/Pages.vue';

	export default {
		components: {
			RecentPostsWidget,
			PagesWidget,
		},
	};
</script>

<style type="postcss"></style>
