<template>
  <div
    class="tw-bg-[url(/images/card-pattern.svg)] bg-white tw-rounded-2xl tw-shadow-sm tw-flex tw-gap-1 tw-items-center tw-justify-center tw-font-sans tw-text-center tw-flex-col tw-px-11 tw-py-5"
  >
    <Avatar
      size="large"
      :label="user.name.charAt(0)"
      class="tw-mb-2"
      shape="circle"
    />
    <h6 class="tw-mb-0">{{ user.name }} {{ user.surname }}</h6>
    <span class="tw-capitalize">{{ user.role }}</span>
    <span class="tw-text-xs">{{ user.email }}</span>
  </div>
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
</script>
