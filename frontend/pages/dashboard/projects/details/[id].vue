<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-font-sans tw-gap-6">
    <!-- Header -->
    <div class="tw-flex tw-items-center tw-justify-between">
      <Skeleton v-if="isBusy.value" height="2rem" width="12rem" />
      <h1 v-else class="tw-text-2xl tw-font-semibold tw-font-sans">
        {{ projectForm?.title || "Nový projekt" }}
      </h1>
      <div class="tw-flex tw-gap-3">
        <Button
          :disabled="isBusy.value"
          :outlined="!isEditMode"
          :severity="isEditMode ? 'success' : 'primary'"
          class="tw-font-sans"
          size="small"
          @click="toggleEdit"
        >
          {{ isEditMode ? "Uložiť" : "Upraviť" }}
        </Button>
        <Button
          v-if="isEditMode"
          class="tw-font-sans"
          outlined
          severity="warning"
          size="small"
          @click="cancelEdit"
        >
          Zrušiť
        </Button>
        <Button
          :disabled="isBusy.value"
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

    <div v-if="isBusy.value" class="tw-space-y-4">
      <Skeleton height="2rem" />
      <Skeleton height="8rem" />
      <Skeleton height="2rem" />
      <Skeleton height="2rem" />
    </div>

    <!-- Form -->
    <form v-else class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">
      <!-- Title -->
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Názov projektu</label>
        <InputText
          v-model="projectForm.title"
          :disabled="!isEditMode"
          class="tw-text-[13px]"
          placeholder="Zadajte názov projektu"
        />
      </div>

      <!-- Status -->
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Status</label>
        <Select
          v-model="projectForm.status"
          :disabled="!isEditMode"
          :options="statusOptions"
          class="tw-text-[13px]"
          optionLabel="label"
          optionValue="value"
          placeholder="Vyberte status"
        />
      </div>

      <!-- Student & Teacher  -->
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Študent</label>

        <Select
          v-model="projectForm.student_id"
          :disabled="!isEditMode"
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

      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">
          Učiteľ
          <span v-if="user?.role === 'admin'" class="tw-text-red-500">
            (len pre adminov)
          </span>
        </label>

        <Select
          v-model="projectForm.teacher_id"
          :disabled="!isEditMode"
          :maxSelectedLabels="1"
          :options="teachers?.data"
          :selection-limit="1"
          :showClear="true"
          class="tw-text-[13px]"
          display="chip"
          filter
          fluid
          optionLabel="surname"
          optionValue="id"
          placeholder="Vyberte učiteľa"
        >
          <template #option="slotProps">
            {{ slotProps.option.name }} {{ slotProps.option.surname }}
          </template>
        </Select>
      </div>

      <!-- Odbor -->
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Odbor</label>
        <Select
          v-model="projectForm.odbor"
          :disabled="!isEditMode"
          :options="fieldOptions"
          class="tw-text-[13px]"
          optionLabel="label"
          optionValue="value"
          placeholder="Zadajte odbor"
        />
      </div>

      <!-- Mark -->

      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Známka</label>
        <InputNumber
          v-model="projectForm.mark"
          :disabled="!isEditMode"
          :max="5"
          :min="1"
          :pt="inputNumberPT"
          :showButtons="true"
          mode="decimal"
          placeholder="Zadajte známku"
        />
      </div>

      <!-- Description -->
      <div class="md:tw-col-span-2 tw-flex tw-flex-col">
        <label class="tw-mb-1">Popis</label>

        <Editor
          v-model="projectForm.description"
          :class="
            !isEditMode
              ? 'tw-border-gray-300 tw-opacity-50'
              : 'tw-border-gray-100'
          "
          :modules="{
            toolbar: toolbarOptions,
          }"
          :pt="{
            toolbar: {
              class: '!tw-hidden',
            },
          }"
          :readonly="!isEditMode"
          class="tw-text-[13px] !tw-border !tw-border-gray-300 !tw-rounded-xl !tw-bg-gray-50"
          editorStyle="height: 320px;"
          placeholder="Zadajte popis projektu"
          rows="4"
        >
        </Editor>
      </div>

      <!-- Reviews -->
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Prvé hodnotenie</label>
        <Textarea
          v-model="projectForm.first_review"
          :disabled="!isEditMode"
          class="tw-text-[13px]"
          placeholder="Hodnotenie prvej recenzie"
          rows="3"
        />
      </div>
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Druhé hodnotenie </label>
        <Textarea
          v-model="projectForm.second_review"
          :disabled="!isEditMode"
          class="tw-text-[13px]"
          placeholder="Hodnotenie druhej recenzie"
          rows="3"
        />
      </div>
      <div class="md:tw-col-span-2 tw-flex tw-flex-col">
        <label class="tw-mb-1">Tretie hodnotenie </label>
        <Textarea
          v-model="projectForm.third_review"
          :disabled="!isEditMode"
          class="tw-text-[13px]"
          placeholder="Hodnotenie tretej recenzie"
          rows="3"
        />
      </div>

      <!--Uploads-->

      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1"> Dokumentácia </label>
        <FileUpload
          v-model="projectForm.document"
          :cancel-button-props="{
            class: 'tw-text-[13px]',
            severity: 'secondary',
          }"
          :choose-button-props="{ class: 'tw-text-[13px]' }"
          :custom-upload="true"
          :disabled="!isEditMode"
          :maxFileSize="4000000"
          :name="'document'"
          :pt="{
            root: {
              class: '!tw-border-gray-300 !tw-bg-gray-50 !tw-rounded-xl',
            },
          }"
          :show-upload-button="false"
          accept=".pdf,.doc,.docx"
          cancelLabel="Zrušiť"
          chooseLabel="Vyberte súbor"
        />
      </div>

      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1"> Prezentácia </label>
        <FileUpload
          v-model="projectForm.presentation"
          :cancel-button-props="{
            class: 'tw-text-[13px]',
            severity: 'secondary',
          }"
          :choose-button-props="{ class: 'tw-text-[13px]' }"
          :custom-upload="true"
          :disabled="!isEditMode"
          :maxFileSize="4000000"
          :name="'presentation'"
          :pt="{
            root: {
              class: '!tw-border-gray-300 !tw-bg-gray-50 !tw-rounded-xl',
            },
          }"
          :show-upload-button="false"
          accept=".ppt,.pptx"
          cancelLabel="Zrušiť"
          chooseLabel="Vyberte súbor"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { useQuery } from "@tanstack/vue-query";
