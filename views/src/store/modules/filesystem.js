import {
	ApiFileSystem
} from '../../api'
import * as types from '../mutation-types'

// initial state
const state = {
	files: [],
	folders: [],
	markItemsStats_files: 0,
	markItemsStats_folders: 0,
	loaded: false,
	createFolderloaded: false,
	createFolderStatus: false
}

// getters
const getters = {
	// Returns an array all categories
	allFiles: state => state.files,
	allFolders: state => state.folders,
	allMarkStatsFiles: state => state.markItemsStats_files,
	allMarkStatsFolders: state => state.markItemsStats_folders,
	totalEntities: state => state.files.length + state.folders.length,
	totalMarkEntities: state => state.markItemsStats_files + state.markItemsStats_folders,
	allFilesLoaded: state => state.loaded,
	createFolderLoad: state => state.createFolderloaded,
	createFolderStatus: state => state.createFolderStatus
}

// actions
const actions = {
	addMarkItem({
		commit
	}, {
		entity_id,
		is_file
	}) {
		commit(types.ADD_MARK_ITEM, {
			entity_id,
			is_file
		});
	},
	removeMarkItem({
		commit
	}, {
		entity_id,
		is_file
	}) {
		commit(types.REMOVE_MARK_ITEM, {
			entity_id,
			is_file
		});
	},
	markAllItemsAsMark({
		commit
	}) {
		commit(types.SELECT_ALL_ITEMS);
	},
	ClearAllMarkItems({
		commit
	}) {
		commit(types.CLEAR_MARK_ITEMS);
	},
	getFiles({
		commit
	}) {
		commit(types.FILES_LOADED, false)
		ApiFileSystem.getFiles(data => {
			const {
				files,
				folders
			} = data;
			commit(types.STORE_FETCHED_FILES, {
				files,
				folders
			})
			commit(types.FILES_LOADED, true)
			commit(types.INCREMENT_LOADING_PROGRESS)
		})
	},
	createFolder({
		commit
	}, {
		folder_name,
		folder_color,
		folder_description,
		parent_folder_id
	}) {
		commit(types.CREATE_FOLDER_LOAD, true)
		ApiFileSystem.createFolder(folder_name, folder_color, folder_description, parent_folder_id, data => {
			commit(types.CREATE_FOLDER_LOAD, false)
			commit(types.CREATE_FOLDER_STATUS, data.status)
		})
	},
	resetState({
		commit
	}) {
		commit(types.CREATE_FOLDER_LOAD, false)
	}
}

// mutations
const mutations = {
	[types.STORE_FETCHED_FILES](state, {
		files,
		folders
	}) {
		state.files = files
		state.folders = folders;
	},

	[types.FILES_LOADED](state, bool) {
		state.loaded = bool
	},
	[types.CREATE_FOLDER_STATUS](state, bool) {
		state.createFolderStatus = bool;
	},
	[types.CREATE_FOLDER_LOAD](state, bool) {
		state.createFolderloaded = bool
	},
	[types.ADD_MARK_ITEM](state, {
		entity_id,
		is_file
	}) {
		if (is_file) {
			const file = state.files.find(item => item.id === entity_id);
			file.mark = true;
			state.markItemsStats_files++;
		} else {
			const folder = state.folders.find(item => item.id === entity_id);
			folder.mark = true;
			state.markItemsStats_folders++;
		}
	},
	[types.REMOVE_MARK_ITEM](state, {
		entity_id,
		is_file
	}) {
		if (is_file) {
			const file = state.files.find(item => item.id === entity_id);
			file.mark = false;
			state.markItemsStats_files--;

		} else {
			const folder = state.folders.find(item => item.id === entity_id);
			folder.mark = false;
			state.markItemsStats_folders--;
		}
	},
	[types.CLEAR_MARK_ITEMS](state) {
		state.files.forEach(item => item.mark = false);
		state.folders.forEach(item => item.mark = false);
		state.markItemsStats_files = 0;
		state.markItemsStats_folders = 0;
	},
	[types.SELECT_ALL_ITEMS](state) {
		state.files.forEach(item => item.mark = true);
		state.folders.forEach(item => item.mark = true);
		state.markItemsStats_files = state.files.length;
		state.markItemsStats_folders = state.folders.length;
	}
}

export default {
	state,
	getters,
	actions,
	mutations
}
