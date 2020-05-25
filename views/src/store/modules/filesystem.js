import {ApiFileSystem} from '../../api'
import * as types from '../mutation-types'

// initial state
const state = {
	files: [],
	folders: [],
	loaded: false
}

// getters
const getters = {
	// Returns an array all categories
	allFiles: state => state.files,
	allFolders: state => state.folders,
	allFilesLoaded: state => state.loaded
}

// actions
const actions = {
	getFiles({commit}) {
		ApiFileSystem.getFiles(data => {
			const { files ,  folders} = data;
			commit(types.STORE_FETCHED_FILES, {files, folders})
			commit(types.FILES_LOADED, true)
			commit(types.INCREMENT_LOADING_PROGRESS)
		})
	}
}

// mutations
const mutations = {
	[types.STORE_FETCHED_FILES](state, {files,folders}) {
		state.files = files
		state.folders =  folders;
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
