<template>
  <nav class="tw-flex tw-font-sans tw-px-8 tw-py-4 tw-bg-primary tw-w-full">
    <Button variant="link" @click="handleToggleSidebar">
      <i class="pi pi-bars tw-text-white tw-text-lg"></i>
    </Button>
  </nav>
</template>

<script setup lang="ts">
const emits = defineEmits(["toggleSidebar"]);

const handleToggleSidebar = () => {
  emits("toggleSidebar");
};
</script>
