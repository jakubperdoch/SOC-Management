import { defineStore } from "pinia";

const useAuthStore = defineStore("auth", () => {
  const tokenCookie = useCookie("token", {
    sameSite: "strict",
  });

  const user = ref(null);
  const token = computed(() => tokenCookie.value);

  const status = computed(() =>
    !!user.value ? "authenticated" : "unauthenticated",
  );

  const role = computed(() => user.value?.role || "guest");

  /**
   * Login user with credentials
   * @param {{ email: string; password: string; }} credentials
   * @returns {Promise<Object>}
   */
  const login = async (credentials: any) => {
    try {
      const response = await apiFetch("/auth/login", {
        method: "POST",
        body: credentials,
      });

      const { access_token, user: userData } = response;

      user.value = userData;
      tokenCookie.value = access_token;

      return Promise.resolve(userData);
    } catch (error) {
      return Promise.reject(error);
    }
  };

  const register = async (credentials: any) => {
    try {
      const response = await apiFetch("/auth/register", {
        method: "POST",
        body: credentials,
      });

      const { access_token, user: userData } = response;

      user.value = userData;
      tokenCookie.value = randomToken;

      return Promise.resolve(userData);
    } catch (error) {
      return Promise.reject(error);
    }
  };

  /**
   * Fetch user data (it token exists)
   * @returns {Promise<Object>}
   */
  const fetchUser = async () => {
    if (!tokenCookie.value) {
      return;
    }

    try {
      const response = await apiFetch("/user/info");

      user.value = response?.user;

      return Promise.resolve(response);
    } catch (error) {
      tokenCookie.value = null;

      return Promise.reject(error);
    }
  };

  /**
   * Logout user
   * @returns {Promise<void>}
   */
  const logout = async () => {
    try {
      await apiFetch("/user/logout", {
        method: "POST",
      });
    } catch (error) {
    } finally {
      tokenCookie.value = null;
      user.value = null;

      return Promise.resolve();
    }
  };

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

  const init = async () => {
    await fetchUser();
  };

  return {
    login,
    register,
    logout,
    refresh,
    fetchUser,
    user,
    token,
    status,
    role,
    init,
  };
});

export default useAuthStore;
