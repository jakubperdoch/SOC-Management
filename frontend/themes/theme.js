// theme.js
import { definePreset } from '@primevue/themes';
import Aura from '@primevue/themes/aura';

const customPreset = definePreset(Aura, {
	semantic: {
		primary: {
			50: '#f5f7fa',
			100: '#e1e5eb',
			200: '#c3c9d4',
			300: '#a4adb5',
			400: '#868f9d',
			500: '#212737', // Base Primary
			600: '#1e2631',
			700: '#1a1f2b',
			800: '#161923',
			900: '#10141a',
			950: '#0a0c11',
		},
		secondary: {
			50: '#f4faf0',
			100: '#e1f5d9',
			200: '#c3ebad',
			300: '#a5e181',
			400: '#87d855',
			500: '#86C725', // Base Secondary
			600: '#76b51e',
			700: '#669c17',
			800: '#568310',
			900: '#446a0a',
			950: '#2f4c05',
		},
		accent: {
			50: '#fff8e1', // Example Accent: Light Yellow
			100: '#ffecb3',
			200: '#ffe082',
			300: '#ffd54f',
			400: '#ffca28',
			500: '#ffc107', // Base Accent
			600: '#ffb300',
			700: '#ffa000',
			800: '#ff8f00',
			900: '#ff6f00',
			950: '#e65100',
		},
	},
	typography: {
		fontFamily: 'Montserrat, sans-serif',
	},
});

export default {
	preset: customPreset,
	options: {
		darkModeSelector: '.dark-mode',
		fontFamily: 'Montserrat, sans-serif',
	},
};
