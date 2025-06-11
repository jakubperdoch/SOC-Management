<template>
  <div class="tw-px-8 tw-py-9 tw-flex tw-flex-col tw-gap-4">
    <div class="tw-flex tw-items-start tw-justify-between">
      <h1 class="tw-text-2xl tw-font-semibold tw-font-sans">Nastavenia</h1>
    </div>

    <Tabs class="w-[400px]" default-value="account">
      <TabsList>
        <TabsTrigger value="account"> Account</TabsTrigger>
        <TabsTrigger value="password"> Password</TabsTrigger>
      </TabsList>
      <TabsContent value="account">
        Make changes to your account here.
      </TabsContent>
      <TabsContent value="password"> Change your password here.</TabsContent>
    </Tabs>

    <div class="tw-grid tw-grid-cols-2 tw-gap-8">
      <UserCard />
      <div class="tw-grid tw-grid-rows-2 tw-gap-4">
        <LinkInput
          v-for="(link, index) in links"
          :key="index"
          :description="link.description"
          :role="link.role"
          :title="link.title"
        />
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

import LinkInput from "~/components/custom/Settings/LinkInput.vue";
import UserCard from "~/components/custom/Settings/UserCard.vue";

const links = ref([
  {
    title: "Link pre registráciu do systému (študenti)",
    description:
      "Tento link je určený pre študentov, ktorí sa chcú zaregistrovať do systému.",
    role: "student",
  },
  {
    title: "Link pre registráciu do systému (učitelia)",
    description:
      "Tento link je určený pre učiteľov, ktorí sa chcú zaregistrovať do systému.",
    role: "teacher",
  },
]);

definePageMeta({
  layout: "dashboard",
  title: "Dashboard",
});
</script>
