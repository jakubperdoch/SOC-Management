<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Hlavný panel</h1>
    </div>

    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
      <StatusGraph
        :data="stats?.projectsStats ?? []"
        :status="statsLoading || statsPending"
      />

      <InterestGraph
        :statsDataset="stats?.projectsCount ?? []"
        :status="statsLoading || statsPending"
      />
    </div>
  </div>
</template>
<script lang="ts" setup>
import { useQuery } from "@tanstack/vue-query";
import StatusGraph from "~/components/custom/Dashboard/StatusGraph.vue";
import InterestGraph from "~/components/custom/Dashboard/InterestGraph.vue";

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
