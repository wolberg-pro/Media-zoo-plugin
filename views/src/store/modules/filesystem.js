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
	uploadFileProcess: 0,
	uploadFileIndicatorDialog: false,
	uploadFileIndicator: false,
	uploadFailed: false,
	uploadFailedMessage: '',
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
	uploadFileIndicatorDialog: state => state.uploadFileIndicatorDialog,
	uploadFileIndicator: state => state.uploadFileIndicator,
	uploadFileProcess: state => state.uploadFileProcess,
	uploadFileFailerStatus: state => state.uploadFileFailerStatus,
	uploadFileFailerMesseage: state => state.uploadFailedMessage,
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
	uploadFile({
		commit
	}, {
		file,
		name,
		alt,
		caption,
		description
	}) {
		commit(types.UPLOAD_MEDIA_ITEM_START);
		commit(types.UPLOAD_MEDIA_ITEM_RESET_PROGRESS);
		ApiFileSystem.uploadFile({
			file,
			name,
			alt,
			caption,
			description,
			folder_id
		}, commit, data => {
			const {
				files,
				folders
			} = data;
			if (files && folders) {
				commit(types.STORE_FETCHED_FILES, {
					files,
					folders
				});
			}
			commit(types.UPLOAD_MEDIA_ITEM_ENDED);
			commit(types.UPLOAD_MEDIA_ITEM_TRIGGER_DIALOG);
		})
	},
	triggerFileUploadDialog({
		commit
	}) {
		commit(types.UPLOAD_MEDIA_ITEM_TRIGGER_DIALOG)
	},
	deleteMediaItems({
		commit
	}, {
		current_folder_id,
		folder_ids,
		file_ids
	}) {
		commit(types.FILES_LOADED, false);
		ApiFileSystem.deleteMediaItems(current_folder_id, folder_ids, file_ids, data => {
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
	[types.UPLOAD_MEDIA_ITEM_TRIGGER_DIALOG](state) {
		state.uploadFileIndicatorDialog = !state.uploadFileIndicatorDialog;
	},
	[types.STORE_FETCHED_FILES](state, {
		files,
		folders
	}) {
		state.files = files
		state.folders = folders;
	},
	[types.UPLOAD_MEDIA_ITEM_START](state) {
		state.uploadFileIndecator = true;
		state.uploadFailedMessage = "";
		state.uploadFailed = false;
	},
	[types.UPLOAD_MEDIA_ITEM_RESET_PROGRESS](state) {
		state.uploadFileProcess = 0;
	},
	[types.UPLOAD_MEDIA_ITEM_FAILED](state, e) {
		console.error(e);
		state.uploadFailedMessage = "Upload cancel something happened";
		state.uploadFailed = true;
	},
	[types.UPLOAD_MEDIA_ITEM_PROGRESS](state, val) {
		state.uploadFileProcess = val;
	},
	[types.UPLOAD_MEDIA_ITEM_ENDED](state) {
		state.uploadFileIndecator = false;
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
		state.markFiles = [...state.files.filter(file => file.mark).map(file => file.id)];
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
		state.markFiles = [];
		state.markFolders = [];
	},
	[types.SELECT_ALL_ITEMS](state) {
		state.files.forEach(item => item.mark = true);
		state.folders.forEach(item => item.mark = true);
		state.markFiles = [...state.files.map(file => file.id)];
		state.markFolders = [...state.folders.map(folder => folder.id)];
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
