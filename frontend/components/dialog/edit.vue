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

		<div class="tw-flex tw-items-center gap-4 tw-mb-8">
			<label for="email" class="tw-font-semibold tw-w-24">Email</label>
			<InputText
				id="email"
				v-model="user.email"
				class="tw-flex-auto"
				autocomplete="off" />
		</div>
		<div class="tw-flex tw-items-center gap-4 tw-mb-8">
			<label for="password" class="tw-font-semibold tw-w-24">Nové heslo</label>
			<InputText
				id="password"
				v-model="user.password"
				class="tw-flex-auto"
				autocomplete="off" />
		</div>
		<div class="tw-flex tw-justify-end tw-gap-2">
			<Button
				type="button"
				label="Zrušiť"
				severity="secondary"
				@click="visible = false"></Button>
			<Button type="button" label="Uložiť" @click="editUser"></Button>
		</div>
	</Dialog>
	<Toast />
</template>

<script setup lang="ts">
	import { useMutation } from '@tanstack/vue-query';
	import { ref } from 'vue';
	import { defineEmits } from 'vue';
	import type { User } from '~/interfaces/user';
	import Toast from 'primevue/toast';

	const props = defineProps<{
		isModalVisible: boolean;
		user: User;
	}>();

	const toast = useToast();
	const emit = defineEmits(['update:isModalVisible']);
	const visible = ref(props.isModalVisible || false);

	const user = ref<User>({
		id: null,
		name: '',
		surname: '',
		email: '',
		role: '',
		password: '',
	});

	const { mutate } = useMutation({
		mutationFn: () =>
			apiFetch('/login/update', {
				method: 'PUT',
				body: {
					id: user.value.id,
					email: user.value.email,
					password: user.value.password,
				},
			}),

		onSuccess: () => {
			setTimeout(() => {
				visible.value = false;
			}, 500);

			toast.add({
				severity: 'success',
				summary: 'Úspešne upravené',
				detail: 'Učiteľove údaje boli úspešne upravené',
			});
		},
	});

	const editUser = () => {
		if (user.value.email === '' || user.value.password === '') {
			toast.add({
				severity: 'error',
				summary: 'Chyba',
				detail: 'Vyplňte všetky polia',
			});
			return;
		}

		mutate();
	};

	watch(
		() => props.user,
		(value) => {
			user.value = value;
		}
	);

	onMounted(() => {
		user.value = props.user;
	});

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
