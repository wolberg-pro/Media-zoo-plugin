import {
	ApiFileSystem
} from '../../api'
import * as types from '../mutation-types'

// initial state
const state = {
	files: [],
	folders: [],
	markFiles: [],
	markFolders: [],
	markItemsStats_files: 0,
	markItemsStats_folders: 0,
	current_folder_id: null,
	loaded: false,
	createFolderloaded: false,
	createFolderStatus: false
}

// getters
const getters = {
	// Returns an array all categories
	allFiles: state => state.files,
	allFolders: state => state.folders,
	currentFolderID: state => state.current_folder_id || null,
	allFilesMarked: state => state.markFiles,
	allFoldersMarked: state => state.markFolders,
	allMarkStatsFiles: state => state.markItemsStats_files,
	allMarkStatsFolders: state => state.markItemsStats_folders,
	totalEntities: state => (state.files) ? state.files.length : 0 + (state.folders) ? state.folders.length : 0,
	totalMarkEntities: state => state.markItemsStats_files + state.markItemsStats_folders,
	allFilesLoaded: state => state.loaded,
	createFolderLoad: state => state.createFolderloaded,
	createFolderStatus: state => state.createFolderStatus
}

// actions
const actions = {
	deleteMediaItems({
		commit
	}, {
		current_folder_id,
		folder_ids,
		file_ids
	}) {
		commit(types.FILES_LOADED, false);
		ApiFileSystem.deleteMediaItems(current_folder_id,folder_ids, file_ids, data => {
			const {
				files,
				folders
			} = data;
			commit(types.STORE_FETCHED_FILES, {
				files,
				folders
			})
			commit(types.FILES_LOADED, true)
		})
	},
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
		commit(types.UPDATE_MARK_MEDIA_ITEMS);
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
		commit(types.UPDATE_MARK_MEDIA_ITEMS);
	},
	markAllItemsAsMark({
		commit
	}) {
		commit(types.SELECT_ALL_ITEMS);
		commit(types.UPDATE_MARK_MEDIA_ITEMS);
	},
	clearAllMarkItems({
		commit
	}) {
		commit(types.CLEAR_MARK_ITEMS);
		commit(types.UPDATE_MARK_MEDIA_ITEMS);
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
			commit(types.UPDATE_MARK_MEDIA_ITEMS);
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
	[types.UPDATE_MARK_MEDIA_ITEMS](state) {
		state.markFiles = [...state.files.filter(file => file.mark).map(file => file.ID)];
		state.markFolders = [...state.folders.filter(folder => folder.mark).map(folder => folder.id)];
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
