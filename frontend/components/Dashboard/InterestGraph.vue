<template>
  <Skeleton v-if="status" height="30rem" borderRadius="16px" />
  <div
    v-else
    class="card custom-card tw-col-span-1 tw-p-4 !tw-font-sans !tw-mb-0 !tw-h-fit"
  >
    <Radar :data="data" :options="options" />
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { Radar } from "vue-chartjs";
import {
  Chart as ChartJS,
  Tooltip,
  Legend,
  RadialLinearScale,
  PointElement,
  LineElement,
  Filler,
  type ChartData,
  type ChartOptions,
} from "chart.js";

const { statsDataset, status } = defineProps<{
  statsDataset: number[];
  status: boolean;
}>();

ChartJS.register(
  RadialLinearScale,
  PointElement,
  LineElement,
  Filler,
  Tooltip,
  Legend,
);

const data = ref<ChartData<"radar">>({
  labels: [
    "Informatika",
    "Strojárstvo",
    "Elektrotechnika",
    "Logistika",
    "Učebné pomôcky",
  ],
  datasets: [
    {
      label: "Odborné zameranie",
      backgroundColor: "rgba(134, 199, 37, 0.1)",
      borderColor: "rgba(134, 199, 37, 1)",
      pointBackgroundColor: "rgba(134, 199, 37, 1)",
      pointBorderColor: "#fff",
      pointHoverBackgroundColor: "#fff",
      pointHoverBorderColor: "rgba(134, 199, 37, 1)",
      data: [],
    },
  ],
});

watch(
  () => statsDataset,
  (newDataset) => {
    data.value.datasets[0].data = newDataset;
    console.log(status);
  },
  { immediate: true },
);

const options = ref<ChartOptions<"radar">>({
  responsive: true,
});
</script>
