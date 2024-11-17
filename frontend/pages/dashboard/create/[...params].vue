<script lang="ts" setup>
	import auth from '@/middleware/auth';
	import Editor from 'primevue/editor';
	import { useMutation, useQuery } from '@tanstack/vue-query';
	import { useToast } from '#imports';
	import Toast from 'primevue/toast';
	import useAuth from '~/composable/useAuth';

	import subjectOptions from '@/utils/data/subjectOptions.json';
	import statusOptions from '@/utils/data/statusOptions.json';
	import type { Project } from '~/interfaces/project';

	definePageMeta({
		layout: 'default',
		middleware: [auth],
		roles: ['teacher', 'admin'],
	});

	const { getUserIdFromToken } = useAuth();

	const userId = getUserIdFromToken();
	const toast = useToast();
	const router = useRouter();
	const route = useRoute();

	onMounted(() => {
		project.value.teacherId = userId;

		if (route.params?.id) {
			getProject();
		}
	});

	const project = ref<Project>({
		name: '',
		description: '',
		status: '',
		studentId: null,
		teacherId: null,
		odbor: '',
	});

	const studentOptions = ref([
		{ name: 'John Doe', code: 1 },
		{ name: 'Jane Doe', code: 2 },
		{ name: 'John Smith', code: 3 },
	]);

	const { mutate: createProject } = useMutation({
		mutationFn: (data: Project) =>
			apiFetch('/project/create', {
				method: 'POST',
				body: data,
			}),
		onSuccess: () => {
			setTimeout(() => {
				router.push('/');
			}, 1000);

			toast.add({
				severity: 'success',
				summary: 'Projekt bol úspešne vytvorený',
				life: 3000,
			});
		},
	});

	const { mutate: updateProject } = useMutation({
		mutationFn: (data: Project) =>
			apiFetch('/project/update', {
				method: 'PUT',
				body: data,
			}),
		onSuccess: () => {
			setTimeout(() => {
				router.push('/');
			}, 1000);

			toast.add({
				severity: 'success',
				summary: 'Projekt bol úspešne upravený',
				life: 3000,
			});
		},
	});

	const { mutate: getProject } = useMutation({
		mutationFn: () =>
			apiFetch('/project/info', {
				method: 'POST',
				body: { id: 1 },
			}),
		onSuccess: (data) => {
			project.value = data;
		},
		onError: () => {
			setTimeout(() => {
				router.push('/');
			}, 1000);

			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Nepodarilo sa načítať projekt',
				life: 3000,
			});
		},
	});

	const inputValidation = () => {
		if (!project.value.name || project.value.name === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Názov projektu je povinný',
				life: 3000,
			});
			return false;
		} else if (!project.value.description || project.value.description === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Popis projektu je povinný',
				life: 3000,
			});
			return false;
		} else if (!project.value.status || project.value.status === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Stav projektu je povinný',
				life: 3000,
			});
			return false;
		} else if (!project.value.studentId) {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Študent je povinný',
				life: 3000,
			});
			return false;
		} else if (!project.value.odbor || project.value.odbor === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Zameranie projektu je povinné',
				life: 3000,
			});
			return false;
		} else {
			return true;
		}
	};

	const createNewProject = () => {
		if (inputValidation() && !route.params?.params?.[0]) {
			createProject({
				name: project.value.name,
				description: project.value.description,
				status: project.value?.status?.[0],
				studentId: project.value?.studentId?.[0],
				teacherId: project.value.teacherId,
				odbor: project.value?.odbor?.[0],
			});
		} else if (inputValidation() && route.params?.params?.[0]) {
			updateProject({
				id: route.params?.params?.[0],
				name: project.value.name,
				description: project.value.description,
				status: project.value?.status?.[0],
				studentId: project.value?.studentId?.[0],
				teacherId: project.value.teacherId,
				odbor: project.value?.odbor?.[0],
			});
		}
	};

	const content = computed(() => {
		const content = {
			title: '',
			button: '',
		};

		if (route.params?.params?.[0]) {
			content.title = 'Upraviť projekt';
			content.button = 'Upraviť projekt';
		} else {
			content.title = 'Vytvoriť nový projekt';
			content.button = 'Vytvoriť projekt';
		}

		return content;
	});
</script>

<template>
	<div class="row tw-p-9 !tw-font-sans">
		<div class="col-xl-12">
			<div class="card custom-card">
				<div class="card-header">
					<div class="card-title">{{ content.title }}</div>
				</div>
				<div class="card-body">
					<div class="row gy-3">
						<div class="col-xl-4">
							<label for="input-label" class="form-label"> Názov projektu : </label>
							<InputText
								type="text"
								v-model="project.name"
								class="form-control"
								id="input-label"
								placeholder="Zadajte názov projektu" />
						</div>

						<div class="col-xl-12">
							<label class="form-label"> Popis projektu : </label>
							<Editor
								v-model="project.description"
								editorStyle="height: 320px"
								placeholder="Zadajte popis projektu" />
						</div>
						<div class="tw-grid md:tw-grid-cols-2 tw-gap-7">
							<div>
								<label class="form-label"> Stav projektu :</label>

								<MultiSelect
									v-model="project.status"
									display="chip"
									fluid
									:options="statusOptions"
									optionLabel="name"
									option-value="value"
									filter
									placeholder="Vyberte aktuálny stav projektu"
									:selection-limit="1"
									:maxSelectedLabels="1"
									class="w-full md:w-80" />
							</div>

							<div>
								<label class="form-label"> Študent :</label>

								<MultiSelect
									v-model="project.studentId"
									display="chip"
									fluid
									:options="studentOptions"
									optionLabel="name"
									option-value="code"
									filter
									placeholder="Vyberte študenta"
									:selection-limit="1"
									:maxSelectedLabels="1"
									class="w-full md:w-80" />
							</div>

							<div>
								<label class="form-label"> Zameranie projektu : </label>

								<MultiSelect
									v-model="project.odbor"
									display="chip"
									:options="subjectOptions"
									optionLabel="name"
									option-value="value"
									fluid
									filter
									placeholder="Vyberte zamernie projektu"
									:selection-limit="1"
									:maxSelectedLabels="1"
									class="w-full md:w-80" />
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button
						class="btn btn-primary-light btn-wave ms-auto float-end"
						@click="createNewProject">
						{{ content.button }}
					</button>
				</div>
			</div>
		</div>
	</div>

	<Toast />
</template>
