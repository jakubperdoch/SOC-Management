import ToastService from 'primevue/toastservice';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';
import { createBootstrap } from 'bootstrap-vue-next';

export default defineNuxtPlugin((nuxtApp) => {
	nuxtApp.vueApp.use(ToastService);
	nuxtApp.vueApp.use(createBootstrap());
});
