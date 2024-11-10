export default defineNuxtRouteMiddleware((to) => {
	const tokenCookie = useCookie('token');

	if (tokenCookie.value && to?.name === 'auth-login') {
		return navigateTo('/');
	}

	if (tokenCookie.value === 'unauthenticated' && to?.name !== 'auth-login') {
		return navigateTo('/auth/login');
	}
});
