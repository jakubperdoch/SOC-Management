<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">
        Údaje o užívateľovi
      </h1>

      <div class="tw-flex tw-gap-4">
        <Button
          :disabled="isPending || isLoading"
          :outlined="!isEditMode"
          :severity="isEditMode ? 'success' : 'primary'"
          class="tw-font-sans"
          size="small"
          @click="toggleEdit"
        >
          {{ isEditMode ? "Uložiť" : "Upraviť" }}
        </Button>

        <Button
          :class="{ 'tw-hidden': !isEditMode }"
          class="tw-font-sans tw-transition-all tw-duration-300 tw-ease-in-out"
          outlined
          severity="warning"
          size="small"
          @click="cancelEdit"
        >
          Zrušiť
        </Button>

        <Button
          :disabled="isPending || isLoading"
          class="tw-font-sans tw-flex tw-items-center"
          outlined
          severity="danger"
          size="small"
        >
          <Trash2 class="tw-mr-1" />
          Odstrániť
        </Button>
      </div>
    </div>
    <div>
      <div
        v-if="isPending || isLoading"
        class="tw-flex tw-items-center tw-gap-4 tw-mb-4"
      >
        <Skeleton shape="circle" size="3rem" />
        <Skeleton height="1.5rem" width="8rem" />
      </div>

      <div v-else class="tw-flex tw-items-center tw-gap-4 tw-mb-4">
        <Avatar :label="userInitial" shape="circle" size="large" />
        <h2 class="tw-text-xl tw-mb-0 tw-font-medium">
          {{ userForm.name }} {{ userForm.surname }}
        </h2>
      </div>

      <div
        v-if="isPending || isLoading"
        class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4"
      >
        <Skeleton height="2.5rem" />
        <Skeleton height="2.5rem" />
        <Skeleton class="md:tw-col-span-2" height="2.5rem" />
        <Skeleton height="2.5rem" />
        <Skeleton height="2.5rem" />
      </div>

      <form
        v-else
        class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4"
        @submit.prevent="() => saveUser(userForm)"
      >
        <div class="tw-flex tw-flex-col">
          <label class="tw-mb-1">Meno</label>
          <InputText
            v-model="userForm.name"
            :disabled="!isEditMode"
            placeholder="Zadajte meno"
          />
        </div>

        <div class="tw-flex tw-flex-col">
          <label class="tw-mb-1">Priezvisko</label>
          <InputText
            v-model="userForm.surname"
            :disabled="!isEditMode"
            placeholder="Zadajte priezvisko"
          />
        </div>

        <div class="tw-flex tw-flex-col md:tw-col-span-2">
          <label class="tw-mb-1">Email</label>
          <InputText
            v-model="userForm.email"
            :disabled="!isEditMode"
            placeholder="Zadajte email"
            type="email"
          />
        </div>

        <div class="tw-flex tw-flex-col">
          <label class="tw-mb-1">Rola</label>
          <Select
            v-model="userForm.role"
            :disabled="!isEditMode"
            :options="roles"
            class="tw-text-base"
            optionLabel="name"
            optionValue="code"
            placeholder="Vyberte rolu"
          />
        </div>
      </form>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { useMutation, useQuery } from "@tanstack/vue-query";
import { Trash2 } from "lucide-vue-next";

const toast = useToast();
const params = useRoute().params;

const isEditMode = ref(false);
const userForm = ref({
  name: "",
  surname: "",
  email: "",
  role: "",
});
const roles = [
  { name: "Učiteľ", code: "teacher" },
  { name: "Študent", code: "student" },
  { name: "Admin", code: "admin" },
];

const {
  data: user,
  isPending,
  isLoading,
} = useQuery({
  queryKey: ["user", params?.id],
  queryFn: () => apiFetch(`/user/${params?.id}`),
  enabled: !!params?.id,
});

const { mutate: updateUser, isPending: isUpdatePending } = useMutation({
  mutationKey: ["user", params?.id],
  mutationFn: (data: {
    name: string;
    surname: string;
    email: string;
    role: string;
  }) =>
    apiFetch(`/user/${params?.id}/update`, {
      method: "PUT",
      body: {
        name: data.name,
        surname: data.surname,
        email: data.email,
        password: data.password,
        role: data.role,
      },
    }),
});

const toggleEdit = () => {
  if (isEditMode.value) saveUser(userForm.value);
  isEditMode.value = !isEditMode.value;
};

const cancelEdit = () => {
  isEditMode.value = false;
};

const saveUser = async (data: {
  name: string;
  surname: string;
  email: string;
  role: string;
}) => {
  updateUser(data, {
    onSuccess: () => {
      toast.add({
        severity: "success",
        summary: "Údaje boli úspešne upravené.",
        life: 3000,
      });
      cancelEdit();
    },
    onError: (error) => {
      toast.add({
        severity: "error",
        summary: "Chyba pri úprave údajov.",
        detail: error.message,
        life: 3000,
      });
    },
  });
};

const deleteUser = () => {};

const userInitial = computed(() => userForm.value.name.charAt(0) || "");

watchEffect(() => {
  if (user.value) {
    userForm.value.name = user.value.user.name;
    userForm.value.surname = user.value.user.surname;
    userForm.value.email = user.value.user.email;
    userForm.value.role = user.value.user.role;
  }
});

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
