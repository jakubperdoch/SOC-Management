<template>
  <Skeleton v-if="status" height="20rem" borderRadius="16px" />

  <div
    v-else
    class="card custom-card tw-col-span-1 !tw-font-sans !tw-mb-0 !tw-h-fit"
  >
    <div class="card-header justify-content-between">
      <div class="card-title">Vaše projekty</div>
      <Button
        size="small"
        severity="primary"
        @click="router.push('/projects/create')"
      >
        Nový projekt
        <i class="pi pi-plus"></i>
      </Button>
    </div>
    <div class="card-body !tw-h-fit">
      <div class="d-flex align-items-center mb-3">
        <h4 class="fw-bold mb-0">{{ data.overall }}</h4>
        <div class="ms-2">
          <span class="text-muted ms-1"> Celkový počet projektov </span>
        </div>
      </div>
      <div class="progress-stacked progress-animate progress-xs mb-4">
        <div
          class="progress-bar bg-success"
          role="progressbar"
          :style="{
            width: `${percentageCalc(data.openStatus, data.overall)}%`,
          }"
          aria-valuenow="21"
          aria-valuemin="0"
          aria-valuemax="100"
        ></div>
        <div
          class="progress-bar bg-info"
          role="progressbar"
          :style="{
            width: `${percentageCalc(data.waitingStatus, data.overall)}%`,
          }"
          aria-valuenow="26"
          aria-valuemin="0"
          aria-valuemax="100"
        ></div>
        <div
          class="progress-bar bg-warning"
          role="progressbar"
          :style="{
            width: `${percentageCalc(data.takenStatus, data.overall)}%`,
          }"
          aria-valuenow="18"
          aria-valuemin="0"
          aria-valuemax="100"
        ></div>
      </div>
      <ul class="list-unstyled mb-0 pt-2 crm-deals-status">
        <li class="success">
          <div class="d-flex align-items-center justify-content-between">
            <div>Voľné projekty</div>
            <div class="fs-12 text-muted">{{ data.openStatus }}</div>
          </div>
        </li>
        <li class="info">
          <div class="d-flex align-items-center justify-content-between">
            <div>Čakajuče projekty</div>
            <div class="fs-12 text-muted">{{ data.waitingStatus }}</div>
          </div>
        </li>
        <li class="warning">
          <div class="d-flex align-items-center justify-content-between">
            <div>Zabrané projekty</div>
            <div class="fs-12 text-muted">{{ data.takenStatus }}</div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from "#app";

interface Stat {
  overall: number;
  openStatus: number;
  waitingStatus: number;
  takenStatus: number;
}

const router = useRouter();
const { data, status } = defineProps<{
  data: Stat;
  status: boolean;
}>();

const percentageCalc = (value: number, total: number) => {
  return (value / total) * 100;
};
</script>
