import useAuth from '~/composable/useAuth';

export default defineNuxtRouteMiddleware((to) => {
	const { status } = useAuth();

	if (status.value === 'authenticated' && to?.name === 'auth-login') {
		return navigateTo('/');
	}

	if (status.value === 'unauthenticated' && to?.name !== 'auth-login') {
		return navigateTo('/auth/login');
	}
});
