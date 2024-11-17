<template>
	<div class="tw-grid tw-grid-cols-4 tw-gap-4 tw-col-span-3 !tw-font-sans">
		<UserCard
			v-for="(user, index) in users"
			@isDeleteDialogVisible="deleteUserDialog"
			:key="index"
			:index
			:user />
	</div>
	<Toast />
</template>

<script setup lang="ts">
	import { useMutation } from '@tanstack/vue-query';
	import type { User } from '~/interfaces/user';
	import ConfirmDialog from 'primevue/confirmdialog';
	import { get } from 'http';

	const confirm = useConfirm();
	const toast = useToast();

	const users = ref<User[]>([]);

	const { mutate: getUsers } = useMutation({
		mutationFn: () =>
			apiFetch('/users', {
				method: 'POST',
				body: {
					role: 'teacher',
				},
			}),
		onSuccess: (data) => {
			users.value = data || [];
		},
		onError: (error) => {
			console.log(error);
		},
	});

	const { mutate: deleteUser } = useMutation({
		mutationFn: (id) =>
			apiFetch('/login/delete', {
				method: 'DELETE',
				body: {
					id: id,
				},
			}),
		onSuccess: () => {
			getUsers();

			toast.add({
				severity: 'success',
				summary: 'Confirmed',
				detail: 'Učiteľ bol zmazaný',
				life: 3000,
			});
		},
		onError: (error) => {
			console.log(error);
		},
	});

	onMounted(() => {
		getUsers();
	});

	const deleteUserDialog = (id: number | null, index: number) => {
		confirm.require({
			message: 'Vážne chcete zmazať tohto učiteľa ?',
			header: 'Potvrdenie zmazania',
			icon: 'pi pi-info-circle',
			rejectProps: {
				label: 'Zrušiť',
				severity: 'secondary',
				outlined: true,
			},
			acceptProps: {
				label: 'Zmazať',
				severity: 'danger',
			},
		});
	};
</script>
