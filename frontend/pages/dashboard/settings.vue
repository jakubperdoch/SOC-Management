<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Nastavenia</h1>
    </div>

    <div class="tw-grid tw-grid-cols-2 tw-gap-4">
      <div class="tw-grid tw-grid-rows-2 tw-gap-4">
        <LinkInput
          v-for="(link, index) in links"
          :key="index"
          :description="link.description"
          :role="link.role"
          :title="link.title"
        />
      </div>

      <div class="tw-grid tw-grid-rows-2 tw-gap-4">
        <LinkInput
          v-for="(link, index) in links"
          :key="index"
          :description="link.description"
          :role="link.role"
          :title="link.title"
        />
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import LinkInput from "~/components/Settings/LinkInput.vue";

const links = ref([
  {
    title: "Link pre registráciu do systému (študenti)",
    description:
      "Tento link je určený pre študentov, ktorí sa chcú zaregistrovať do systému.",
    role: "student",
  },
  {
    title: "Link pre registráciu do systému (učitelia)",
    description:
      "Tento link je určený pre učiteľov, ktorí sa chcú zaregistrovať do systému.",
    role: "teacher",
  },
]);

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
