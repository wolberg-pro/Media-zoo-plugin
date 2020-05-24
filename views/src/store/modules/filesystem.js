import {ApiFileSystem} from '../../api'
import * as types from '../mutation-types'

// initial state
const state = {
	files: [],
	loaded: false
}

// getters
const getters = {
	// Returns an array all categories
	allFiles: state => state.files,
	allFilesLoaded: state => state.loaded
}

// actions
const actions = {
	getFiles({commit}) {
		ApiFileSystem.getFiles(data => {
			const files = data.files
			commit(types.STORE_FETCHED_FILES, {files})
			commit(types.FILES_LOADED, true)
			commit(types.INCREMENT_LOADING_PROGRESS)
		})
	}
}

// mutations
const mutations = {
	[types.STORE_FETCHED_FILES](state, {files}) {
		state.files = files
	},

	[types.FILES_LOADED](state, bool) {
		state.loaded = bool
	}
}

export default {
	state,
	getters,
	actions,
	mutations
}
