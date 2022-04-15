const path = require('path');

module.exports = {
	entry: './assets/js/index.js',
	output: {
		filename: 'bundle.js',
		path: path.resolve(__dirname, './build/')
	}
}