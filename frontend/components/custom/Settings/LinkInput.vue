<template>
  <div>
    <h3 class="tw-text-lg tw-font-medium tw-font-sans">
      {{ title }}
    </h3>
    <p class="tw-text-sm tw-text-gray-500 tw-mb-4">
      {{ description }}
    </p>

    <div class="tw-flex tw-items-center tw-gap-2">
      <InputText
        v-model="link"
        :disabled="true"
        class="tw-rounded tw-w-full tw-text-[14px]"
        placeholder="https://example.com/register"
        type="text"
      />
      <Button
        :icon="!link ? 'pi pi-link' : 'pi pi-copy'"
        aria-label="Save"
        class="tw-w-11 tw-text-[14px]"
        @click="!link ? mutate() : copyLink()"
      />
    </div>
    <Toast />
  </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useMutation } from "@tanstack/vue-query";
import useAuthStore from "~/store/auth";

const { title, role, description } = defineProps({
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
  role: {
    type: String,
    required: true,
  },
});

const toast = useToast();
const link = ref("");
const authStore = useAuthStore();

const { data, mutate, status } = useMutation({
  mutationKey: ["link", role],
  mutationFn: () =>
    apiFetch("/invite/send", {
      method: "POST",
      body: {
        email: authStore.user?.email || "",
        role: role,
      },
    }),
  onSuccess: async (data) => {
    link.value = data.link;
  },
});

const copyLink = () => {
  navigator.clipboard.writeText(link.value).then(() => {
    toast.add({
      severity: "success",
      summary: "Link skopírovaný",
      detail: "Link bol úspešne skopírovaný do schránky.",
      life: 3000,
    });
  });
};
</script>
