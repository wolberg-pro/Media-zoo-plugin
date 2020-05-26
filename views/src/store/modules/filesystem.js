import {ApiFileSystem} from '../../api'
import * as types from '../mutation-types'

// initial state
const state = {
	files: [],
	folders: [],
	loaded: false,
	createFolderloaded: false,
	createFolderStatus: false
}

// getters
const getters = {
	// Returns an array all categories
	allFiles: state => state.files,
	allFolders: state => state.folders,
	allFilesLoaded: state => state.loaded,
	createFolderLoad: state=> state.createFolderloaded,
	createFolderStatus: state=> state.createFolderStatus
}

// actions
const actions = {
	getFiles({commit}) {
		commit(types.FILES_LOADED, false)
		ApiFileSystem.getFiles(data => {
			const { files ,  folders} = data;
			commit(types.STORE_FETCHED_FILES, {files, folders})
			commit(types.FILES_LOADED, true)
			commit(types.INCREMENT_LOADING_PROGRESS)
		})
	},
	createFolder({commit},{folder_name, folder_color , folder_description , parent_folder_id}) {
		commit(types.CREATE_FOLDER_LOAD, true)
		ApiFileSystem.createFolder(folder_name, folder_color , folder_description , parent_folder_id,data => {
			commit(types.CREATE_FOLDER_LOAD, false)
			commit(types.CREATE_FOLDER_STATUS, data.status)
		})
	},
	resetState({commit}) {
		commit(types.CREATE_FOLDER_LOAD, false)
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
	},
	[types.CREATE_FOLDER_STATUS](state,bool) {
		state.createFolderStatus = bool;
	},
	[types.CREATE_FOLDER_LOAD](state, bool) {
		state.createFolderloaded = bool
	}
}

export default {
	state,
	getters,
	actions,
	mutations
}
