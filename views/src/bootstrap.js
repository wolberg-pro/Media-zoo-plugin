import axios from "axios";
import Vue from 'vue';
import Element from 'element-ui';

// import 'element-ui/lib/theme-chalk/reset.css'
// import 'element-ui/lib/theme-chalk/index.css'
import './assets/css/styles.css';
import router from './router';
import App from './App.vue';
import store from './store';
import * as types from './store/mutation-types';

try {
	axios.defaults.headers.common = {
		'X-WP-Nonce': _wp_nonce,
		"X-CSRF-TOKEN":
			typeof window.WordPress !== "undefined" ? window.WordPress.csrfToken : "",
		"X-Requested-With": "XMLHttpRequest"
	};
} catch (e) {
	console.log(e);
}
Vue.use(Element, {size: 'small', zIndex: 3000});
new Vue({
	el: '#app',
	store,
	router,
	render: h => h(App),
	created() {
		this.$store.commit(types.RESET_LOADING_PROGRESS);
	},
});
