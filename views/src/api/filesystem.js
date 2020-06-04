import axios from "axios";
import SETTINGS from "../settings";

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
	createFolder(folder_name, folder_color , folder_description , parent_folder_id, cb) {
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

};
