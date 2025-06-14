<template>
  <div>
    <Panel :collapsed="true" toggleable>
      <template #header>
        <div class="flex items-center gap-2">
          <span class="tw-font-semibold tw-font-sans"
            >{{ studyField.name }} | {{ studyField.idOfField }}</span
          >
        </div>
      </template>
      <template #footer>
        <span
          :class="
            studyField?.isActive ? 'tw-text-green-600' : 'tw-text-red-600'
          "
          class="tw-text-xs tw-font-sans tw-text-gray-600"
        >
          {{ studyField.isActive ? "Aktívny" : "Neaktívny" }}
        </span>
      </template>
      <template #icons>
        <Button
          icon="pi pi-cog"
          rounded
          severity="secondary"
          text
          @click="toggle"
        />
        <Menu id="config_menu" ref="menu" :model="items" popup />
      </template>
      <p class="m-0 tw-text-sm tw-font-sans">
        {{ studyField.description }}
      </p>
    </Panel>
  </div>
</template>
<script lang="ts" setup>
import { Menu } from "primevue";

interface studyField {
  id: number;
  idOfField: number;
  name: string;
  description: string;
  duration: string;
  isActive: boolean;
}

const { studyField } = defineProps({
  studyField: {
    type: Object as () => studyField,
    required: true,
  },
});

const menu = ref<InstanceType<typeof Menu> | null>(null);

const items = ref([
  {
    label: "Aktualizovať",
    icon: "pi pi-refresh",
  },
  {
    label: "Zmazať",
    icon: "pi pi-times",
  },
]);

const toggle = (event: Event) => {
  if (menu.value) {
    menu.value.toggle(event);
  }
};
</script>
