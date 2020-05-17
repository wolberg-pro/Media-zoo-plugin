module.exports = {
	plugins: {
		autoprefixer: {},
		'postcss-import': {},
		'postcss-inherit': {},
		'postcss-assets': {},
		'postcss-nested': {},
		'postcss-hexrgba': {},
		'postcss-reporter': {
			clearMessages: true,
		},
		tailwindcss: './tailwind.config.js',
	},
	sourceMap: true || 'inline',
};
