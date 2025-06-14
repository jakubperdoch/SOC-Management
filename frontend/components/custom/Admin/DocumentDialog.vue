<template>
  <Dialog
    v-model:visible="isDialogVisible"
    :style="{ width: '25rem' }"
    header="Edit Profile"
    modal
  >
    <span class="text-surface-500 dark:text-surface-400 block mb-8"
      >Update your information.</span
    >
    <p>{{ props?.documentId }}</p>
    <div class="flex items-center gap-4 mb-4">
      <label class="font-semibold w-24" for="username">Username</label>
      <InputText id="username" autocomplete="off" class="flex-auto" />
    </div>
    <div class="flex items-center gap-4 mb-8">
      <label class="font-semibold w-24" for="email">Email</label>
      <InputText id="email" autocomplete="off" class="flex-auto" />
    </div>
    <div class="flex justify-end gap-2">
      <Button
        label="Cancel"
        severity="secondary"
        type="button"
        @click="isDialogVisible = false"
      ></Button>
      <Button
        label="Save"
        type="button"
        @click="isDialogVisible = false"
      ></Button>
    </div>
  </Dialog>
</template>
<script lang="ts" setup>
const props = defineProps<{
  isVisible: boolean;
  documentId: number | null;
}>();

const emit = defineEmits<{
  (e: "update:isVisible", value: boolean): void;
}>();

const isDialogVisible = ref(props.isVisible);

watch(
  () => props.isVisible,
  (newVal) => {
    isDialogVisible.value = newVal;
  },
);

watch(isDialogVisible, (newVal) => {
  emit("update:isVisible", newVal);
});
</script>
