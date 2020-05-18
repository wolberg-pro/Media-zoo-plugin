import {ApiPing} from '../../api'
import * as types from '../mutation-types'

// initial state
const state = {
	pongs: [],
	loaded: false
}

// getters
const getters = {
	// Returns an array all categories
	allCategories: state => state.all,
	allCategoriesLoaded: state => state.loaded
}

// actions
const actions = {
	getPongs({commit},{count}) {
		ApiPing.getPings(count , data => {
			commit(types.STORE_FETCHED_PING, {data.pings})
			commit(types.PING_LOADED, true)
			commit(types.INCREMENT_LOADING_PROGRESS)
		})
	}
}

// mutations
const mutations = {
	[types.STORE_FETCHED_PING](state, {categories}) {
		state.all = categories
	},

	[types.CATEGORIES_LOADED](state, bool) {
		state.loaded = bool
	}
}

export default {
	state,
	getters,
	actions,
	mutations
}
