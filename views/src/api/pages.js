import axios from "axios";
import SETTINGS from "../settings";

export const ApiPages = {
	getPages(cb) {
		axios
			.get(_wp_ROOT_URL + SETTINGS.API_BASE_PATH + 'pages?per_page=10')
			.then(response => {
				cb(response.data);
			})
			.catch(e => {
				cb(e);
			});
	},

	getPage(id, cb) {
		if (!Number.isInteger(id) || !id)
			return false;

		axios
			.get(_wp_ROOT_URL + SETTINGS.API_BASE_PATH + 'pages/' + id)
			.then(response => {
				cb(response.data);
			})
			.catch(e => {
				cb(e);
			});
	},

	getPosts(limit = 5, cb) {
		axios
			.get(_wp_ROOT_URL + SETTINGS.API_BASE_PATH + 'posts?per_page=' + limit)
			.then(response => {
				cb(response.data);
			})
			.catch(e => {
				cb(e);
			});
	},
};
