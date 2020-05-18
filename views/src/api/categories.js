import axios from 'axios';
import SETTINGS from '../settings';

export const ApiCategories = {
	getCategories(cb) {
		axios
			.get(
				_wp_ROOT_URL + SETTINGS.API_BASE_PATH +
				'categories?sort=name&hide_empty=true&per_page=50'
			)
			.then(response => {
				cb(response.data.filter(c => c.name !== 'Uncategorized'));
			})
			.catch(e => {
				cb(e);
			});
	}
}
