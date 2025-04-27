<template>
  <div class="tw-flex">
    <Sidebar :isSidebarCollapsed="isSidebarCollapsed" />

    <main class="tw-pb-2 tw-flex-1">
      <Navbar @toggleSidebar="isSidebarCollapsed = !isSidebarCollapsed" />
      <slot />
    </main>
  </div>
</template>
<script setup lang="ts">
import { Sidebar } from "#components";
const isSidebarCollapsed = ref(false);
</script>
