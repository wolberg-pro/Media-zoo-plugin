import axios from "axios";
import SETTINGS from "../settings";

export  const ApiFileSystem =  {
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
};
