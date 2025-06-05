<template>
  <div
    v-if="!authStore.user?.name"
    class="tw-flex tw-gap-3 tw-items-center tw-justify-center md:tw-px-3 tw-py-[10px] tw-cursor-pointer"
  >
    <Skeleton borderRadius="6px" height="2rem" width="2rem" />
    <Skeleton borderRadius="6px" height="1.2rem" width="5rem" />
  </div>

  <div
    v-else
    class="tw-flex tw-gap-3 tw-items-center tw-justify-center md:tw-px-3 tw-py-[10px] tw-cursor-pointer"
    @click="handleLogout"
  >
    <Avatar :label="authStore.user?.name.charAt(0).toUpperCase()" size="xl" />

    <span
      class="tw-text-sm tw-font-semibold tw-text-white tw-hidden md:tw-block tw-transition-all tw-duration-150 tw-ease-in-out"
      >{{ `${authStore.user?.name} ${authStore.user?.surname}` }}</span
    >
  </div>
</template>

<script setup>
import useAuthStore from "~/store/auth";

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
