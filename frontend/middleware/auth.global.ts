import useAuthStore from "~/store/auth";

export default defineNuxtRouteMiddleware((to, from) => {
  const token = useAuthStore().token;

  if (token && (to.path === "/login" || to.path === "/register")) {
    return navigateTo("/");
  }

  if (!token && to.path !== "/login" && to.path !== "/register") {
    return navigateTo("/login");
  }

  if (to.path === "/register" && !to.query.token) {
    return navigateTo("/login");
  }
});
