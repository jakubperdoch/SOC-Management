<template>
  <nav
    class="tw-flex tw-items-center tw-justify-between tw-font-sans tw-px-8 tw-py-4 tw-w-full"
  >
    <Button variant="link" @click="handleToggleSidebar">
      <i class="pi pi-bars tw-tet-primary tw-text-lg"></i>
    </Button>

    <div class="tw-flex tw-items-center tw-gap-4">
      <OverlayBadge size="small" value="4" severity="danger">
        <i class="pi pi-bell tw-text-primary tw-text-lg tw-cursor-pointer" />
      </OverlayBadge>
    </div>
  </nav>
</template>

<script setup lang="ts">
const emits = defineEmits(["toggleSidebar"]);

const handleToggleSidebar = () => {
  emits("toggleSidebar");
};
</script>
