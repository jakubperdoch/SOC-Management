import useAuth from '~/composable/useAuth';

export default defineNuxtRouteMiddleware(async (to) => {
	const { getUserIdFromToken, getUser, user } = useAuth();
	const userId = getUserIdFromToken();
	await getUser();

	if (userId && to?.name === 'auth-login') {
		return navigateTo('/');
	}

	if (!userId && to?.name !== 'auth-login' && to?.name !== 'auth-register') {
		return navigateTo('/auth/login');
	}

	const allowedRoles = to.meta.roles || [];

	if (
		allowedRoles.length > 0 &&
		user.value?.role &&
		!allowedRoles.includes(user.value.role)
	) {
		console.warn(`Unauthorized access attempt by role: ${user.value.role}`);
		return navigateTo('/dashboard');
	}
});
