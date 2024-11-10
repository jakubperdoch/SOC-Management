<script lang="ts" setup>
	import auth from '@/middleware/auth';

	import Editor from 'primevue/editor';

	definePageMeta({
		layout: 'default',
		middleware: [auth],
	});

	const selectedStatus = ref();
	const statusOptions = ref([
		{ name: 'Open', code: 'op' },
		{ name: 'Closed', code: 'cl' },
		{ name: 'In Progress', code: 'ip' },
	]);

	const selectedStudent = ref();
	const studentOptions = ref([
		{ name: 'John Doe', code: 'jd' },
		{ name: 'Jane Doe', code: 'jane' },
		{ name: 'John Smith', code: 'js' },
	]);

	const selectedSubject = ref();
	const subjectOptions = ref([
		{ name: 'Web Development', code: 'wd' },
		{ name: 'Mobile Development', code: 'md' },
		{ name: 'UI/UX', code: 'ui' },
		{ name: 'Testing', code: 'test' },
		{ name: 'Marketing', code: 'mark' },
	]);

	const content = ref('');
</script>

<template>
	<div class="row tw-p-9">
		<div class="col-xl-12">
			<div class="card custom-card">
				<div class="card-header">
					<div class="card-title">Create Project</div>
				</div>
				<div class="card-body">
					<div class="row gy-3">
						<div class="col-xl-4">
							<label for="input-label" class="form-label">Project Name :</label>
							<input
								type="text"
								class="form-control"
								id="input-label"
								placeholder="Enter Project Name" />
						</div>
						<div class="col-xl-4">
							<label for="input-label" class="form-label">Project Name :</label>
							<input
								type="text"
								class="form-control"
								id="input-label"
								placeholder="Enter Project Name" />
						</div>
						<div class="col-xl-4">
							<label for="input-label11" class="form-label">Project Manager :</label>
							<input
								type="text"
								class="form-control"
								id="input-label11"
								placeholder="Project Manager Name" />
						</div>

						<div class="col-xl-12">
							<label class="form-label">Project Description :</label>
							<Editor v-model="content" editorStyle="height: 320px" />
						</div>
						<div class="tw-grid md:tw-grid-cols-2 tw-gap-7">
							<div>
								<label class="form-label">Status :</label>

								<MultiSelect
									v-model="selectedStatus"
									display="chip"
									fluid
									:options="statusOptions"
									optionLabel="name"
									filter
									placeholder="Vyberte status"
									:selection-limit="1"
									:maxSelectedLabels="1"
									class="w-full md:w-80" />
							</div>

							<div>
								<label class="form-label">Assigned To</label>

								<MultiSelect
									v-model="selectedStudent"
									display="chip"
									fluid
									:options="studentOptions"
									optionLabel="name"
									filter
									placeholder="Vyberte študenta"
									:selection-limit="1"
									:maxSelectedLabels="1"
									class="w-full md:w-80" />
							</div>

							<div class="col-xl-6">
								<label class="form-label"> Subject </label>

								<MultiSelect
									v-model="selectedSubject"
									display="chip"
									:options="subjectOptions"
									optionLabel="name"
									filter
									placeholder="Vyberte predmet"
									:selection-limit="1"
									:maxSelectedLabels="1"
									class="w-full md:w-80" />
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary-light btn-wave ms-auto float-end">
						Create Project
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<style scoped></style>
