/**
 * Wrapper for $fetch that handles authentication and file uploads.
 * @param {string} url An API endpoint.
 * @param {any} options An options object.
 * @returns {Promise<any>} An API response.
 */
const apiFetch = async (url, options = {}) => {
  const baseUrl = useRuntimeConfig().public.API_BASE_URL;
  const token = useCookie("token").value;

  if (token) {
    (options.headers ??= {}).Authorization = `Bearer ${token}`;
    (options.headers ??= {}).Accept = "application/json";
  }

  if (options.query) {
    url += `?${objectToQueryString(options.query)}`;

    delete options.query;
  }

  if (options.body) {
    const { payload, hasFiles } = handlePayload(options.body);

    options.body = payload;
    (options.headers ??= {})["Accept"] = "application/json";

    if (
      hasFiles &&
      ["PUT", "PATCH"].includes(options?.method?.toLocaleUpperCase())
    ) {
      options.method = "POST";
      options.query = {
        ...(options.query ?? {}),
        _method: "PATCH",
      };
    }
  }

  return $fetch(url, {
    baseURL: baseUrl,
    ...options,
  });
};

export default apiFetch;
