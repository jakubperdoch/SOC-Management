<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Projekty</h1>
      <Button class="tw-font-sans" outlined>Pridať projekt</Button>
    </div>

    <ProjectTable
      :cells="projects?.projects ?? []"
      :is-loading="isProjectsLoading || isProjectsPending"
    />
  </div>
</template>
<script setup lang="ts">
import { useQuery } from "@tanstack/vue-query";

const {
  data: projects,
  isPending: isProjectsPending,
  isLoading: isProjectsLoading,
} = useQuery({
  queryKey: ["projects"],
  queryFn: () => apiFetch(`/projects`),
});

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
