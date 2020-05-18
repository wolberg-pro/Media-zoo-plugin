import axios from "axios";

try {
	axios.defaults.headers.common = {
		'X-WP-Nonce': _wp_nonce,
		"X-CSRF-TOKEN":
			typeof window.WordPress !== "undefined" ? window.WordPress.csrfToken : "",
		"X-Requested-With": "XMLHttpRequest"
	};
} catch (e) {
	console.log(e);
}
