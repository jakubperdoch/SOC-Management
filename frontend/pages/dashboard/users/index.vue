<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Uživatelia</h1>

      <div class="tw-flex tw-gap-4">
        <InputText
          placeholder="Hľadať užívateľov"
          size="small"
          v-model="search"
        />
        <SelectButton
          class="tw-font-sans"
          v-model="selectedCategory"
          :options="options"
          option-label="label"
          option-value="value"
          size="small"
        />
        <Button
          class="tw-font-sans"
          outlined
          size="small"
          @click="isModalVisible = !isModalVisible"
        >
          Pridať uživateľa
        </Button>
      </div>
    </div>

    <div
      class="tw-grid md:tw-grid-rows-4 tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 2xl:tw-grid-cols-5 gap-4"
    >
      <Skeleton
        v-if="isPending || isLoading"
        v-for="i in 4"
        :key="i"
        class="tw-px-11 tw-py-24"
      />

      <h3
        v-if="!isPending && !isLoading && users?.data.length === 0"
        class="tw-col-span-1 sm:tw-col-span-2 lg:tw-col-span-4 2xl:tw-col-span-5 tw-flex tw-items-center tw-justify-center tw-gap-4"
      >
        <div class="tw-col-span-5 tw-text-center tw-p-4">
          <h2
            class="tw-text-xl tw-font-semibold tw-font-sans tw-mb-0 tw-text-gray-500"
          >
            Žiadny užívateľ nenájdený
          </h2>
        </div>
      </h3>

      <UserCard
        v-else
        v-for="user in users?.data"
        :key="user.id"
        :user="user"
      ></UserCard>
    </div>
    <Paginator
      v-show="!isPending && !isLoading && users?.data.length > 0"
      :rows="users?.per_page"
      :totalRecords="users?.total"
      v-model="pagination"
      @page="handlePage"
    ></Paginator>
  </div>

  <UserDialog
    :visible="isModalVisible"
    @update:visible="(value) => (isModalVisible = value)"
  />
</template>
<script setup lang="ts">
import { useQuery } from "@tanstack/vue-query";

const selectedCategory = ref("teacher");
const isModalVisible = ref(false);
const pagination = ref({
  page: 1,
});
const search = ref("");

const queryKey = computed(() => [
  "users",
  selectedCategory.value,
  pagination.value.page,
  search.value,
]);

const {
  data: users,
  isPending,
  isLoading,
} = useQuery({
  queryKey: queryKey,
  queryFn: () =>
    apiFetch(
      `/users/${selectedCategory.value}?page=${pagination.value.page}&search=${search.value}`,
      {
        role: selectedCategory.value,
      },
    ),
});

const handlePage = (event: { page: number }) => {
  pagination.value.page = event.page + 1;
};

const options = [
  {
    label: "Všetci",
    value: "all",
  },
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

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
