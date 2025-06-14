<template>
  <Skeleton v-if="status" borderRadius="16px" height="20rem" />

  <div
    v-else
    class="tw-bg-white tw-p-4 tw-rounded-lg tw-col-span-1 !tw-font-sans !tw-mb-0 !tw-h-fit"
  >
    <div class="tw-flex tw-items-center tw-justify-between">
      <h2 class="tw-text-lg tw-font-semibold tw-font-sans tw-mb-0">
        Vaše projekty
      </h2>
      <Button
        severity="primary"
        size="small"
        @click="router.push('/projects/create')"
      >
        Nový projekt
        <i class="pi pi-plus"></i>
      </Button>
    </div>
    
    <Divider />

    <div class="!tw-h-fit">
      <div class="tw-mb-3 tw-flex tw-items-center">
        <h4 class="fw-bold tw-mb-0">{{ data.overall }}</h4>
        <div class="tw-ms-2">
          <span class="text-muted ms-1"> Celkový počet projektov </span>
        </div>
      </div>
      <div class="progress-stacked progress-animate progress-xs mb-4">
        <div
          :style="{
            width: `${percentageCalc(data.openStatus, data.overall)}%`,
          }"
          aria-valuemax="100"
          aria-valuemin="0"
          aria-valuenow="21"
          class="progress-bar bg-success"
          role="progressbar"
        ></div>
        <div
          :style="{
            width: `${percentageCalc(data.waitingStatus, data.overall)}%`,
          }"
          aria-valuemax="100"
          aria-valuemin="0"
          aria-valuenow="26"
          class="progress-bar bg-info"
          role="progressbar"
        ></div>
        <div
          :style="{
            width: `${percentageCalc(data.takenStatus, data.overall)}%`,
          }"
          aria-valuemax="100"
          aria-valuemin="0"
          aria-valuenow="18"
          class="progress-bar bg-warning"
          role="progressbar"
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

<script lang="ts" setup>
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
