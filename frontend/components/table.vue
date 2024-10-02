<template>
	<div class="card">
		<DataTable
			v-model:filters="filters"
			v-model:selection="selectedCustomers"
			:value="customers"
			paginator
			:rows="10"
			dataKey="id"
			filterDisplay="menu"
			:globalFilterFields="[
				'name',
				'country.name',
				'representative.name',
				'balance',
				'status',
			]">
			<template #header>
				<div class="flex justify-between">
					<IconField>
						<InputIcon>
							<i class="pi pi-search" />
						</InputIcon>
						<InputText
							v-model="filters['global'].value"
							placeholder="Keyword Search" />
					</IconField>
				</div>
			</template>
			<template #empty> No customers found. </template>
			<Column
				selectionMode="multiple"
				headerStyle="width: 3rem"></Column>
			<Column
				field="name"
				header="Name"
				sortable
				style="min-width: 14rem">
				<template #body="{ data }">
					{{ data.name }}
				</template>
				<template #filter="{ filterModel }">
					<InputText
						v-model="filterModel.value"
						type="text"
						placeholder="Search by name" />
				</template>
			</Column>
			<Column
				header="Country"
				sortable
				sortField="country.name"
				filterField="country.name"
				style="min-width: 14rem">
				<template #body="{ data }">
					<div class="flex items-center gap-2">
						<img
							alt="flag"
							src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
							:class="`flag flag-${data.country.code}`"
							style="width: 24px" />
						<span>{{ data.country.name }}</span>
					</div>
				</template>
			</Column>
			<Column
				header="Status"
				field="status"
				sortable
				:filterMenuStyle="{ width: '14rem' }"
				style="min-width: 12rem">
				<template #body="{ data }">
					<Tag
						:value="data.status"
						:severity="getSeverity(data.status)" />
				</template>
				<template #filter="{ filterModel }">
					<Select
						v-model="filterModel.value"
						:options="statuses"
						placeholder="Select One"
						showClear>
						<template #option="slotProps">
							<Tag
								:value="slotProps.option"
								:severity="getSeverity(slotProps.option)" />
						</template>
					</Select>
				</template>
			</Column>
			<Column
				headerStyle="width: 5rem; text-align: center"
				bodyStyle="text-align: center; overflow: visible">
				<template #body>
					<Button
						type="button"
						icon="pi pi-cog"
						rounded />
				</template>
			</Column>
		</DataTable>
	</div>
</template>

<script setup>
	const selectedCustomers = ref();

	const statuses = ref([
		'unqualified',
		'qualified',
		'new',
		'negotiation',
		'renewal',
		'proposal',
	]);

	const getSeverity = (status) => {
		switch (status) {
			case 'unqualified':
				return 'danger';

			case 'qualified':
				return 'success';

			case 'new':
				return 'info';

			case 'negotiation':
				return 'warn';

			case 'renewal':
				return null;
		}
	};
</script>
