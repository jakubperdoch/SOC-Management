<template>
  <div class="tw-bg-white tw-p-4 tw-rounded-lg">
    <div class="tw-flex tw-items-center tw-justify-between">
      <h2 class="tw-text-lg tw-font-semibold tw-font-sans tw-mb-0">
        Oznámenia
      </h2>

      <Button
        v-tooltip.top="'Upozorniť na deadline'"
        class="tw-font-sans"
        size="small"
      >
        <icon name="line-md:bell-alert-twotone-loop" size="20" />
      </Button>
    </div>

    <Divider />

    <div class="tw-flex tw-flex-col tw-gap-2.5">
      <Message severity="info">
        <div class="tw-flex tw-flex-col">
          <div class="tw-flex tw-items-center tw-mb-1">
            <icon name="line-md:email-alt-twotone" />
            <span class="tw-font-sans tw-text-xs tw-ms-1">
              Je potrebné dodržať termíny pre odovzdanie projektov a dokumentov.
            </span>
          </div>
          <span class="tw-text-gray-500 tw-text-xs tw-ms-auto"
            >Automatické upozornenie - 10.10.2023
          </span>
        </div>
      </Message>

      <Message severity="error">
        <div class="tw-flex tw-flex-col">
          <div class="tw-flex tw-items-center tw-mb-1">
            <icon name="line-md:email-alt-twotone" />
            <span class="tw-font-sans tw-text-xs tw-ms-1">
              Je potrebné dodržať termíny pre odovzdanie projektov a dokumentov.
            </span>
          </div>
          <span class="tw-text-gray-500 tw-text-xs tw-ms-auto"
            >Martin Cvinček - 10.10.2023
          </span>
        </div>
      </Message>
    </div>
  </div>
</template>
<script lang="ts" setup></script>
