import Vue from 'vue'
import Vuex from 'vuex'
import createPersist from 'vuex-localstorage'
import * as actions from './actions'
import * as getters from './getters'
import hub from './modules/hub'
import user from './modules/user'
import post from './modules/post'
import ping from './modules/ping'
import page from './modules/page'
import categories from './modules/categories'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

let localStorage = createPersist({
	namespace: 'MediaZooWpPlugin',
	initialState: {},
	expires: 1.21e+9 // Two Weeks
})

export default new Vuex.Store({
	actions,
	getters,
	modules: {
		hub,
		user,
		post,
		ping,
		page,
		categories
	},
	strict: debug,
	plugins: [localStorage]
})
