<template>
  <Dialog
    v-model:visible="isModalVisible"
    :baseZIndex="10000"
    :style="{ width: '30rem' }"
    header="Vytvorenie užívateľa"
    modal
    @hide="onHide"
  >
    <div class="tw-flex tw-flex-col tw-gap-4 tw-py-4">
      <div class="tw-flex tw-items-center tw-gap-4">
        <label class="tw-w-24 tw-font-semibold" for="name">Meno</label>
        <InputText
          id="name"
          v-model="userForm.name"
          :disabled="isPending"
          class="tw-text-[13px]"
          fluid
          placeholder="Zadajte meno"
          required
        />
      </div>

      <div class="tw-flex tw-items-center tw-gap-4">
        <label class="tw-w-24 tw-font-semibold" for="surname">Priezvisko</label>
        <InputText
          id="surname"
          v-model="userForm.surname"
          :disabled="isPending"
          class="tw-text-[13px]"
          fluid
          placeholder="Zadajte priezvisko"
          required
        />
      </div>

      <div class="tw-flex tw-items-center tw-gap-4">
        <label class="tw-w-24 tw-font-semibold" for="email">Email</label>
        <InputText
          id="email"
          v-model="userForm.email"
          :disabled="isPending"
          class="tw-text-[13px]"
          fluid
          placeholder="Zadajte email"
          required
          type="email"
        />
      </div>

      <div class="tw-flex tw-items-center tw-gap-4">
        <label class="tw-w-24 tw-font-semibold" for="password">Heslo</label>
        <Password
          id="password"
          v-model="userForm.password"
          :disabled="isPending"
          class="tw-text-[13px] tw-w-full"
          fluid
          placeholder="Zadajte heslo"
          required
          toggleMask
        />
      </div>

      <div class="tw-flex tw-items-center tw-gap-4">
        <label class="tw-w-24 tw-font-semibold" for="role">Rola</label>
        <Dropdown
          id="role"
          v-model="userForm.role"
          :disabled="isPending"
          :options="roles"
          class="tw-text-[13px]"
          fluid
          optionLabel="name"
          optionValue="code"
          placeholder="Vyberte rolu"
          required
        />
      </div>
    </div>

    <template #footer>
      <Button
        :disabled="isPending"
        label="Zrušiť"
        severity="secondary"
        text
        @click="closeDialog"
      />
      <Button
        :loading="isPending"
        label="Vytvoriť"
        severity="success"
        @click="
          () => {
            saveUser(userForm);
          }
        "
      />
    </template>
  </Dialog>
</template>

<script lang="ts" setup>
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
