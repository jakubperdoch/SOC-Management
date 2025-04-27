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
      const response = await apiFetch("/login", {
        method: "POST",
        body: credentials,
      });

      const { userData } = response;

      // const { token: userToken, ...userData } = response;
      // Generate a mock token
      const randomBytes = crypto.getRandomValues(new Uint8Array(16));
      const randomToken = Array.from(randomBytes)
        .map((b) => b.toString(16).padStart(2, "0"))
        .join("");

      user.value = userData;
      tokenCookie.value = randomToken;

      return Promise.resolve(userData);
    } catch (error) {
      return Promise.reject(error);
    }
  };

  const register = async (credentials: any) => {
    try {
      const response = await apiFetch("/register", {
        method: "POST",
        body: credentials,
      });

      const { userData } = response;

      // const { token: userToken, ...userData } = response;
      // Generate a mock token
      const randomBytes = crypto.getRandomValues(new Uint8Array(16));
      const randomToken = Array.from(randomBytes)
        .map((b) => b.toString(16).padStart(2, "0"))
        .join("");

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
      const response = await apiFetch("/student/info");

      // user.value = response;
      console.log(response);

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
  };
});

export default useAuthStore;
