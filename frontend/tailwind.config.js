/** @type {import('tailwindcss').Config} */
module.exports = {
	prefix: 'tw-',
	corePlugins: {
		preflight: false,
	},
	content: [
		'./components/**/*.{vue,js,ts}',
		'./layouts/**/*.vue',
		'./pages/**/*.vue',
		'./app.vue',
		'./plugins/**/*.{js,ts}',
		'./nuxt.config.{js,ts}',
	],
	theme: {
		extend: {
			colors: {
				primary: '#212737',
				secondary: '#86C725',
			},
			fontFamily: {
				sans: ['Montserrat', 'sans-serif'],
			},
			screens: {
				sm: '640px',
				md: '768px',
				lg: '1024px',
				xl: '1280px',
				'2xl': '1536px',
			},
		},
	},
};
