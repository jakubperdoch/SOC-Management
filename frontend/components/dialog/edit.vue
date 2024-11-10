<template>
	<Dialog
		v-model:visible="visible"
		modal
		class="!tw-font-sans"
		header="Upraviť údaje"
		:style="{ width: '25rem' }">
		<span class="tw-text-surface-500 tw-dark:text-surface-400 tw-block tw-mb-8">
			Upravte učiteľove údaje
		</span>
		<div class="tw-flex tw-items-center tw-gap-4 tw-mb-4">
			<label for="username" class="tw-font-semibold tw-w-24">Meno</label>
			<InputText id="username" class="flex-auto" autocomplete="off" />
		</div>
		<div class="tw-flex tw-items-center tw-gap-4 tw-mb-4">
			<label for="surname" class="tw-font-semibold tw-w-24">Priezvisko</label>
			<InputText id="surname" class="flex-auto" autocomplete="off" />
		</div>
		<div class="tw-flex tw-items-center gap-4 tw-mb-8">
			<label for="email" class="tw-font-semibold tw-w-24">Email</label>
			<InputText id="email" class="tw-flex-auto" autocomplete="off" />
		</div>
		<div class="tw-flex tw-justify-end tw-gap-2">
			<Button
				type="button"
				label="Zrušiť"
				severity="secondary"
				@click="visible = false"></Button>
			<Button type="button" label="Uložiť" @click="visible = false"></Button>
		</div>
	</Dialog>
</template>

<script setup lang="ts">
	import { ref } from 'vue';
	import { defineEmits } from 'vue';

	const props = defineProps<{
		isModalVisible: boolean;
	}>();

	const emit = defineEmits();
	const visible = ref(props.isModalVisible || false);

	watch(
		() => props.isModalVisible,
		(value) => {
			visible.value = value;
		}
	);

	watch(
		() => visible.value,
		(value) => {
			emit('update:isModalVisible', value);
		}
	);
</script>
