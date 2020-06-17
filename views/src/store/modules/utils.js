import * as types from '../mutation-types'

// initial state
const state = {
	preview_files: [],
	preview_current_item: {},
	load_preview: false,
	parent_folder_id: null,
	load_new_folder_dig: false,
}

// getters
const getters = {
	// Returns an array all categories
	previewLoaded: state => state.load_preview,
	newFolderDigLoaded: state => state.load_new_folder_dig,
	parentFolderId: state => state.parent_folder_id,
	perviewFiles: state => state.preview_files,
	perviewCurrentSelectItem: state => state.preview_current_item,
}

// actions
const actions = {
	startPreview({
		commit
	}, {
		files,
		item
	}) {
		commit(types.LOAD_PREVIEW, {
			data: {
				files,
				item
			}
		})
	},
	stopPreview({
		commit
	}) {
		commit(types.UNLOAD_PREVIEW)
	},
	openNewFolder({
		commit
	}, {
		folder_id
	}) {
		commit(types.LOAD_NEW_DIG_FOLDER, {
			data: {
				folder_id
			}
		})
	},
	closeNewFolder({
		commit
	}) {
		commit(types.UNLOAD_NEW_DIG_FOLDER)
	}
}

// mutations
const mutations = {
	[types.LOAD_PREVIEW](state, {
		data
	}) {
		state.preview_files = data.files.filter(val => val.file_mine_type.toLowerCase().indexOf('image') != -1 && data.item.id != val.id);
		state.preview_files.unshift(data.item);
		state.preview_current_item = data.item;
		state.load_preview = true
	},

	[types.UNLOAD_PREVIEW](state) {
		state.preview_files = [];
		state.load_preview = false
	},
	[types.LOAD_NEW_DIG_FOLDER](state, {
		data
	}) {
		state.parent_folder_id = data.folder_id || null;
		state.load_new_folder_dig = true;
	},

	[types.UNLOAD_NEW_DIG_FOLDER](state) {
		state.parent_folder_id = null;
		state.load_new_folder_dig = false;
	}
}

export default {
	state,
	getters,
	actions,
	mutations
}
