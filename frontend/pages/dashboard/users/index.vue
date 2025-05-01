<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Uživatelia</h1>

      <div class="tw-flex tw-gap-4">
        <SelectButton
          class="tw-font-sans"
          v-model="selectedCategory"
          :options="options"
          option-label="label"
          option-value="value"
        />
        <Button class="tw-font-sans" outlined> Pridať uživateľa </Button>
      </div>
    </div>

    <div
      class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 2xl:tw-grid-cols-5 gap-4"
    >
      <Skeleton
        v-if="isPending || isLoading"
        v-for="i in 4"
        :key="i"
        class="tw-px-11 tw-py-24"
      />

      <UserCard
        v-else
        v-for="user in users?.data"
        :key="user.id"
        :user="user"
      ></UserCard>
    </div>
  </div>
</template>
<script setup lang="ts">
import { useQuery } from "@tanstack/vue-query";

const selectedCategory = ref("teacher");
const queryKey = computed(() => ["users", selectedCategory.value]);

const {
  data: users,
  isPending,
  isLoading,
  refetch,
} = useQuery({
  queryKey: queryKey,
  queryFn: () =>
    apiFetch(`/users/${selectedCategory.value}`, {
      role: selectedCategory.value,
    }),
});

const options = [
  {
    label: "Učitelia",
    value: "teacher",
  },
  {
    label: "Študenti",
    value: "student",
  },
  {
    label: "Administrátori",
    value: "admin",
  },
];

watchEffect(() => {
  console.log(selectedCategory.value);
});

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
