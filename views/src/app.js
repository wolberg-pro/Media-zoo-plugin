const selector = document.querySelector('#app') !== null;
if (selector) {
	window.addEventListener('load', () => {
		require('./bootstrap');
	})
}
