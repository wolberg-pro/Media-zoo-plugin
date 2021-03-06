import axios from "axios";
import Vue from 'vue';
import Element from 'element-ui';
import {Form} from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'

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
Vue.use(Element, {locale, size: 'small', zIndex: 29000});

Vue.component(Form.name, Form);
new Vue({
	el: '#app',
	store,
	router,
	render: h => h(App),
	created() {
		this.$store.commit(types.RESET_LOADING_PROGRESS);
		this.$store.commit(types.CLEAR_MARK_ITEMS);
		this.$store.commit(types.CLEAR_FOLDER);
	},
});
