<template>
  <div class="tw-h-screen">
    <navbar :user-profile="user" :data="navigationData" class="!tw-z-10" />

    <div class="tw-pt-20 tw-h-full">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
import navbar from "~/components/navbar.vue";
import navigationData from "@/utils/data/navbar.json";
const token = useCookie("token");
import useAuth from "~/composable/useAuth";
const { getUser, user } = useAuth();

onMounted(() => {
  if (token.value) {
    getUser();
  }
});

watch(
  () => token.value,
  (newToken, oldToken) => {
    if (newToken) {
      getUser();
    } else {
      console.log("No token found");
    }
  },
);
</script>
