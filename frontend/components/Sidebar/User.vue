<template>
  <div
    class="tw-flex tw-gap-3 tw-items-center tw-justify-center md:tw-px-3 tw-py-[10px] tw-cursor-pointer"
    @click="handleLogout"
  >
    <Avatar size="xl" :label="authStore.user?.name.charAt(0).toUpperCase()" />
    <span
      class="tw-text-sm tw-font-semibold tw-text-white tw-hidden md:tw-block tw-transition-all tw-duration-150 tw-ease-in-out"
      >{{
        authStore.user?.name
          ? `${authStore.user?.name} ${authStore.user?.surname}`
          : "Neznámy používateľ"
      }}</span
    >
  </div>
</template>

<script setup>
import useAuthStore from "~/store/auth";
import { useQuery } from "@tanstack/vue-query";

const confirm = useConfirm();

const authStore = useAuthStore();

function handleLogout() {
  confirm.require({
    header: "Odhlásenie",
    message: "Skutočne sa chcete odhlásiť?",
    acceptLabel: "Áno, odhlásiť",
    rejectLabel: "Nie",
    rejectClass:
      "flex items-center gap-2 font-bold text-sm py-[10px] px-4 rounded-md",
    acceptClass:
      "flex items-center gap-2 font-bold text-sm py-[10px] px-4 rounded-md bg-[#EF4444] text-white",
    accept: async () => {
      await authStore.logout();
      navigateTo({ path: "/login" });
    },
  });
}
</script>
