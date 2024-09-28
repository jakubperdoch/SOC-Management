import { defineStore } from 'pinia';
import users from '@/utils/data/users.json';

interface UserPayloadInterface {
	id: number;
	username: string;
	password: string;
	email: string;
	token: string;
	role: string;
}

export const useAuthStore = defineStore('auth', {
	state: () => ({
		authenticated: false,
		loading: false,
		user: {
			username: '',
			role: '',
		},
	}),

	actions: {
		async logUserIn({ username, password }: Partial<UserPayloadInterface>) {
			const config = useRuntimeConfig();

			const data = users.find(
				(user) => user.username === username && user.password === password
			);

			if (data) {
				const generateToken = this.generateToken(data);
				const token = useCookie('token');
				token.value = generateToken;
				this.authenticated = true;
				this.user = {
					username: data.username,
					role: data.role,
				};
				return { authenticated: this.authenticated, user: this.user };
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
