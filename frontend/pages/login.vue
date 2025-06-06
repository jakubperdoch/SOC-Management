<template>
  <div class="tw-flex tw-flex-col tw-justify-center tw-items-center tw-gap-8">
    <div class="tw-text-center tw-font-montserrat">
      <h1 class="tw-text-3xl tw-font-bold">Prihlásenie do systému</h1>
      <span class="tw-text-sm tw-text-center tw-mt-4">
        Prosím, zadajte svoje prihlasovacie údaje
      </span>
    </div>

    <Form
      v-slot="$form"
      :initialValues="initialValues"
      :resolver="resolver"
      class="tw-flex tw-flex-col tw-gap-6 tw-w-full tw-sm:w-56 tw-font-montserrat"
      @submit="onFormSubmit"
    >
      <div class="tw-flex tw-flex-col tw-gap-1">
        <label for="email">Email</label>
        <InputText fluid name="email" placeholder="Email" type="text" />
        <Message
          v-if="$form.email?.invalid"
          severity="error"
          size="small"
          variant="simple"
          >{{ $form.email.error?.message }}
        </Message>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-1">
        <label for="password">Heslo</label>
        <Password fluid name="password" toggleMask />
        <Message
          v-if="$form.password?.invalid"
          severity="error"
          size="small"
          variant="simple"
          >{{ $form.password.error?.message }}
        </Message>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-3">
        <Button
          :loading="isPending"
          class="tw-bg-secondary tw-border-secondary"
          label="Prihlásiť sa"
          type="submit"
        />
        <span class="tw-font-montserrat tw-text-sm tw-text-center">
          Nemáte účet?
          <NuxtLink
            class="tw-text-secondary tw-underline tw-duration-200"
            to="/register"
          >
            Zaregistrujte sa
          </NuxtLink>
        </span>
      </div>
    </Form>
  </div>
  <Toast />
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { zodResolver } from "@primevue/forms/resolvers/zod";
import { useToast } from "primevue/usetoast";
import { z } from "zod";
import { useMutation } from "@tanstack/vue-query";
import useAuthStore from "~/store/auth";

definePageMeta({
  title: "Prihlásenie",
  layout: "auth",
});

const toast = useToast();
const authStore = useAuthStore();

const initialValues = ref({
  email: "",
  password: "",
});

const resolver = ref(
  zodResolver(
    z.object({
      email: z
        .string()
        .min(1, { message: "Email je povinný." })
        .email({ message: "Neplatný email." }),
      password: z.string().min(1, { message: "Heslo je povinné." }),
    }),
  ),
);

const { mutate, error, isPending } = useMutation({
  mutationKey: ["login"],
  mutationFn: (data: { email: string; password: string }) =>
    authStore.login({
      email: data.email,
      password: data.password,
    }),

  onSuccess: () => {
    toast.add({
      severity: "success",
      summary: "Prihlásenie úspešné.",
      life: 3000,
    });

    setTimeout(() => {
      navigateTo("/dashboard");
    }, 1000);
  },

  onError: (error: Error) => {
    toast.add({
      severity: "error",
      summary: "Prihlásenie zlyhalo.",
      detail: apiErrorMessageHandler(error),
      life: 3000,
    });
  },
});

const onFormSubmit = (e: any) => {
  if (e.valid) {
    mutate(e.values);
  } else {
    toast.add({
      severity: "error",
      summary: "Je nutné vyplniť všetky polia.",
      life: 3000,
    });
  }
};
</script>
