import { defineStore } from 'pinia';
import users from '@/utils/data/users.json';

interface UserPayloadInterface {
	id: number;
	username: string;
	password: string;
	email: string;
	token: string;
}

export const useAuthStore = defineStore('auth', {
	state: () => ({
		authenticated: false,
		loading: false,
	}),

	actions: {
		async logUserIn({ username, password }: Partial<UserPayloadInterface>) {
			const config = useRuntimeConfig();
			const baseUrl = config.public.API_BASE_URL;

			const data = users.find(
				(user) => user.username === username && user.password === password
			);

			if (data) {
				const generateToken = this.generateToken(data);
				const token = useCookie('token');
				token.value = generateToken;
				this.authenticated = true;
				return { authenticated: this.authenticated };
			} else {
				const token = useCookie('token');
				this.authenticated = false;
				token.value = null;
				return { authenticated: this.authenticated };
			}
		},
		async registerUser({ username, password, email }: UserPayloadInterface) {},
		logUserOut() {
			const token = useCookie('token');
			this.authenticated = false;
			token.value = null;
		},
		generateToken(user: UserPayloadInterface) {
			return `Bearer ${user.id}:${user.username}`;
		},
	},
});
