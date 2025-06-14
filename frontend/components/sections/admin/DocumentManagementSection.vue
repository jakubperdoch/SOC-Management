<template>
  <section class="tw-mb-8 tw-col-span-2">
    <h5 class="tw-text-lg tw-font-semibold tw-font-sans tw-text-gray-800">
      Správa dokumentov.
    </h5>
    <p class="tw-text-sm tw-font-sans tw-text-gray-600 tw-max-w-md">
      Tu môžete spravovať dokumenty, ktoré sa používajú v systéme.
    </p>

    <div class="tw-flex tw-flex-wrap tw-gap-4 tw-mt-4">
      <DocumentCard
        v-for="file in files"
        :file
        @delete="deleteDocument(file.id)"
        @edit="editDocument(file.id)"
      />
    </div>
  </section>
  <DocumentDialog
    :documentId="documentId"
    :is-visible="isDialogVisible"
    @update:is-visible="(value) => (isDialogVisible = value)"
  />
</template>
<script lang="ts" setup>
import DocumentCard from "~/components/custom/Admin/DocumentCard.vue";
import DocumentDialog from "~/components/custom/Admin/DocumentDialog.vue";

const confirm = useConfirm();
const toast = useToast();

const isDialogVisible = ref(false);
const documentId = ref<number | null>(null);

const deleteDocument = (id: number) => {
  confirm.require({
    message: "Naozaj chcete zmazať tento dokument?",
    header: "Potvrdenie zmazania",
    icon: "pi pi-info-circle",
    rejectLabel: "Zrušiť",
    rejectProps: {
      label: "Zrušiť",
      severity: "secondary",
      outlined: true,
    },
    acceptProps: {
      label: "Zmazať",
      severity: "danger",
    },
    accept: () => {
      toast.add({
        severity: "success",
        summary: "Dokument bol zmazaný",
        detail: "Dokument bol úspešne zmazaný.",
        life: 3000,
      });
    },
  });
};

const editDocument = (id: number) => {
  documentId.value = id.toString();
  isDialogVisible.value = true;
};

const files = ref([
  { name: "Prezentácia", url: "url1", id: 1 },
  { name: "Dokumentácia", url: "url2", id: 2 },
  { name: "Pokyny 2025/2026", url: "url3", id: 3 },
  { name: "Harmonogram", url: "url4", id: 4 },
]);
</script>
