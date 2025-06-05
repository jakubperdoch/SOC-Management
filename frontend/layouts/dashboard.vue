<template>
  <div class="tw-flex md:tw-p-2 tw-pb-0">
    <CustomSidebar :isSidebarCollapsed="isSidebarCollapsed" />

    <main
      :class="isSidebarCollapsed ? 'tw-pl-0' : 'tw-pl-[80px] md:tw-pl-[250px]'"
      class="tw-pb-2 tw-flex-1 tw-transition-all tw-duration-300 tw-ease-in-out"
    >
      <CustomNavbar @toggleSidebar="isSidebarCollapsed = !isSidebarCollapsed" />
      <slot />
    </main>
  </div>
</template>
<script lang="ts" setup>
const isSidebarCollapsed = ref(false);
</script>
