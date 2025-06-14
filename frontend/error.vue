<template>
  <NuxtLayout>
    <div
      class="tw-bg-[url(/images/auth-bg.svg)] tw-min-h-screen tw-bg-cover tw-bg-center tw-flex tw-justify-center tw-items-center !tw-font-sans"
    >
      <div
        class="tw-bg-white tw-py-16 tw-px-14 tw-mx-auto tw-p-4 tw-rounded-3xl tw-shadow-lg tw-w-full tw-max-w-[600px] sm:tw-w-2/3 tw-flex tw-flex-col tw-justify-center tw-items-center"
      >
        <template v-if="error.statusCode === 404">
          <Image class="tw-max-w-96 tw-mb-10" src="/icons/404.svg" />
          <p class="tw-text-3xl tw-mb-8 tw-font-bold">
            Vyzerá to, že ste sa stratili...
          </p>
        </template>
        <template v-else>
          <Image class="tw-max-w-96 tw-mb-10" src="/icons/error.svg" />
          <p class="tw-text-3xl tw-mb-8 tw-font-bold">Niečo sa pokazilo...</p>
        </template>
        <Button
          class="tw-bg-secondary tw-border-secondary tw-w-full tw-max-w-"
          label="Späť na dashboard"
          @click="handleError"
        />
      </div>
    </div>
  </NuxtLayout>
</template>

<script setup>
const error = useError();

const handleError = () => {
  clearError({
    redirect: "/dashboard",
  });
};
</script>
