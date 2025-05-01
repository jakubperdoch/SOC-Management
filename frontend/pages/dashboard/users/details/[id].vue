<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">
        Údaje o užívateľovi
      </h1>

      <div class="tw-flex tw-gap-4">
        <Button
          size="medium"
          class="tw-font-sans"
          @click="toggleEdit"
          :outlined="!isEditMode"
          :severity="isEditMode ? 'success' : 'primary'"
        >
          {{ isEditMode ? "Uložiť" : "Upraviť" }}
        </Button>

        <Button
          class="tw-font-sans tw-transition-all tw-duration-300 tw-ease-in-out"
          :class="{ 'tw-hidden': !isEditMode }"
          outlined
          severity="warning"
          @click="toggleEdit"
        >
          Zrušiť
        </Button>

        <Button
          class="tw-font-sans tw-flex tw-items-center"
          outlined
          severity="danger"
        >
          <Trash2 class="tw-mr-1" />
          Odstrániť
        </Button>
      </div>
    </div>
    <div>
      <div class="tw-flex tw-items-center tw-gap-4 tw-mb-4">
        <Avatar size="large" :label="userInitial" shape="circle" />
        <h2 class="tw-text-xl tw-mb-0 tw-font-medium">
          {{ userForm.name }} {{ userForm.surname }}
        </h2>
      </div>

      <!-- Form Grid -->
      <form
        @submit.prevent="saveUser"
        class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4"
      >
        <!-- First Name -->
        <div class="tw-flex tw-flex-col">
          <label class="tw-mb-1">Meno</label>
          <InputText
            v-model="userForm.name"
            :disabled="!isEditMode"
            placeholder="Zadajte meno"
          />
        </div>

        <!-- Surname -->
        <div class="tw-flex tw-flex-col">
          <label class="tw-mb-1">Priezvisko</label>
          <InputText
            v-model="userForm.surname"
            :disabled="!isEditMode"
            placeholder="Zadajte priezvisko"
          />
        </div>

        <!-- Email (full-width on mobile) -->
        <div class="tw-flex tw-flex-col md:tw-col-span-2">
          <label class="tw-mb-1">Email</label>
          <InputText
            v-model="userForm.email"
            :disabled="!isEditMode"
            placeholder="Zadajte email"
            type="email"
          />
        </div>

        <!-- Role -->
        <div class="tw-flex tw-flex-col">
          <label class="tw-mb-1">Rola</label>
          <Select
            class="tw-text-base"
            v-model="userForm.role"
            :options="roles"
            optionLabel="name"
            optionValue="code"
            :disabled="!isEditMode"
            placeholder="Vyberte rolu"
          />
        </div>
      </form>
    </div>
  </div>
</template>
<script setup lang="ts">
import { useQuery } from "@tanstack/vue-query";
import { Trash2 } from "lucide-vue-next";

const params = useRoute().params;

const isEditMode = ref(false);

const toggleEdit = () => {
  if (isEditMode.value) saveUser();
  isEditMode.value = !isEditMode.value;
};

const cancelEdit = () => {
  isEditMode.value = false;
};

const saveUser = async () => {};

const deleteUser = () => {};

const userInitial = computed(() => userForm.value.name.charAt(0) || "");

const userForm = ref({
  name: "",
  surname: "",
  email: "",
  role: "",
});

const {
  data: user,
  isPending,
  isLoading,
} = useQuery({
  queryKey: ["user", params?.id],
  queryFn: () => apiFetch(`/user/${params?.id}`),
  enabled: !!params?.id,
});

watchEffect(() => {
  if (user.value) {
    userForm.value.name = user.value.user.name;
    userForm.value.surname = user.value.user.surname;
    userForm.value.email = user.value.user.email;
    userForm.value.role = user.value.user.role;
  }

  console.log(userForm.value);
});

const roles = [
  { name: "Učiteľ", code: "teacher" },
  { name: "Študent", code: "student" },
  { name: "Admin", code: "admin" },
];

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
