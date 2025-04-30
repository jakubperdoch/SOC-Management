<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Uživatelia</h1>
      <Button class="tw-font-sans" outlined> Pridať uživateľa </Button>
    </div>

    <div
      class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 2xl:tw-grid-cols-5 gap-4"
    >
      <UserCard
        v-for="user in users?.data"
        :key="user.id"
        :user="user"
      ></UserCard>
    </div>
  </div>
</template>
<script setup lang="ts">
import { useQuery } from "@tanstack/vue-query";
const selectedCategory = ref("teacher");

const {
  data: users,
  isPending,
  isLoading,
} = useQuery({
  queryKey: ["users"],
  queryFn: () =>
    apiFetch(`/users/${selectedCategory.value}`, {
      role: selectedCategory.value,
    }),
});

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
