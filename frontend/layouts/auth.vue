<template>
  <div
    class="tw-bg-[url(@/public/images/auth-bg.svg)] tw-min-h-screen tw-bg-cover tw-bg-center tw-flex tw-justify-center tw-items-center"
  >
    <main
      class="tw-bg-white tw-py-20 tw-px-14 tw-mx-auto tw-p-4 tw-rounded-3xl tw-shadow-lg tw-w-full md:tw-w-1/2 lg:tw-w-1/3 tw-flex tw-flex-col tw-justify-center tw-items-center"
    >
      <slot />
    </main>
  </div>
</template>
