<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">
        Údaje o užívateľovi
      </h1>

      <!--      <div class="tw-flex tw-gap-4">-->
      <!--        <Button-->
      <!--          size="medium"-->
      <!--          class="tw-font-sans"-->
      <!--          @click="toggleEdit"-->
      <!--          :outlined="!isEditMode"-->
      <!--          :severity="isEditMode ? 'success' : 'primary'"-->
      <!--        >-->
      <!--          {{ isEditMode ? "Uložiť" : "Upraviť" }}-->
      <!--        </Button>-->

      <!--        <Button-->
      <!--          class="tw-font-sans tw-transition-all tw-duration-300 tw-ease-in-out"-->
      <!--          :class="{ 'tw-hidden': !isEditMode }"-->
      <!--          outlined-->
      <!--          severity="warning"-->
      <!--          @click="toggleEdit"-->
      <!--        >-->
      <!--          Zrušiť-->
      <!--        </Button>-->

      <!--        <Button-->
      <!--          class="tw-font-sans tw-flex tw-items-center"-->
      <!--          outlined-->
      <!--          severity="danger"-->
      <!--        >-->
      <!--          <Trash2 class="tw-mr-1" />-->
      <!--          Odstrániť-->
      <!--        </Button>-->
      <!--      </div>-->
    </div>
    <div>
      <div class="tw-flex tw-items-center tw-gap-4 tw-mb-4">
        <!--        <Avatar size="large" :label="userInitial" shape="circle" />-->
        <h2 class="tw-text-xl tw-mb-0 tw-font-medium">
          {{ params?.id }}
        </h2>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Trash2 } from "lucide-vue-next";

const params = useRoute().params;

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
