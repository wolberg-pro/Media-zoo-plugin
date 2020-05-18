import axios from "axios";
import SETTINGS from "../settings";

export  const ApiPing =  {
	getPings(count = 5, cb) {
		axios
			.get(_wp_ROOT_URL + SETTINGS.API_CORE_PATH + 'request_ping/' + count)
			.then(response => {
				cb(response.data);
			})
			.catch(e => {
				cb(e);
			});
	},
};
