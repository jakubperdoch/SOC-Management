import useAuth from '~/composable/useAuth';

export default defineNuxtRouteMiddleware((to) => {
	const { getUserIdFromToken } = useAuth();
	const userId = computed(() => getUserIdFromToken() || null);

	if (userId.value && userId && to?.name === 'auth-login') {
		return navigateTo('/');
	}

	if (!userId.value && to?.name !== 'auth-login') {
		return navigateTo('/auth/login');
	}
});
