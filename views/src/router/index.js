import Vue from 'vue';
import Router from 'vue-router';

// Components
import Home from '../components/Home.vue';
import Ping from '../components/Ping/Ping';

Vue.use(Router);

const router = new Router({
	routes: [
		{
			path: '/',
			name: 'Home',
			component: Home,
		},
		{
			path: '/ping',
			name: 'Ping',
			component: Ping,
		},
		{
			// will match everything
			path: '*',
			redirect: '/'
		}
	],
	mode: 'hash',
	base: '',

	// Prevents window from scrolling back to top
	// when navigating between components/views
	scrollBehavior(to, from, savedPosition) {
		if (savedPosition) {
			return savedPosition;
		} else {
			return {x: 0, y: 0};
		}
	},
});

router.afterEach((to) => { // (to, from)
	// Add a body class specific to the route we're viewing
	let body = document.querySelector('body');

	const slug = !(to.params.postSlug)
		? to.params.pageSlug
		: to.params.postSlug;
	body.classList.add('vue--page--' + slug);
});

export default router;
