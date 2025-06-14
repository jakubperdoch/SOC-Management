<template>
  <NuxtLink
    :class="`tw-py-[6px] tw-px-[8px] md:tw-px-4 md:tw-py-[10px] tw-mx-auto tw-w-fit md:tw-w-full tw-transition-all tw-duration-150 tw-text-sm tw-font-semibold tw-rounded-md md:tw-flex tw-items-center tw-gap-3 ${
      !$route.path.startsWith($attrs.to) ||
      ($attrs.to === '/dashboard' && $route.path !== '/dashboard')
        ? 'hover:tw-text-secondary tw-text-white'
        : 'tw-bg-secondary tw-text-primary'
    }`"
    v-bind="{ to: $attrs.to }"
  >
    <Icon :name="`line-md:${$attrs.icon}`" size="20" />
    <slot />
  </NuxtLink>
</template>
