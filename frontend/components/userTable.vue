<template>
	<div class="tw-flex tw-flex-col tw-w-max !tw-font-sans">
		<div class="tw-flex tw-items-center tw-justify-between tw-mb-5">
			<span class="tw-font-bold tw-text-xl">Učitelia</span>

			<Button
				label="Pridať učiteľa"
				size="small"
				icon="pi pi-plus"
				@click="isModalVisible = !isModalVisible" />
		</div>
		<div class="tw-grid tw-grid-cols-5 tw-gap-4 tw-col-span-3 tw-w-fit">
			<UserCard
				v-for="(user, index) in users"
				@isDeleteDialogVisible="deleteUserDialog"
				:key="index"
				:index
				:user />
		</div>
	</div>
	<Toast />
	<DialogAdd v-model:isModalVisible="isModalVisible" @refetch="emitHandler" />
</template>

<script setup lang="ts">
	import { useMutation } from '@tanstack/vue-query';
	import type { User } from '~/interfaces/user';

	const confirm = useConfirm();
	const toast = useToast();
	const isModalVisible = ref(false);
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
		mutationFn: (id: any) =>
			apiFetch('/teacher/delete', {
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

	const emitHandler = () => [getUsers()];

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
			accept: () => {
				deleteUser(id);
			},
		});
	};
</script>
