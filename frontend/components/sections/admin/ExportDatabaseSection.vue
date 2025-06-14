<template>
  <section class="tw-mb-8 tw-flex tw-flex-col">
    <h5 class="tw-text-lg tw-font-semibold tw-font-sans tw-text-gray-800">
      Správa databázy.
    </h5>
    <p class="tw-text-sm tw-font-sans tw-text-gray-600 tw-max-w-md">
      Tu môžete spravovať databázu systému. Export databázy do SQL súboru,
      vyčistenie databázy.
    </p>
    <Button
      aria-label="Exportovať databázu do SQL"
      class="tw-w-fit"
      icon="pi pi-database"
      label="Exportovať databázu do SQL"
      @click="() => exportDatabase()"
    />

    <Button
      aria-label="Vyčistiť databázu"
      class="tw-w-fit tw-mt-2"
      icon="pi pi-trash"
      label="Vyčistiť databázu"
      severity="danger"
    />
  </section>
</template>
<script lang="ts" setup>
import { useMutation } from "@tanstack/vue-query";
import useAuthStore from "~/store/auth";

const toast = useToast();
const authStore = useAuthStore();

const { mutate: exportDatabase } = useMutation({
  mutationKey: ["exportDatabase"],
  mutationFn: (): Promise<Response> =>
    fetch("http://127.0.0.1:8000/api/export/database", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${authStore.token}`,
      },
    }),

  onSuccess: async (res: Response) => {
    const disposition = res.headers.get("Content-Disposition") || "";
    const match = disposition.match(/filename="?(.+)"?/);
    const filename = match?.[1] ?? "backup.sql";

    const blob = await res.blob();

    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(url);

    toast.add({
      severity: "success",
      summary: "Úspech",
      detail: "Databáza bola exportovaná.",
      life: 3000,
    });
  },
  onError: (err) => {
    console.error("Export databázy zlyhal:", err);
    toast.add({
      severity: "error",
      summary: "Chyba",
      detail: "Export databázy zlyhal.",
      life: 3000,
    });
  },
});
</script>