import { Trash2 } from "lucide-vue-next";
import useAuthStore from "~/store/auth";

const { user } = useAuthStore();
const params = useRoute().params;

const isEditMode = ref(false);
const projectForm = ref({
  title: "",
  description: "",
  status: "",
  odbor: "",
  first_review: "",
  second_review: "",
  third_review: "",
  mark: null,
  student_id: 0,
  teacher_id: 0,
  document: null,
  presentation: null,
});

const statusOptions = [
  { label: "Voľný", value: "free" },
  { label: "Zabraný", value: "taken" },
  { label: "Čakajúci", value: "waiting" },
];

const fieldOptions = [
  { label: "Informatika", value: "Informatika" },
  { label: "Elektrotechnika", value: "Elektrotechnika" },
  { label: "Strojárstvo", value: "Strojárstvo" },
  { label: "Elektrotechnika", value: "Elektrotechnika" },
  { label: "Učebné pomôcky", value: "Učebné pomôcky" },
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

const {
  data: project,
  isLoading,
  isPending,
} = useQuery({
  queryKey: ["project", params.id],
  queryFn: () => apiFetch(`/project/${params.id}`),
  enabled: !!params.id,
});

const {
  data: students,
  isLoading: isStudentsLoading,
  isPending: isStudentsPending,
} = useQuery({
  queryKey: ["students"],
  queryFn: () => apiFetch("/users/student"),
  enabled: !!params.id,
});

const {
  data: teachers,
  isLoading: isTeachersLoading,
  isPending: isTeachersPending,
} = useQuery({
  queryKey: ["teachers"],
  queryFn: () => apiFetch("/users/teacher?additionalRoles=admin"),
  enabled: !!params.id,
});

const isBusy = computed(() => {
  return (
    isLoading ||
    isPending ||
    isStudentsLoading ||
    isStudentsPending ||
    isTeachersLoading ||
    isTeachersPending
  );
});

const toggleEdit = () => {
  isEditMode.value = !isEditMode.value;
};

const cancelEdit = () => {
  isEditMode.value = false;
};

watchEffect(() => {
  if (project.value) {
    projectForm.value = {
      title: project.value.project.title,
      description: project.value.project.description,
      status: project.value.project.status,
      odbor: project.value.project.odbor,
      first_review: project.value.project.first_review,
      second_review: project.value.project.second_review,
      third_review: project.value.project.third_review,
      mark: project.value.project.mark,

      student_id: Number(project.value.project.student_id),
      teacher_id: Number(project.value.project.teacher_id),
    };
  }
});

const inputNumberPT = {
  pcInputText: {
    root: {
      class: "tw-text-[13px]",
    },
  },
};

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
