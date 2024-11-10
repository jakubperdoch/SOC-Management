<template>
	<div class="tw-grid tw-grid-cols-4 tw-gap-4 tw-col-span-3 !tw-font-sans">
		<h2 class="tw-col-span-4">Učitelia</h2>
		<UserCard v-for="i in 8" :delete-user-dialog="deleteUserDialog" />
	</div>
	<Toast />
	<ConfirmDialog></ConfirmDialog>
</template>

<script setup lang="ts">
	const confirm = useConfirm();
	const toast = useToast();

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
