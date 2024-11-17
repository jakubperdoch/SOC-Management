<template>
	<div
		class="card custom-card tw-col-span-3 !tw-font-sans tw-row-start-1 !tw-rounded-2xl !tw-mb-0 !tw-h-fit">
		<DataTable
			:value="props.cells"
			paginator
			removableSort
			:rows="10"
			:table-class="'!tw-rounded-lg'"
			dataKey="id">
			<template #empty>
				<div class="tw-flex tw-justify-center tw-items-center tw-h-40">
					<p class="tw-text-lg tw-text-gray-500">Žiadne projekty</p>
				</div>
			</template>
			<Column field="name" header="Názov" sortable style="min-width: 14rem">
				<template #body="{ data }">
					{{ data.title }}
				</template>
			</Column>
			<Column field="subject" header="Odbor" sortable style="min-width: 14rem">
				<template #body="{ data }">
					<span>{{ data.odbor }}</span>
				</template>
			</Column>
			<Column field="student" header="Študent" sortable style="min-width: 14rem">
				<template #body="{ data }">
					<span>{{ data.student }}</span>
				</template>
			</Column>
			<Column header="Status" field="status" sortable style="min-width: 12rem">
				<template #body="{ data }">
					<Tag
						:value="getSeverity(data.status)?.label"
						:severity="getSeverity(data.status)?.value" />
				</template>
			</Column>
			<Column
				header="Akcie"
				headerStyle="width: 5rem; text-align: center"
				bodyStyle="text-align: center; overflow: visible">
				<template #body="{ data }">
					<div class="tw-flex tw-gap-2">
						<Button
							@click="getDetails(data.id)"
							type="button"
							severity="info"
							icon="pi pi-search"
							size="small"
							rounded />
						<Button
							@click="getEdit(data.id)"
							type="button"
							icon="pi pi-pencil"
							size="small"
							rounded />
						<Button
							@click="deleteProjectHandler(data.id)"
							type="button"
							severity="danger"
							icon="pi pi-trash"
							size="small"
							rounded />
					</div>
				</template>
			</Column>
		</DataTable>
	</div>
	<Toast />
	<ConfirmDialog></ConfirmDialog>
</template>

<script setup lang="ts">
	import { useMutation } from '@tanstack/vue-query';
	import { useConfirm } from 'primevue/useconfirm';
	import { useToast } from 'primevue/usetoast';

	const confirm = useConfirm();
	const toast = useToast();
	const emit = defineEmits(['refresh']);

	interface Cell {
		id: Number;
		name: String;
		teacher: String;
		subject: String;
		description: String;
		status: String;
	}

	const props = defineProps<{
		cells: Cell[];
	}>();

	const getSeverity = (status: any) => {
		switch (status) {
			case 'taken':
				return {
					value: 'danger',
					label: 'Obsadená',
				};

			case 'free':
				return {
					value: 'success',
					label: 'Voľná',
				};

			case 'waiting':
				return {
					value: 'info',
					label: 'Čakájúca',
				};
		}
	};

	const getDetails = (id: number) => {
		navigateTo({
			path: `/dashboard/create/${id}`,
			query: {
				edit: 'false',
			},
		});
	};

	const getEdit = (id: number) => {
		navigateTo({
			path: `/dashboard/create/${id}`,
			query: {
				edit: 'true',
			},
		});
	};

	const {
		mutate: deleteProject,
		error,
		status,
	} = useMutation({
		mutationFn: (id: Number) =>
			apiFetch('/project/delete', {
				method: 'DELETE',
				body: {
					id,
				},
			}),

		onSettled: () => {
			emit('refresh');
		},
	});

	const deleteProjectHandler = (id: number) => {
		confirm.require({
			message: 'Vážne chcete zmazať tento projekt?',
			header: 'Potvrdenie',
			icon: 'pi pi-info-circle',
			rejectLabel: 'Cancel',
			rejectProps: {
				label: 'Zrušiť',
				severity: 'secondary',
				outlined: true,
			},
			acceptProps: {
				label: 'Vymazať',
				severity: 'danger',
			},
			accept: () => {
				deleteProject(id);
				toast.add({
					severity: 'info',
					summary: 'Vymazané',
					detail: 'Projekt bol vymazaný',
					life: 3000,
				});
			},
		});
	};
</script>

<style scoped>
	::v-deep .p-datatable-table > thead > tr:first-of-type > th:first-of-type {
		border-radius: 0.5rem 0 0 0 !important;
	}

	::v-deep .p-datatable-table > thead > tr:first-of-type > th:last-of-type {
		border-radius: 0 0.5rem 0 0 !important;
	}

	::v-deep .p-datatable-table > tbody > tr:last-of-type > td:first-of-type {
		border-radius: 0 0 0 0.5rem !important;
	}

	::v-deep .p-datatable-table > tbody > tr:last-of-type > td:last-of-type {
		border-radius: 0 0 0.5rem 0 !important;
	}
</style>
