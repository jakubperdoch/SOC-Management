<template>
  <a
    :href="file.url"
    class="tw-group tw-bg-[url(@/public/images/FileCard-bg.jpg)] tw-relative tw-rounded-lg tw-block tw-bg-cover tw-bg-center lg:tw-h-72 lg:tw-w-64 tw-h-52 tw-w-40 tw-flex-shrink"
    download
  >
    <div
      class="tw-absolute tw-rounded-lg tw-bg-black/50 tw-w-full tw-h-full"
    ></div>

    <div
      class="tw-bg-secondary tw-absolute tw-z-[2] tw-right-3 tw-top-3 tw-rounded-full tw-w-10 tw-h-10 tw-flex tw-items-center tw-justify-center tw-scale-0 tw-transition tw-duration-300 group-hover:tw-scale-100"
    >
      <Icon icon="fluent:arrow-download-20-filled" width="24" height="25" />
    </div>

    <span
      class="tw-absolute tw-z-[2] tw-bottom-3 tw-left-3 tw-text-white tw-font-sans tw-text-base md:tw-text-xl"
      >{{ file.name }}</span
    >
  </a>
</template>
<script setup lang="ts">
import { Icon } from "@iconify/vue";

const { file } = defineProps<{
  file: {
    name: string;
    url: string;
  };
}>();
</script>
