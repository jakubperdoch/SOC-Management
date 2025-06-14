<template>
  <div
    class="tw-group tw-bg-[url(@/public/images/FileCard-bg.jpg)] tw-relative tw-rounded-lg tw-block tw-bg-cover tw-bg-center tw-h-52 tw-w-44 tw-flex-shrink"
  >
    <div
      class="tw-absolute tw-rounded-lg tw-bg-black/50 tw-w-full tw-h-full"
    ></div>

    <div
      class="tw-bg-secondary hover:tw-cursor-pointer tw-absolute tw-z-[2] tw-right-3 tw-top-3 tw-rounded-full tw-w-9 tw-h-9 tw-flex tw-items-center tw-justify-center tw-scale-0 tw-transition tw-duration-200 group-hover:tw-scale-100"
      @click="handleEdit"
    >
      <Icon height="19" icon="line-md:edit-twotone" width="18" />
    </div>

    <div
      class="tw-bg-red-500 hover:tw-cursor-pointer tw-absolute tw-z-[2] tw-right-14 tw-top-3 tw-rounded-full tw-w-9 tw-h-9 tw-flex tw-items-center tw-justify-center tw-scale-0 tw-transition tw-duration-200 group-hover:tw-scale-100"
      @click="handleDelete"
    >
      <Icon height="19" icon="ic:twotone-delete" width="18" />
    </div>

    <span
      class="tw-absolute tw-z-[2] tw-bottom-3 tw-left-3 tw-text-white tw-font-sans tw-text-base"
      >{{ file.name }}</span
    >
  </div>
</template>
<script lang="ts" setup>
import { Icon } from "@iconify/vue";

const { file } = defineProps<{
  file: {
    id: number;
    name: string;
    url: string;
  };
}>();

const emit = defineEmits<{
  (e: "edit", file: { id: number }): void;
  (e: "delete", file: { id: number }): void;
}>();

const handleEdit = () => {
  emit("edit", { id: file.id });
};

const handleDelete = () => {
  emit("delete", { id: file.id });
};
</script>
