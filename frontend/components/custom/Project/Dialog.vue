<template>
  <Dialog
    v-model:visible="isModalVisible"
    :baseZIndex="10000"
    class="tw-max-w-[40rem] tw-w-full tw-font-sans"
    header="Vytvorenie projektu"
    modal
    @hide="onHide"
  >
    <div class="tw-flex tw-flex-col tw-gap-4 tw-py-4">
      <div class="tw-flex tw-flex-col tw-gap-2">
        <label class="tw-font-semibold" for="title"> Názov projektu </label>
        <InputText
          id="title"
          v-model="projectForm.title"
          :disabled="isPending"
          class="tw-text-[13px]"
          fluid
          placeholder="Zadajte názov projektu"
          required
        />
      </div>

      <div class="tw-flex tw-flex-col tw-gap-2">
        <label class="tw-font-semibold" for="description">
          Popis projektu
        </label>

        <Editor
          id="description"
          v-model="projectForm.description"
          :disabled="isPending"
          :modules="{
            toolbar: toolbarOptions,
          }"
          :pt="{
            toolbar: {
              class: '!tw-hidden',
            },
          }"
          class="tw-text-[13px]"
          editorStyle="height: 320px"
          fluid
          placeholder="Zadajte popis projektu"
          required
        >
        </Editor>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-2">
        <label class="tw-font-semibold" for="student"> Študent </label>

        <Select
          id="student"
          v-model="projectForm.student_id"
          :maxSelectedLabels="1"
          :options="students?.data"
          :selection-limit="1"
          :showClear="true"
          class="tw-text-[13px]"
          display="chip"
          filter
          fluid
          optionLabel="surname"
          optionValue="id"
          placeholder="Vyberte študenta"
        >
          <template #option="slotProps">
            {{ slotProps.option.name }} {{ slotProps.option.surname }}
          </template>
        </Select>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-2">
        <label class="tw-font-semibold" for="role"> Status </label>
        <Select
          id="role"
          v-model="projectForm.status"
          :disabled="isPending"
          :options="statuses"
          class="tw-text-[13px]"
          fluid
          optionLabel="name"
          optionValue="code"
          placeholder="Vyberte status"
          required
        />
      </div>

      <div class="tw-flex tw-flex-col tw-gap-2">
        <label class="tw-font-semibold" for="odbor"> Odbor </label>
        <Select
          id="odbor"
          v-model="projectForm.odbor"
          :disabled="isPending"
          :options="divisions"
          class="tw-text-[13px]"
          fluid
          optionLabel="name"
          optionValue="code"
          placeholder="Vyberte odbor"
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
            createProject(projectForm);
          }
        "
      />
    </template>
  </Dialog>
</template>

<script lang="ts" setup>
import { ref, watch } from "vue";
import { useMutation, useQuery, useQueryClient } from "@tanstack/vue-query";

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

const toolbarOptions = [
  { size: ["small", false, "large", "huge"] },
  "bold",
  "italic",
  "link",
  "underline",
  "strike",
  "clean",
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
      summary: "Projekt bol úspešne vytvorený.",
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
