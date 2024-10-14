import { definePreset } from '@primevue/themes';
import Aura from '@primevue/themes/aura';

const customPreset = definePreset(Aura, {
	semantic: {
		primary: {
			50: '{purple.50}',
			100: '{purple.100}',
			200: '{purple.200}',
			300: '{purple.300}',
			400: '{purple.400}',
			500: '{purple.500}',
			600: '{purple.600}',
			700: '{purple.700}',
			800: '{purple.800}',
			900: '{purple.900}',
			950: '{purple.950}',
		},
		secondary: {
			50: '{purple.100}',
			100: '{purple.200}',
			200: '{purple.300}',
			300: '{purple.400}',
			400: '{purple.500}',
			500: '{purple.600}',
			600: '{purple.700}',
			700: '{purple.800}',
			800: '{purple.900}',
			900: '{purple.950}',
		},
		accent: {
			50: '{yellow.50}',
			100: '{yellow.100}',
			200: '{yellow.200}',
			300: '{yellow.300}',
			400: '{yellow.400}',
			500: '{yellow.500}',
			600: '{yellow.600}',
			700: '{yellow.700}',
			800: '{yellow.800}',
			900: '{yellow.900}',
			950: '{yellow.950}',
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
