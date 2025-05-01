<template>
  <div class="!tw-rounded-2xl !tw-h-fit !tw-font-sans">
    <DataTable
      :value="cells"
      :loading="isLoading"
      paginator
      removableSort
      :rows="7"
      :table-class="'!tw-rounded-lg'"
      dataKey="id"
      scrollable
      selectionMode="single"
    >
      <template #empty>
        <div class="tw-flex tw-justify-center tw-items-center tw-h-40">
          <p class="tw-text-lg tw-text-gray-500">Žiadne projekty</p>
        </div>
      </template>

      <template #loading>
        <div
          class="tw-flex tw-bg-white !tw-rounded-2xl tw-justify-center tw-items-center tw-h-full tw-w-full"
        >
          <p
            class="tw-text-lg tw-text-gray-500 tw-flex tw-items-center tw-gap-2"
          >
            Načítavam projekty
            <i class="pi pi-spin pi-spinner" />
          </p>
        </div>
      </template>

      <Column field="title" header="Názov" sortable>
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
        field="teacher"
        header="Učiteľ"
        sortable
        style="min-width: 14rem"
        v-if="user?.role == 'admin'"
      >
        <template #body="{ data }">
          <span>{{ data.teacher }}</span>
        </template>
      </Column>

      <Column header="Status" field="status" sortable>
        <template #body="{ data }">
          <Tag
            class="!tw-capitalize"
            :value="getSeverity(data.status)?.label"
            :severity="getSeverity(data.status)?.value"
          />
        </template>
      </Column>

      <Column
        header="Akcie"
        headerStyle="width: 5rem; text-align: center"
        bodyStyle="text-align: center; overflow: visible"
      >
        <template #body="{ data }">
          <div class="tw-flex tw-gap-2">
            <Button
              @click="getDetails(data.id)"
              type="button"
              severity="info"
              icon="pi pi-search"
              size="small"
              rounded
            />
            <Button
              @click="getEdit(data.id)"
              type="button"
              icon="pi pi-pencil"
              size="small"
              rounded
            />
            <Button
              @click="deleteProjectHandler(data.id)"
              type="button"
              severity="danger"
              icon="pi pi-trash"
              size="small"
              rounded
            />
          </div>
        </template>
      </Column>
    </DataTable>
  </div>
  <Toast />
</template>

<script setup lang="ts">
import { useMutation } from "@tanstack/vue-query";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import useAuthStore from "~/store/auth";

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

watchEffect(() => {
  console.log(isLoading);
});
</script>

<style scoped>
::v-deep .p-datatable-table > thead > tr:first-of-type > th:first-of-type {
  border-radius: 0.5rem 0 0 0 !important;
}

::v-deep .p-datatable-table > thead > tr:first-of-type > th:last-of-type {
  border-radius: 0 0.5rem 0 0 !important;
}

::v-deep .p-datatable-table > tbody > tr:last-of-type > td:first-of-type {
  border-radius: 0 0 0 0.5rem !important;
}

::v-deep .p-datatable-table > tbody > tr:last-of-type > td:last-of-type {
  border-radius: 0 0 0.5rem 0 !important;
}
</style>
