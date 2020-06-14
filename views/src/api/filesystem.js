import axios from "axios";
import SETTINGS from "../settings";
import * as types from '../store/mutation-types'

export const ApiFileSystem = {
	getFiles(cb) {
		axios
			.get(_wp_ROOT_URL + SETTINGS.API_CORE_PATH + 'files/all')
			.then(response => {
				cb(response.data);
			})
			.catch(e => {
				cb(e);
			});
	},
	uploadFile(fileData, commit, cb) {
		axios
			.post(_wp_ROOT_URL + SETTINGS.API_CORE_PATH + 'files/upload', fileData, {
				headers: {
					"Content-Type": "multipart/form-data"
				},
				onUploadProgress: function (progressEvent) {
					const uploadPercentage = parseInt(
						Math.round((progressEvent.loaded * 100) / progressEvent.total)
					);
					commit(types.UPLOAD_MEDIA_ITEM_PROGRESS, uploadPercentage);
				}
			})
			.then(response => {
				cb(response.data);
			})
			.catch(e => {
				cb(e);
				commit(types.UPLOAD_MEDIA_ITEM_FAILED , e);
			});
	},
	createFolder(folder_name, folder_color, folder_description, parent_folder_id, cb) {
		axios
			.post(_wp_ROOT_URL + SETTINGS.API_CORE_PATH + 'files/create', {
				type: 'folder',
				parent_folder_id,
				folder_name,
				folder_color,
				folder_description
			})
			.then(response => {
				cb(response.data);
			})
			.catch(e => {
				cb(e);
			});
	},
	deleteMediaItems(folder_id, folder_ids, file_ids, cb) {
		axios
			.post(_wp_ROOT_URL + SETTINGS.API_CORE_PATH + 'media/remove', {
				folder_id,
				folders: folder_ids,
				files: file_ids
			})
			.then(response => {
				cb(response.data);
			})
			.catch(e => {
				cb(e);
			});
	},

};
