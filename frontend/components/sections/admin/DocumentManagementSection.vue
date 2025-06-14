<template>
  <section class="tw-mb-8 tw-col-span-2">
    <h5 class="tw-text-lg tw-font-semibold tw-font-sans tw-text-gray-800">
      Správa dokumentov.
    </h5>
    <p class="tw-text-sm tw-font-sans tw-text-gray-600 tw-max-w-md">
      Tu môžete spravovať dokumenty, ktoré sa používajú v systéme.
    </p>

    <div class="tw-flex tw-flex-wrap tw-gap-4 tw-mt-4">
      <DocumentCard v-for="file in files" :file />
    </div>
  </section>
</template>
<script lang="ts" setup>
import DocumentCard from "~/components/custom/Admin/DocumentCard.vue";

const files = ref([
  { name: "Prezentácia", url: "url1" },
  { name: "Dokumentácia", url: "url2" },
  { name: "Pokyny 2025/2026", url: "url3" },
  { name: "Harmonogram", url: "url4" },
]);
</script>
