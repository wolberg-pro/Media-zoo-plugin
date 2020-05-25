import * as types from '../mutation-types'

// initial state
const state = {
	preview_files: [],
	load_preview: false
}

// getters
const getters = {
	// Returns an array all categories
	previewLoaded: state => state.load_preview,
	perviewFiles: state => state.preview_files,
}

// actions
const actions = {
	startPreview({commit}, {files,item}) {
		commit(types.LOAD_PREVIEW,{data: {files,item}})
	},
	stopPreview({commit}) {
		commit(types.UNLOAD_PREVIEW)
	}
}

// mutations
const mutations = {
	[types.LOAD_PREVIEW](state,{data}) {
		state.preview_files = data.files.filter(val => val.file_mine_type.toLowerCase().indexOf('image') != -1 && data.item.id != val.id);
		state.preview_files.unshift(data.item);
		state.load_preview = true
	},

	[types.UNLOAD_PREVIEW](state) {
		state.preview_files = [];
		state.load_preview = false
	}
}

export default {
	state,
	getters,
	actions,
	mutations
}
