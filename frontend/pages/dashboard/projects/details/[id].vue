<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-font-sans tw-gap-6">
    <!-- Header -->
    <div class="tw-flex tw-items-center tw-justify-between">
      <Skeleton v-if="isPending || isLoading" width="12rem" height="2rem" />
      <h1 v-else class="tw-text-2xl tw-font-semibold tw-font-sans">
        {{ projectForm?.title || "Nový projekt" }}
      </h1>
      <div class="tw-flex tw-gap-3">
        <Button
          size="small"
          class="tw-font-sans"
          :disabled="isPending || isLoading"
          @click="toggleEdit"
          :outlined="!isEditMode"
          :severity="isEditMode ? 'success' : 'primary'"
        >
          {{ isEditMode ? "Uložiť" : "Upraviť" }}
        </Button>
        <Button
          v-if="isEditMode"
          size="small"
          class="tw-font-sans"
          outlined
          severity="warning"
          @click="cancelEdit"
        >
          Zrušiť
        </Button>
        <Button
          size="small"
          class="tw-font-sans tw-flex tw-items-center"
          outlined
          severity="danger"
          :disabled="isPending || isLoading"
        >
          <Trash2 class="tw-mr-1" />
          Odstrániť
        </Button>
      </div>
    </div>

    <div v-if="isPending || isLoading" class="tw-space-y-4">
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
          class="tw-text-[13px]"
          v-model="projectForm.title"
          :disabled="!isEditMode"
          placeholder="Zadajte názov projektu"
        />
      </div>

      <!-- Status -->
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Status</label>
        <Select
          v-model="projectForm.status"
          :options="statusOptions"
          :disabled="!isEditMode"
          placeholder="Vyberte status"
          class="tw-text-[13px]"
          optionLabel="label"
          optionValue="value"
        />
      </div>

      <!-- Student & Teacher  -->
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Študent</label>

        <Select
          v-model="projectForm.student_id"
          display="chip"
          fluid
          :options="students?.data"
          filter
          optionLabel="surname"
          optionValue="id"
          placeholder="Vyberte študenta"
          class="tw-text-[13px]"
          :selection-limit="1"
          :maxSelectedLabels="1"
          :disabled="!isEditMode"
          :showClear="true"
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
          display="chip"
          fluid
          :options="teachers?.data"
          filter
          optionLabel="surname"
          class="tw-text-[13px]"
          optionValue="id"
          placeholder="Vyberte učiteľa"
          :selection-limit="1"
          :maxSelectedLabels="1"
          :disabled="!isEditMode"
          :showClear="true"
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
          class="tw-text-[13px]"
          v-model="projectForm.odbor"
          :options="fieldOptions"
          optionLabel="label"
          optionValue="value"
          :disabled="!isEditMode"
          placeholder="Zadajte odbor"
        />
      </div>

      <!-- Mark -->

      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Známka</label>
        <InputNumber
          v-model="projectForm.mark"
          :disabled="!isEditMode"
          class="tw-text-[13px]"
          placeholder="Zadajte známku"
          mode="decimal"
          :min="1"
          :max="5"
          :showButtons="true"
        />
      </div>

      <!-- Description -->
      <div class="md:tw-col-span-2 tw-flex tw-flex-col">
        <label class="tw-mb-1">Popis</label>

        <Editor
          class="tw-text-[13px]"
          editorStyle="height: 320px"
          v-model="projectForm.description"
          :readonly="!isEditMode"
          rows="4"
          placeholder="Zadajte popis projektu"
        />
      </div>

      <!-- Reviews -->
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Prvé hodnotenie</label>
        <Textarea
          class="tw-text-[13px]"
          v-model="projectForm.first_review"
          :disabled="!isEditMode"
          rows="3"
          placeholder="Hodnotenie prvej recenzie"
        />
      </div>
      <div class="tw-flex tw-flex-col">
        <label class="tw-mb-1">Druhé hodnotenie </label>
        <Textarea
          class="tw-text-[13px]"
          v-model="projectForm.second_review"
          :disabled="!isEditMode"
          rows="3"
          placeholder="Hodnotenie druhej recenzie"
        />
      </div>
      <div class="md:tw-col-span-2 tw-flex tw-flex-col">
        <label class="tw-mb-1">Tretie hodnotenie </label>
        <Textarea
          class="tw-text-[13px]"
          v-model="projectForm.third_review"
          :disabled="!isEditMode"
          rows="3"
          placeholder="Hodnotenie tretej recenzie"
        />
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
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
});

const statusOptions = [
  { label: "Voľný", value: "free" },
  { label: "Zabraný", value: "taken" },
  { label: "Čakúci", value: "waiting" },
];

const fieldOptions = [
  { label: "Informatika", value: "Informatika" },
  { label: "Elektrotechnika", value: "Elektrotechnika" },
  { label: "Strojárstvo", value: "Strojárstvo" },
  { label: "Elektrotechnika", value: "Elektrotechnika" },
  { label: "Učebné pomôcky", value: "Učebné pomôcky" },
];

const {
  data: project,
  isLoading,
  isPending,
  isError,
  error,
  refetch,
} = useQuery({
  queryKey: ["project", params.id],
  queryFn: () => apiFetch(`/project/${params.id}`),
  enabled: !!params.id,
});

const { data: students } = useQuery({
  queryKey: ["students"],
  queryFn: () => apiFetch("/users/student"),
  enabled: !!params.id,
});

const { data: teachers } = useQuery({
  queryKey: ["teachers"],
  queryFn: () => apiFetch("/users/teacher"),
  enabled: !!params.id,
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

  console.log(projectForm.value);
});

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
