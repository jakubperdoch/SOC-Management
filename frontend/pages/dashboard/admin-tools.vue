<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Admin Nástroje</h1>
    </div>

    <section class="tw-grid tw-grid-cols-1 tw-gap-6">
      <ExportDatabaseSection />
      <DocumentManagementSection />
      <StudyFieldsSection />
    </section>
  </div>
</template>

<script lang="ts" setup>
import ExportDatabaseSection from "~/components/sections/admin/ExportDatabaseSection.vue";
import DocumentManagementSection from "~/components/sections/admin/DocumentManagementSection.vue";
import StudyFieldsSection from "~/components/sections/admin/StudyFieldsSection.vue";

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
