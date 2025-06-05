<template>
  <div class="tw-flex tw-flex-col tw-gap-3">
    <Skeleton v-if="!authStore.user" class="tw-rounded-2xl" height="13rem" />
    <section
      v-else
      class="tw-bg-[url(/images/card-pattern.svg)] tw-border tw-border-white hover:tw-border-secondary tw-cursor-pointer tw-transition-all tw-duration-300 tw-ease-in-out tw-border-solid tw-bg-white tw-rounded-2xl tw-shadow-sm tw-flex tw-gap-1 tw-items-center tw-justify-center tw-font-sans tw-text-center tw-flex-col tw-px-11 tw-py-5"
    >
      <div class="tw-grid tw-grid-cols-3 tw-w-full">
        <Avatar
          class="tw-bg-[url(/images/card-pattern.svg)] tw-justify-self-center tw-col-start-2"
          icon="pi pi-user"
          size="xlarge"
        />

        <Button
          aria-label="Filter"
          class="tw-col-start-3 hover:!tw-text-secondary tw-justify-self-end tw-self-start"
          icon="pi pi-pencil"
          rounded
          variant="text"
        />
      </div>
      <div class="tw-flex tw-flex-col tw-items-center tw-gap-1">
        <h2 class="tw-text-lg tw-font-semibold tw-font-sans">
          {{ authStore.user?.name }} {{ authStore.user?.surname }}
        </h2>
        <span class="tw-text-sm tw-text-gray-500">
          {{ authStore.user?.email }}
        </span>

        <Tag
          v-if="authStore.user?.role"
          :severity="defineRole(authStore.user.role).severity"
          class="tw-mt-2 tw-w-fit"
        >
          {{ defineRole(authStore.user.role).title }}
        </Tag>
      </div>
    </section>
  </div>
</template>

<script lang="ts" setup>
import useAuthStore from "~/store/auth";

const authStore = useAuthStore();

const defineRole = (role: string) => {
  switch (role) {
    case "student":
      return {
        title: "Študent",
        severity: "info",
      };
    case "teacher":
      return {
        title: "Učiteľ",
        severity: "success",
      };
    case "admin":
      return {
        title: "Administrátor",
        severity: "danger",
      };
    default:
      return {
        title: "Neznáma rola",
        severity: "secondary",
      };
  }
};
</script>
