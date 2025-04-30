<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Hlavný panel</h1>
    </div>

    <DashboardAdminInterestGraph
      :status="statsLoading"
      :statsDataset="stats?.projectsCount ?? []"
    />
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

const {
  data: stats,
  isPending: statsPending,
  isLoading: statsLoading,
} = useQuery({
  queryKey: ["stats"],
  queryFn: () => apiFetch(`/stats`),
});

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
