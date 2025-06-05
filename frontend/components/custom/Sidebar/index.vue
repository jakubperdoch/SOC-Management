<template>
  <aside
    :class="isSidebarCollapsed ? 'tw-w-0' : 'tw-w-[80px] md:tw-w-[250px]'"
    class="tw-flex tw-fixed tw-items-center md:tw-top-2 tw-flex-col tw-min-h-screen tw-bg-primary md:tw-rounded-t-2xl tw-transition-all tw-duration-300 tw-ease-in-out tw-overflow-hidden"
  >
    <NuxtLink
      class="tw-px-2 md:tw-px-8 tw-py-6 tw-font-bold tw-text-2xl tw-flex tw-items-center tw-gap-3"
      to="/frontend/public"
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
