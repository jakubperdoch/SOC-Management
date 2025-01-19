<template>
  <a
    type="button"
    :href="file"
    download
    class="tw-bg-white tw-rounded-2xl tw-p-5 tw-w-full !tw-transition-transform !tw-duration-500 tw-cursor-pointer hover:-tw-translate-y-4"
  >
    <div class="mb-3 ms-1">
      <div class="icon-style">
        <span class="avatar avatar-lg avatar-rounded tw-bg-secondary svg-white">
          <i class="pi pi-file !tw-text-white"></i>
        </span>
      </div>
    </div>
    <h5 class="fw-semibold">{{ title }}</h5>
    <p class="text-muted fs-15 fw-normal tw-text-black">
      {{ description }}
    </p>
  </a>
</template>
<script setup lang="ts">
const { file, title, description } = defineProps<{
  file: string;
  title: string;
  description: string;
}>();
</script>
