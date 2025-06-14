<template>
  <section class="tw-mb-8 tw-col-span-2">
    <h5 class="tw-text-lg tw-font-semibold tw-font-sans tw-text-gray-800">
      Študijné odbory
    </h5>
    <p class="tw-text-sm tw-font-sans tw-text-gray-600">
      Tu môžete spravovať študijné odbory, ktoré sú dostupné v systéme.
    </p>

    <div class="tw-grid tw-grid-cols-2 tw-gap-2">
      <StudyCard v-for="field in studyFields" :study-field="field" />
    </div>
  </section>
</template>
<script lang="ts" setup>
import StudyCard from "~/components/custom/Admin/StudyCard.vue";

interface studyField {
  id: number;
  idOfField: number;
  name: string;
  description: string;
  duration: string;
  isActive: boolean;
}

const studyFields = ref<studyField[]>([
  {
    id: 1,
    idOfField: 504,
    name: "Informatika",
    description: "Študijný odbor zameraný na informatiku a počítačové vedy.",
    duration: "4 roky",
    isActive: true,
  },
  {
    id: 2,
    idOfField: 503,
    name: "Elektrotechnika",
    description: "Študijný odbor zameraný na elektrotechniku a elektroniku.",
    duration: "4 roky",
    isActive: true,
  },
  {
    id: 3,
    idOfField: 502,
    name: "Strojárstvo",
    description: "Študijný odbor zameraný na strojárstvo a mechaniku.",
    duration: "4 roky",
    isActive: false,
  },
  {
    id: 5,
    idOfField: 501,
    name: "Logistika",
    description: "Študijný odbor zameraný na logistiku a dopravu.",
    duration: "4 roky",
    isActive: true,
  },
]);
</script>
