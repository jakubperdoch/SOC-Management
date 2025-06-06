<template>
  <div class="tw-flex tw-flex-col tw-justify-center tw-items-center tw-gap-8">
    <div class="tw-text-center tw-font-montserrat">
      <h1 class="tw-text-3xl tw-font-bold">Registrácia do systému</h1>
      <span class="tw-text-sm tw-text-center tw-mt-4">
        Prosím, vyplňte registračný formulár
      </span>
    </div>

    <Form
      v-slot="$form"
      :initialValues="initialValues"
      :resolver="resolver"
      class="tw-flex tw-flex-col md:tw-grid md:tw-grid-cols-2 tw-gap-6 tw-w-full tw-font-montserrat"
      @submit="onFormSubmit"
    >
      <div class="tw-flex tw-flex-col tw-gap-1">
        <label for="name">Meno</label>
        <InputText fluid name="name" placeholder="Meno" type="text" />
        <Message
          v-if="$form.name?.invalid"
          severity="error"
          size="small"
          variant="simple"
          >{{ $form.name.error?.message }}
        </Message>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-1">
        <label for="surname">Priezvisko</label>
        <InputText fluid name="surname" placeholder="Priezvisko" type="text" />
        <Message
          v-if="$form.surname?.invalid"
          severity="error"
          size="small"
          variant="simple"
          >{{ $form.surname.error?.message }}
        </Message>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-1 tw-col-span-2">
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
        <Password fluid name="password" placeholder="Heslo" toggleMask />
        <Message
          v-if="$form.password?.invalid"
          severity="error"
          size="small"
          variant="simple"
          >{{ $form.password.error?.message }}
        </Message>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-1">
        <label for="confirmPassword">Potvrdenie hesla</label>
        <Password
          fluid
          name="confirmPassword"
          placeholder="Potvrdenie hesla"
          toggleMask
        />
        <Message
          v-if="$form.confirmPassword?.invalid"
          severity="error"
          size="small"
          variant="simple"
          >{{ $form.confirmPassword.error?.message }}
        </Message>
      </div>

      <div class="tw-flex tw-flex-col tw-gap-3 tw-col-span-2">
        <Button
          :loading="isPending"
          class="tw-bg-secondary tw-border-secondary"
          label="Zaregistrovať sa"
          type="submit"
        />
        <span class="tw-font-montserrat tw-text-sm tw-text-center">
          Už máte účet?
          <NuxtLink
            class="tw-text-secondary tw-underline tw-duration-200"
            to="/login"
          >
            Prihláste sa
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
import { useMutation, useQuery } from "@tanstack/vue-query";
import useAuthStore from "~/store/auth";

definePageMeta({
  title: "Registrácia",
  layout: "auth",
});

const toast = useToast();
const authStore = useAuthStore();
const route = useRoute();

const initialValues = ref({
  name: "",
  surname: "",
  email: "",
  role: "",
  password: "",
  confirmPassword: "",
});

const resolver = ref(
  zodResolver(
    z
      .object({
        email: z
          .string()
          .min(1, { message: "Email je povinný." })
          .email({ message: "Neplatný email." }),
        name: z.string().min(1, { message: "Meno je povinné." }),
        surname: z.string().min(1, { message: "Priezvisko je povinné." }),
        password: z.string().min(5, { message: "Heslo je krátke" }),
        confirmPassword: z.string(),
      })
      .refine((data) => data.password === data.confirmPassword, {
        message: "Heslá sa nezhodujú.",
        path: ["confirmPassword"],
      }),
  ),
);

const { mutate, error, isPending } = useMutation({
  mutationKey: ["register"],
  mutationFn: (data: {
    email: string;
    password: string;
    name: string;
    surname: string;
    role: string;
  }) =>
    authStore.register({
      email: data.email,
      password: data.password,
      name: data.name,
      surname: data.surname,
      role: data?.role,
    }),

  onSuccess: () => {
    toast.add({
      severity: "success",
      summary: "Registrácia úspešná.",
      life: 3000,
    });

    setTimeout(() => {
      navigateTo("/dashboard");
    }, 1000);
  },

  onError: (error: Error) => {
    toast.add({
      severity: "error",
      summary: "Registrácia zlyhala.",
      detail: apiErrorMessageHandler(error),
      life: 3000,
    });
  },
});

async function onFormSubmit(e: any) {
  if (e.valid) {
    try {
      const response = await authStore.validateURLToken(
        route.query.token as string,
      );

      if (response && response?.valid) {
        mutate({
          email: e.values.email,
          password: e.values.password,
          name: e.values.name,
          surname: e.values.surname,
          role: response?.role || "student",
        });
      } else {
        toast.add({
          severity: "error",
          summary: "Neplatný token.",
          detail: "Token pre registráciu nie je platný.",
          life: 3000,
        });
      }
    } catch (error) {
      toast.add({
        severity: "error",
        summary: "Chyba pri overovaní tokenu.",
        detail: apiErrorMessageHandler(error),
        life: 3000,
      });
      return;
    }
  } else {
    toast.add({
      severity: "error",
      summary: "Je nutné vyplniť všetky polia.",
      life: 3000,
    });
  }
}
</script>
