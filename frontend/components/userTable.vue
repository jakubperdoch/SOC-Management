<template>
	<div class="tw-grid tw-grid-cols-4 tw-gap-4 tw-col-span-3 !tw-font-sans">
		<UserCard
			v-for="user in users"
			:delete-user-dialog="deleteUserDialog"
			:user />
	</div>
	<Toast />
	<ConfirmDialog></ConfirmDialog>
</template>

<script setup lang="ts">
	import { useMutation } from '@tanstack/vue-query';
	import type { User } from '~/interfaces/user';

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

	onMounted(() => {
		getUsers();
	});

	const deleteUserDialog = (id: number) => {
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
			accept: () => {
				console.log('Deleted ', id);
				toast.add({
					severity: 'success',
					summary: 'Confirmed',
					detail: 'Učiteľ bol zmazaný',
					life: 3000,
				});
			},
			reject: () => {
				console.log('Rejected');
				toast.add({
					severity: 'error',
					summary: 'Rejected',
					detail: 'Učiteľ nebol zmazaný',
					life: 3000,
				});
			},
		});
	};
</script>
