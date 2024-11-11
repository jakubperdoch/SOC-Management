<template>
	<div
		class="card custom-card tw-col-span-3 !tw-font-sans tw-row-start-1 !tw-rounded-2xl !tw-mb-0">
		<DataTable
			:value="props.cells"
			paginator
			removableSort
			:rows="10"
			:table-class="'!tw-rounded-lg'"
			dataKey="id">
			<template #empty> No customers found. </template>
			<Column field="name" header="Názov" sortable style="min-width: 14rem">
				<template #body="{ data }">
					{{ data.name }}
				</template>
			</Column>
			<Column field="subject" header="Odbor" sortable style="min-width: 14rem">
				<template #body="{ data }">
					<span>{{ data.subject }}</span>
				</template>
			</Column>
			<Column field="student" header="Študent" sortable style="min-width: 14rem">
				<template #body="{ data }">
					<span>{{ data.student }}</span>
				</template>
			</Column>
			<Column header="Status" field="status" sortable style="min-width: 12rem">
				<template #body="{ data }">
					<Tag :value="data.status" :severity="getSeverity(data.status)" />
				</template>
			</Column>
			<Column
				header="Akcie"
				headerStyle="width: 5rem; text-align: center"
				bodyStyle="text-align: center; overflow: visible">
				<template #body>
					<div class="tw-flex tw-gap-2">
						<Button type="button" icon="pi pi-search" size="small" rounded />
						<Button type="button" icon="pi pi-pencil" size="small" rounded />
						<Button type="button" icon="pi pi-trash" size="small" rounded />
					</div>
				</template>
			</Column>
		</DataTable>
	</div>
</template>

<script setup lang="ts">
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
			case 'Zabraná':
				return 'danger';

			case 'Voľná':
				return 'success';

			case 'Čakajúca':
				return 'warn';
		}
	};
</script>

<style scoped>
	::v-deep .p-datatable-table > thead > tr:first-of-type > th:first-of-type {
		border-radius: 0.5rem 0 0 0 !important;
	}

	/* Top Right Would be: */
	::v-deep .p-datatable-table > thead > tr:first-of-type > th:last-of-type {
		border-radius: 0 0.5rem 0 0 !important;
	}

	/* Bottom Left Would Be: */
	::v-deep .p-datatable-table > tbody > tr:last-of-type > td:first-of-type {
		border-radius: 0 0 0 0.5rem !important;
	}

	/* Bottom Right Would Be: */
	::v-deep .p-datatable-table > tbody > tr:last-of-type > td:last-of-type {
		border-radius: 0 0 0.5rem 0 !important;
	}
</style>
