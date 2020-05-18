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
	allPings: state => state.all,
	allPingsLoaded: state => state.loaded
}

// actions
const actions = {
	getPongs({commit},{count}) {
		ApiPing.getPings(count , data => {
			if (data['pings']) {
				const pings = data.pings
				commit(types.STORE_FETCHED_PING, {pings})
				commit(types.PING_LOADED, true)
				commit(types.INCREMENT_LOADING_PROGRESS)
			}
		})
	}
}

// mutations
const mutations = {
	[types.STORE_FETCHED_PING](state, {pings}) {
		state.all = pings
	},

	[types.PING_LOADED](state, bool) {
		state.loaded = bool
	}
}

export default {
	state,
	getters,
	actions,
	mutations
}
