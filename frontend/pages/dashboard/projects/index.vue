<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Projekty</h1>
      <Button
        class="tw-font-sans tw-shadow-sm"
        outlined
        size="small"
        @click="isModalVisible = !isModalVisible"
        >Pridať projekt
      </Button>
    </div>

    <CustomProjectTable
      :cells="projects?.projects ?? []"
      :is-loading="isProjectsLoading || isProjectsPending"
    />
  </div>

  <CustomProjectDialog
    :visible="isModalVisible"
    @update:visible="(value) => (isModalVisible = value)"
  />
</template>
<script lang="ts" setup>
import { useQuery } from "@tanstack/vue-query";

const isModalVisible = ref(false);

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
