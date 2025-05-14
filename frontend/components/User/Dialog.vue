<template>
  <Dialog
    v-model:visible="isModalVisible"
    modal
    header="Vytvoriť používateľa"
    :style="{ width: '30rem' }"
    :baseZIndex="10000"
    @hide="onHide"
  >
    <div class="tw-flex tw-flex-col tw-gap-4 tw-py-4">
      <div class="tw-flex tw-items-center tw-gap-4">
        <label for="name" class="tw-w-24 tw-font-semibold">Meno</label>
        <InputText
          class="tw-text-[13px]"
          id="name"
          v-model="userForm.name"
          :disabled="isPending"
          placeholder="Zadajte meno"
          fluid
          required
        />
      </div>

      <div class="tw-flex tw-items-center tw-gap-4">
        <label for="surname" class="tw-w-24 tw-font-semibold">Priezvisko</label>
        <InputText
          class="tw-text-[13px]"
          id="surname"
          v-model="userForm.surname"
          :disabled="isPending"
          placeholder="Zadajte priezvisko"
          fluid
          required
        />
      </div>

      <div class="tw-flex tw-items-center tw-gap-4">
        <label for="email" class="tw-w-24 tw-font-semibold">Email</label>
        <InputText
          class="tw-text-[13px]"
          id="email"
          v-model="userForm.email"
          :disabled="isPending"
          placeholder="Zadajte email"
          fluid
          type="email"
          required
        />
      </div>

      <div class="tw-flex tw-items-center tw-gap-4">
        <label for="password" class="tw-w-24 tw-font-semibold">Heslo</label>
        <Password
          class="tw-text-[13px] tw-w-full"
          id="password"
          v-model="userForm.password"
          :disabled="isPending"
          placeholder="Zadajte heslo"
          toggleMask
          fluid
          required
        />
      </div>

      <div class="tw-flex tw-items-center tw-gap-4">
        <label for="role" class="tw-w-24 tw-font-semibold">Rola</label>
        <Dropdown
          class="tw-text-[13px]"
          id="role"
          v-model="userForm.role"
          :options="roles"
          optionLabel="name"
          optionValue="code"
          :disabled="isPending"
          fluid
          placeholder="Vyberte rolu"
          required
        />
      </div>
    </div>

    <template #footer>
      <Button
        label="Zrušiť"
        text
        severity="secondary"
        @click="closeDialog"
        :disabled="isPending"
      />
      <Button
        label="Vytvoriť"
        severity="success"
        :loading="isPending"
        @click="
          () => {
            saveUser(userForm);
          }
        "
      />
    </template>
  </Dialog>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { useMutation, useQueryClient } from "@tanstack/vue-query";

const props = defineProps({
  visible: { type: Boolean, required: true },
});

const emit = defineEmits<{
  (e: "update:visible", visible: boolean): void;
}>();

const queryClient = useQueryClient();
const toast = useToast();
const isModalVisible = ref(false);
const userForm = ref({
  name: "",
  surname: "",
  email: "",
  password: "",
  role: "",
});

const roles = [
  { name: "Učiteľ", code: "teacher" },
  { name: "Študent", code: "student" },
  { name: "Administrátor", code: "admin" },
];

watch(
  () => props.visible,
  (v) => {
    isModalVisible.value = v;
    if (v) {
      userForm.value = {
        name: "",
        surname: "",
        email: "",
        password: "",
        role: "",
      };
    }
  },
);

function closeDialog() {
  emit("update:visible", false);
}
function onHide() {
  closeDialog();
}

const { mutate: saveUser, isPending } = useMutation({
  mutationKey: ["createUser"],
  mutationFn: (data: {
    name: string;
    surname: string;
    email: string;
    password: string;
    role: string;
  }) =>
    apiFetch("/auth/register", {
      method: "POST",
      body: {
        name: data.name,
        surname: data.surname,
        email: data.email,
        password: data.password,
        role: data.role,
      },
    }),
  onSuccess() {
    toast.add({
      severity: "success",
      summary: "Používateľ bol úspešne vytvorený.",
      life: 3000,
    });

    setTimeout(() => {
      closeDialog();
    }, 1000);

    queryClient.invalidateQueries({ queryKey: ["users"] });
  },

  onError(error: Error) {
    toast.add({
      severity: "error",
      summary: "Vytvorenie používateľa zlyhalo.",
      detail: apiErrorMessageHandler(error),
      life: 3000,
    });
  },
});
</script>
