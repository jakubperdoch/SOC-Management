<template>
  <aside
    class="tw-flex tw-fixed md:tw-top-2 tw-flex-col tw-min-h-screen tw-bg-primary md:tw-rounded-t-2xl tw-transition-all tw-duration-300 tw-ease-in-out tw-overflow-hidden"
    :class="isSidebarCollapsed ? 'tw-w-0' : 'tw-w-[80px] md:tw-w-[240px]'"
  >
    <NuxtLink
      to="/"
      class="tw-px-2 md:tw-px-8 tw-py-6 tw-font-bold tw-text-2xl tw-flex tw-items-center tw-gap-3"
    >
      <img
        src="/images/logo--light.svg"
        class="tw-w-full tw-max-w-24 md:tw-max-w-40 tw-transition-all tw-duration-150 tw-ease-in-out"
        alt="Logo"
      />
    </NuxtLink>
    <nav class="tw-flex tw-flex-col tw-px-4 md:tw-px-6">
      <SidebarLink
        v-for="link in links"
        :key="link.name"
        :to="link.to"
        :icon="link.icon"
      >
        <span
          class="tw-hidden tw-font-sans md:tw-block tw-transition-all tw-duration-150 tw-ease-in-out"
          >{{ link.name }}</span
        >
      </SidebarLink>
    </nav>
    <div class="tw-mt-auto tw-px-4 md:tw-p-3">
      <SidebarUser />
    </div>
    <Toast />
    <ConfirmDialog />
  </aside>
</template>

<script setup lang="ts">
const { isSidebarCollapsed, links } = defineProps({
  links: {
    type: Array,
    default: () => [
      { icon: "home", name: "Dashboard", to: "/dashboard" },
      { icon: "users", name: "Uživatelia", to: "/dashboard/users" },
      { icon: "file", name: "Projekty", to: "/dashboard/projects" },
      { icon: "wrench", name: "Nastavenia", to: "/dashboard/settings" },
    ],
  },
  isSidebarCollapsed: {
    type: Boolean,
    default: false,
  },
});
</script>
