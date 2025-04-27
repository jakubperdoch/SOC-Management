import useAuthStore from "~/store/auth";

export default defineNuxtRouteMiddleware((to, from) => {
  const token = useAuthStore().token;

  if (to.path === "/login" && token) {
    return navigateTo("/");
  }

  if (to.path !== "/login" && !token) {
    return navigateTo("/login");
  }
});
