<template>
  <aside
    :class="isSidebarCollapsed ? 'tw-w-0' : 'tw-w-[80px] md:tw-w-[250px]'"
    class="tw-flex tw-fixed tw-items-center tw-flex-col tw-min-h-screen tw-bg-primary tw-transition-all tw-duration-300 tw-ease-in-out tw-overflow-hidden"
  >
    <NuxtLink
      class="tw-w-full tw-px-2 md:tw-px-6 tw-py-6 tw-mb-3 tw-flex tw-items-center tw-justify-center"
      to="/"
    >
      <img
        alt="Logo"
        class="tw-w-full tw-max-w-24 md:tw-max-w-40 tw-transition-all tw-duration-150 tw-ease-in-out"
        src="/images/logo--light.svg"
      />
    </NuxtLink>
    <nav class="tw-flex tw-w-full tw-flex-col tw-px-4 md:tw-px-6">
      <CustomSidebarLink
        v-for="(link, index) in links"
        :key="index"
        :icon="link.icon"
        :to="link.to"
      >
        <span
          class="tw-hidden tw-font-sans md:tw-block tw-transition-all tw-duration-150 tw-ease-in-out"
          >{{ link.name }}</span
        >
      </CustomSidebarLink>
    </nav>
    <div class="tw-mt-auto tw-px-4 md:tw-p-3">
      <CustomSidebarUser />
    </div>
    <Toast />
    <ConfirmDialog />
  </aside>
</template>

<script lang="ts" setup>
interface SidebarLinkItem {
  icon: string;
  name: string;
  to: string;
}

const { isSidebarCollapsed, links } = defineProps({
  links: {
    type: Array as () => SidebarLinkItem[],
    default: () => [
      { icon: "home-simple-twotone", name: "Dashboard", to: "/dashboard" },
      { icon: "person-twotone", name: "Uživatelia", to: "/dashboard/users" },
      { icon: "file-twotone", name: "Projekty", to: "/dashboard/projects" },
      {
        icon: "alert-square-twotone-loop",
        name: "Admin nástroje",
        to: "/dashboard/admin-tools",
      },
      {
        icon: "cog-filled-loop",
        name: "Nastavenia",
        to: "/dashboard/settings",
      },
    ],
  },
  isSidebarCollapsed: {
    type: Boolean,
    default: false,
  },
});
</script>
