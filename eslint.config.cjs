const defaultConfig = require( '@wordpress/scripts/config/eslint.config.cjs' );

module.exports = [
	...defaultConfig,
	{
		ignores: [ 'eslint.config.cjs', 'scripts/**' ],
	},
	{
		rules: {
			'import/no-unresolved': [ 'error', { ignore: [ '^@wordpress/' ] } ],
		},
	},
];
