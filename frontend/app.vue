<template>
  <NuxtLoadingIndicator color="#86C725" />
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup>
import { onMounted } from "vue";
import useAuthStore from "@/store/auth";

const auth = useAuthStore();

onMounted(() => {
  auth.init();
});
</script>
