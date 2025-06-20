interface IUser {
  id: number;
  name: string;
  surname: string;
  email: string;
  password?: string;
  role: string;
}

export interface AuthResponse {
  access_token: string;
  user: IUser;
}

export interface LoginCredentials {
  email: string;
  password: string;
}

export interface RegisterCredentials {
  name: string;
  surname: string;
  email: string;
  password: string;
  role: string;
}

export interface TokenValidationResponse {
  valid: boolean;
  role: string;
  remaining: number;
}

import { defineStore } from "pinia";

const useAuthStore = defineStore("auth", () => {
  const tokenCookie = useCookie<string | null>("token", { sameSite: "strict" });
  const user = ref<IUser | null>(null);

  const token = computed(() => tokenCookie.value);
  const status = computed(() =>
    user.value ? "authenticated" : "unauthenticated",
  );
  const role = computed(() => user.value?.role ?? "guest");

  /**
   * Fetch data from API
   * @param url
   * @param creds
   */
  async function doAuth(url: string, creds: unknown): Promise<IUser> {
    const { access_token, user: u } = await apiFetch(url, {
      method: "POST",
      body: creds,
    });
    tokenCookie.value = access_token;
    user.value = u;
    return u;
  }

  /**
   * Login user
   * @param {Object} creds
   * @returns {Promise<Object>}
   */
  async function login(creds: LoginCredentials): Promise<IUser> {
    return doAuth("/auth/login", creds);
  }

  /**
   * Register user
   * @param {Object} creds
   * @returns {Promise<Object>}
   */
  async function register(creds: RegisterCredentials): Promise<IUser> {
    return doAuth("/auth/register", creds);
  }

  async function validateURLToken(
    token: string,
  ): Promise<TokenValidationResponse | void> {
    if (!token) return;
    try {
      return await apiFetch("/auth/invite/validate", {
        method: "POST",
        body: {
          token: token,
        },
      });
    } catch (error) {
      console.error("Token validation failed:", error);
    }
  }

  /**
   * Fetch user data (it token exists)
   * @returns {Promise<Object>}
   */
  async function fetchUser(): Promise<IUser | void> {
    if (!tokenCookie.value) return;
    const { user: u } = await apiFetch("/user/info");
    user.value = u;
    return u;
  }

  /**
   * Logout user
   * @returns {Promise<void>}
   */
  async function logout(): Promise<void> {
    try {
      await apiFetch("/auth/logout", { method: "POST" });
    } catch (_) {
    } finally {
      tokenCookie.value = null;
      user.value = null;
    }
  }

  /**
   * Update user data
   * @param {Object} data
   * @returns {Promise<Object>}
   */
  async function updateUser(data: Partial<IUser>): Promise<IUser | void> {
    if (!user.value) return;

    try {
      const updatedUser = await apiFetch("/auth/profile/update", {
        method: "PUT",
        body: data,
      });
      user.value = { ...updatedUser?.user };

      return updatedUser;
    } catch (error) {
      console.error("Failed to update user:", error);
      return;
    }
  }

  /**
   * Refresh user token (if exists)
   * @returns {Promise<Object>}
   */
  const refresh = async () => {
    if (!tokenCookie.value) {
      return;
    }

    try {
      const response = await apiFetch("/user/refresh-token", {
        method: "POST",
      });

      const { token: userToken, ...userData } = response;

      user.value = userData;
      tokenCookie.value = userToken;

      return Promise.resolve(userData);
    } catch (e) {
      tokenCookie.value = null;

      return Promise.reject(e);
    }
  };

  async function init() {
    await fetchUser();
  }

  return {
    login,
    register,
    logout,
    refresh,
    fetchUser,
    updateUser,
    validateURLToken,
    user,
    token,
    status,
    role,
    init,
  };
});

export default useAuthStore;
