<template>
  <a
    :href="`/dashboard/users/details/${user.id}`"
    class="tw-bg-[url(/images/card-pattern.svg)] tw-border tw-border-white hover:tw-border-secondary tw-cursor-pointer tw-transition-all tw-duration-300 tw-ease-in-out tw-border-solid tw-bg-white tw-rounded-2xl tw-shadow-sm tw-flex tw-gap-1 tw-items-center tw-justify-center tw-font-sans tw-text-center tw-flex-col tw-px-11 tw-py-5"
  >
    <Avatar
      size="large"
      :label="user.name.charAt(0)"
      class="tw-mb-2"
      shape="circle"
    />
    <h6 class="tw-mb-0">{{ user.name }} {{ user.surname }}</h6>
    <span class="tw-capitalize">
      {{ roles.find((role) => role.value === user.role)?.label }}
    </span>
    <span class="tw-text-xs">{{ user.email }}</span>
  </a>
</template>
<script setup lang="ts">
interface User {
  id: number;
  name: string;
  surname: string;
  email: string;
  role: string;
}

const { user } = defineProps({
  user: {
    type: Object as PropType<User>,
    required: true,
  },
});

const roles = [
  {
    label: "Učiteľ",
    value: "teacher",
  },
  {
    label: "Študent",
    value: "student",
  },
  {
    label: "Administrátor",
    value: "admin",
  },
];
</script>
