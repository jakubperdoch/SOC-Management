<template>
  <div class="!tw-rounded-2xl card tw-p-3 !tw-h-fit !tw-font-sans">
    <DataTable
      :loading="isLoading"
      :rows="7"
      :value="cells"
      dataKey="id"
      paginator
      removableSort
      scrollable
      selectionMode="single"
    >
      <template #header>
        <div class="tw-flex tw-justify-end">
          <IconField>
            <InputIcon>
              <i class="pi pi-search" />
            </InputIcon>
            <InputText placeholder="Kľúčové slovo" size="small" />
          </IconField>
        </div>
      </template>

      <template #empty>
        <div class="tw-flex tw-justify-center tw-items-center tw-h-40">
          <p class="tw-text-lg tw-text-gray-500">Žiadne projekty</p>
        </div>
      </template>

      <template #loading>
        <div
          class="tw-flex tw-bg-white tw-justify-center tw-items-center tw-h-full tw-w-full"
        >
          <p
            class="tw-text-lg tw-text-gray-500 tw-flex tw-items-center tw-gap-2"
          >
            Načítavam projekty
            <i class="pi pi-spin pi-spinner" />
          </p>
        </div>
      </template>

      <template #paginatorstart>
        <Button icon="pi pi-refresh" text type="button" />
      </template>

      <template #paginatorend>
        <Button icon="pi pi-download" text type="button" />
      </template>

      <Column field="title" filter header="Názov" sortable>
        <template #body="{ data }">
          {{ data.title }}
        </template>
      </Column>

      <Column field="odbor" header="Odbor" sortable>
        <template #body="{ data }">
          <span class="tw-capitalize">{{ data.odbor }}</span>
        </template>
      </Column>

      <Column field="student" header="Študent" sortable>
        <template #body="{ data }">
          <span>{{ data.student }}</span>
        </template>
      </Column>

      <Column
        v-if="user?.role == 'admin'"
        field="teacher"
        header="Učiteľ"
        sortable
        style="min-width: 14rem"
      >
        <template #body="{ data }">
          <span>{{ data.teacher }}</span>
        </template>
      </Column>

      <Column field="status" header="Status" sortable>
        <template #body="{ data }">
          <Tag
            :severity="getSeverity(data.status)?.value"
            :value="getSeverity(data.status)?.label"
            class="!tw-capitalize"
          />
        </template>
      </Column>

      <Column
        bodyStyle="text-align: center; overflow: visible"
        header="Akcie"
        headerStyle="width: 5rem; text-align: center"
      >
        <template #body="{ data }">
          <div class="tw-flex tw-gap-2">
            <Button
              icon="pi pi-search"
              rounded
              severity="info"
              size="small"
              type="button"
              @click="getDetails(data.id)"
            />
            <Button
              icon="pi pi-pencil"
              rounded
              size="small"
              type="button"
              @click="getEdit(data.id)"
            />
            <Button
              icon="pi pi-trash"
              rounded
              severity="danger"
              size="small"
              type="button"
              @click="deleteProjectHandler(data.id)"
            />
          </div>
        </template>
      </Column>
    </DataTable>
  </div>
  <Toast />
</template>

<script lang="ts" setup>
import { useMutation } from "@tanstack/vue-query";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import useAuthStore from "~/store/auth";
import { FilterMatchMode } from "@primevue/core/api";

const { user } = useAuthStore();
const confirm = useConfirm();
const toast = useToast();
const emit = defineEmits(["refresh"]);

interface Cell {
  student: String;
  id: Number;
  name: String;
  teacher: String;
  subject: String;
  description: String;
  status: String;
}

const { cells, isLoading } = defineProps<{
  cells: Cell[];
  isLoading: boolean;
}>();

const getSeverity = (status: any) => {
  switch (status) {
    case "taken":
      return {
        value: "danger",
        label: "Zabraná",
      };

    case "free":
      return {
        value: "success",
        label: "Voľná",
      };

    case "waiting":
      return {
        value: "info",
        label: "Čakájúca",
      };
  }
};

const getDetails = (id: number) => {
  navigateTo({
    path: `/dashboard/projects/details/${id}`,
  });
};

const getEdit = (id: number) => {
  navigateTo({
    path: `/dashboard/projects/create/${id}`,
  });
};

const {
  mutate: deleteProject,
  error,
  status,
} = useMutation({
  mutationFn: (id: Number) =>
    apiFetch("/project/delete", {
      method: "DELETE",
      body: {
        id: id,
      },
    }),
  onSuccess: () => {
    toast.add({
      severity: "success",
      summary: "Projekt bol úspešne zmazaný",
      life: 3000,
    });
  },
  onError: () => {
    toast.add({
      severity: "error",
      summary: "Projekt sa nepodarilo zmazať",
      life: 3000,
    });
  },
  onSettled: () => {
    emit("refresh");
  },
});

const deleteProjectHandler = (id: number) => {
  confirm.require({
    message: "Vážne chcete zmazať tento projekt?",
    header: "Potvrdenie",
    icon: "pi pi-info-circle",
    rejectLabel: "Cancel",
    rejectProps: {
      label: "Zrušiť",
      severity: "secondary",
      outlined: true,
    },
    acceptProps: {
      label: "Vymazať",
      severity: "danger",
    },
    accept: () => {
      deleteProject(id);
    },
  });
};
</script>
