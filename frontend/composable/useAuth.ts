/**
 * Auth composable for managing user state throughout application
 */

type User = {
  id: number;
  name: string | null;
  surname: string | null;
  email: string | null;
  role: string | null;
};

function useAuth() {
  const user = ref<User | null>(null);
  const status = computed(() =>
    user.value ? "authenticated" : "unauthenticated",
  );
  const token = useCookie("token");

  /**
   * Login user
   * @param {string} login
   * @param {string} password
   * @returns {Promise<object>}
   */
  const login = async (email: string, password: string) => {
    try {
      const response = await apiFetch("/login", {
        method: "POST",
        body: {
          email,
          password,
        },
      });

      const { user } = response;

      updateUser(user);
      generateToken();

      await getUser();

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
    token.value = null;
    user.value = null;
    navigateTo("/");

    return Promise.resolve();
  };

  const register = async (
    name: string,
    surname: string,
    email: string,
    password: string,
    role: string,
  ) => {
    try {
      const response = await apiFetch("/register", {
        method: "POST",
        body: {
          name,
          surname,
          email,
          password,
          role,
        },
      });

      navigateTo("/auth/login");

      return Promise.resolve(response);
    } catch (error) {
      return Promise.reject(error);
    }
  };

  /**
   * Generate random token
   */
  /**
   * Generate random token with user.id included
   */
  const generateToken = () => {
    if (!user.value) return;
    const randomString = Math.random().toString(36).substring(2);
    token.value = `Bearer ${randomString}_${user.value.id}`;
  };

  /**
   * Get user ID from token
   * @returns {number | null}
   */

  const getUserIdFromToken = () => {
    if (!token.value) return null;

    const parts = token.value.split("_");
    return parts.length > 1 ? parseInt(parts[1], 10) : null;
  };

  /**
   * Fetch user data
   * @returns {Promise<void>}
   */

  const getUser = async () => {
    if (!token.value) {
      return;
    }

    try {
      const response = await apiFetch("/student/info", {
        method: "POST",
        body: {
          id: getUserIdFromToken(),
        },
      });

      const { user } = response;
      updateUser(user);

      return Promise.resolve(response);
    } catch (error) {
      return Promise.reject(error);
    }
  };

  return {
    user,
    status,
    login,
    logout,
    updateUser,
    getUser,
    register,
    getUserIdFromToken,
  };
}

export default useAuth;
