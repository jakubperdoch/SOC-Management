/**
 * Auth composable for managing user state throughout application
 */

type User = {
	email: string | null;
	role: string | null;
};

function useAuth() {
	const user = ref<User | null>(null);
	const status = computed(() =>
		user.value ? 'authenticated' : 'unauthenticated'
	);
	const token = useCookie('token');

	/**
	 * Login user
	 * @param {string} login
	 * @param {string} password
	 * @returns {Promise<object>}
	 */
	const login = async (email: string, password: string) => {
		try {
			const response = await apiFetch('/login', {
				method: 'POST',
				body: {
					email,
					password,
				},
			});

			const { token: userToken, ...user } = response;

			updateUser(user);

			token.value = userToken;

			return Promise.resolve(response);
		} catch (error) {
			return Promise.reject(error);
		}
	};

	/**
	 * Sets user data
	 * @param {object} userData
	 */
	const updateUser = (userData: any) => {
		user.value = userData;
	};

	/**
	 * Logout user
	 * @returns {Promise<void>}
	 */
	const logout = async () => {
		try {
			await apiFetch('/logout', {
				method: 'POST',
			});
		} catch (error) {
			console.error(error);
		} finally {
			token.value = null;
			user.value = null;

			return Promise.resolve();
		}
	};

	return {
		user,
		status,
		login,
		logout,
		updateUser,
	};
}

export default useAuth;