<template>
  <div class="tw-flex md:tw-p-2 tw-pb-0">
    <Sidebar :isSidebarCollapsed="isSidebarCollapsed" />

    <main
      class="tw-pb-2 tw-flex-1 tw-transition-all tw-duration-300 tw-ease-in-out"
      :class="isSidebarCollapsed ? 'tw-pl-0' : 'tw-pl-[80px] md:tw-pl-[240px]'"
    >
      <Navbar @toggleSidebar="isSidebarCollapsed = !isSidebarCollapsed" />
      <slot />
    </main>
  </div>
</template>
<script setup lang="ts">
import { Sidebar } from "#components";
const isSidebarCollapsed = ref(false);
</script>
