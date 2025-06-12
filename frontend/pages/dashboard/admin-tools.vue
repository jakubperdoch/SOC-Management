<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Admin Nástroje</h1>
    </div>

    <section>
      <h5>Správa databázy.</h5>
      <p>
        Tu môžete spravovať databázu, napríklad pridať alebo odstrániť
        používateľov.
      </p>
      <Button
        class="tw-bg-secondary tw-border-secondary"
        label="Exportovať databázu"
        @click="() => exportDatabase()"
      />
    </section>
  </div>
</template>

<script lang="ts" setup>
import { useMutation, useQuery } from "@tanstack/vue-query";
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

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
