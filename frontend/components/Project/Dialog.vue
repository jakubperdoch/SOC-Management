<template>
  <Dialog
    v-model:visible="isModalVisible"
    modal
    header="Vytvoriť používateľa"
    class="tw-max-w-[40rem] tw-w-full tw-font-sans"
    :baseZIndex="10000"
    @hide="onHide"
  >
    <div class="tw-flex tw-flex-col tw-gap-4 tw-py-4">
      <div class="tw-flex tw-flex-col tw-gap-2">
        <label for="title" class="tw-font-semibold"> Názov projektu </label>
        <InputText
          id="title"
          class="tw-text-[13px]"
          v-model="projectForm.title"
          :disabled="isPending"
          placeholder="Zadajte názov projektu"
          fluid
          required
        />
      </div>

      <div class="tw-flex tw-flex-col tw-gap-2">
        <label for="description" class="tw-font-semibold">
          Popis projektu
        </label>

        <Editor
          class="tw-text-[13px]"
          id="description"
          v-model="projectForm.description"
          :disabled="isPending"
          placeholder="Zadajte popis projektu"
          fluid
          required
          editorStyle="height: 320px"
        />
      </div>

      <div class="tw-flex tw-flex-col tw-gap-2">
        <label for="student" class="tw-font-semibold"> Študent </label>

        <Select
          class="tw-text-[13px]"
          id="student"
          v-model="projectForm.student_id"
          display="chip"
          fluid
          :options="students?.data"
          filter
          optionLabel="surname"
          optionValue="id"
          placeholder="Vyberte študenta"
          :selection-limit="1"
          :maxSelectedLabels="1"
          :showClear="true"
        >
          <template #option="slotProps">
            {{ slotProps.option.name }} {{ slotProps.option.surname }}
          </template>
        </Select>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-2">
        <label for="role" class="tw-font-semibold"> Status </label>
        <Select
          class="tw-text-[13px]"
          id="role"
          v-model="projectForm.status"
          :options="statuses"
          optionLabel="name"
          optionValue="code"
          :disabled="isPending"
          fluid
          placeholder="Vyberte status"
          required
        />
      </div>

      <div class="tw-flex tw-flex-col tw-gap-2">
        <label for="odbor" class="tw-font-semibold"> Odbor </label>
        <Select
          class="tw-text-[13px]"
          id="odbor"
          v-model="projectForm.odbor"
          :options="divisions"
          optionLabel="name"
          optionValue="code"
          :disabled="isPending"
          fluid
          placeholder="Vyberte odbor"
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
            createProject(projectForm);
          }
        "
      />
    </template>
  </Dialog>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { useMutation, useQuery, useQueryClient } from "@tanstack/vue-query";
import { Form } from "@primevue/forms";

import useAuthStore from "~/store/auth";

const props = defineProps({
  visible: { type: Boolean, required: true },
});

const emit = defineEmits<{
  (e: "update:visible", visible: boolean): void;
}>();

const authStore = useAuthStore();
const queryClient = useQueryClient();
const toast = useToast();
const isModalVisible = ref(false);
const projectForm = reactive({
  title: "",
  description: "",
  status: "",
  student_id: null as number | null,
  odbor: "",
});

const statuses = [
  { name: "Voľný", code: "free" },
  { name: "Zabraný", code: "taken" },
  { name: "Čakajúci", code: "waiting" },
];

const divisions = [
  { name: "Informatika", code: "Informatika" },
  { name: "Strojárstvo", code: "Strojárstvo" },
  { name: "Elektrotechnika", code: "Elektrotechnika" },
  { name: "Učebné pomôcky", code: "Učebné pomôcky" },
  { name: "Logistika", code: "Logistika" },
];

watch(
  () => props.visible,
  (v) => {
    isModalVisible.value = v;
    if (v) {
      Object.assign(projectForm, {
        title: "",
        description: "",
        status: "",
        student_id: null,
        odbor: "",
      });
    }
  },
);

function closeDialog() {
  emit("update:visible", false);
}
function onHide() {
  closeDialog();
}

const { data: students } = useQuery({
  queryKey: ["students"],
  queryFn: () => apiFetch("/users/student"),
  enabled: !!isModalVisible,
});

const { mutate: createProject, isPending } = useMutation({
  mutationKey: ["createProject"],
  mutationFn: (data: {
    title: string;
    description: string;
    status: string;
    student_id: number | null;
    odbor: string;
  }) =>
    apiFetch("/project/create", {
      method: "POST",
      body: {
        title: data.title,
        description: data.description,
        status: data.status,
        student_id: data.student_id,
        teacher_id: authStore.user?.id,
        odbor: data.odbor,
      },
    }),

  onSuccess() {
    toast.add({
      severity: "success",
      summary: "Používateľ bol úspešne vytvorený.",
      life: 5000,
    });
    closeDialog();
    queryClient.invalidateQueries({ queryKey: ["projects"] });
  },

  onError(error: Error) {
    toast.add({
      severity: "error",
      summary: "Vytvorenie projektu zlyhalo.",
      detail: apiErrorMessageHandler(error),
      life: 5000,
    });
  },
});
</script>
