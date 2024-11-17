<script lang="ts" setup>
	import auth from '@/middleware/auth';
	import Editor from 'primevue/editor';
	import { useMutation } from '@tanstack/vue-query';
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
		project.value.teacher = userId;

		getStudents();
		if (route.params?.params?.[0]) {
			getProject();
			project.value.id = Number(route.params?.params?.[0]);
		}
	});

	const project = ref<Project>({
		id: null,
		name: '',
		description: '',
		status: '',
		student: null,
		teacher: null,
		odbor: '',
	});

	const studentOptions = ref([]);

	const { mutate: createProject } = useMutation({
		mutationFn: (data: any) =>
			apiFetch('/project/create', {
				method: 'POST',
				body: {
					title: data.name,
					description: data.description,
					status: data.status[0],
					student_id: data.student[0] ? data.student[0] : '',
					teacher_id: data.teacher,
					odbor: data.odbor[0],
				},
			}),
		onSuccess: () => {
			setTimeout(() => {
				router.push('/dashboard');
			}, 1000);

			toast.add({
				severity: 'success',
				summary: 'Projekt bol úspešne vytvorený',
				life: 3000,
			});
		},

		onError: (err) => {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Nepodarilo sa vytvoriť projekt',
				life: 3000,
			});

			console.log(err);
		},
	});

	const { mutate: updateProject } = useMutation({
		mutationFn: (data: any) =>
			apiFetch('/project/update', {
				method: 'PUT',
				body: {
					id: data.id,
					title: data.name,
					description: data.description,
					status: data.status[0],
					student_id: data.student[0],
					teacher_id: data.teacher,
					odbor: data.odbor[0],
				},
			}),
		onSuccess: () => {
			setTimeout(() => {
				router.push('/dashboard');
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
			apiFetch('/project', {
				method: 'POST',
				body: { id: Number(route.params?.params?.[0]) },
			}),
		onSuccess: (data) => {
			project.value = {
				id: data.project.id,
				name: data.project.title,
				description: data.project.description,
				status: [data.project.status],
				student:
					Number(data.project.student) === 0 ? null : [Number(data.project.student)],
				teacher: Number(data.project.teacher),
				odbor: [data.project.odbor],
			};
		},
		onError: () => {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Nepodarilo sa načítať projekt',
				life: 3000,
			});
		},
	});

	const { mutate: getStudents } = useMutation({
		mutationFn: () =>
			apiFetch('/users', {
				method: 'POST',
				body: {
					role: 'student',
				},
			}),
		onSuccess: (data) => {
			studentOptions.value = data;
		},
		onError: () => {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Nepodarilo sa načítať študentov',
				life: 3000,
			});
		},
	});

	const inputValidation = () => {
		if (!project.value.name) {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Názov projektu je povinný',
				life: 3000,
			});
			return false;
		}
		if (!project.value.description) {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Popis projektu je povinný',
				life: 3000,
			});
			return false;
		}
		if (!project.value.status) {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Stav projektu je povinný',
				life: 3000,
			});
			return false;
		}
		if (!project.value.student && route.params?.params?.[0]) {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Študent je povinný',
				life: 3000,
			});
			return false;
		}
		if (!project.value.odbor) {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Zameranie projektu je povinné',
				life: 3000,
			});
			return false;
		}
		return true;
	};

	const createNewProject = () => {
		if (inputValidation()) {
			if (!route.params?.params?.[0]) {
				createProject(project.value);
				console.log(project.value);
			} else {
				updateProject(project.value);
			}
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
								class="form-control !tw-text-sm"
								id="input-label"
								placeholder="Zadajte názov projektu" />
						</div>

						<div class="col-xl-12">
							<label class="form-label"> Popis projektu : </label>
							<Editor v-model="project.description" editorStyle="height: 320px" />
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
									v-model="project.student"
									display="chip"
									fluid
									:options="studentOptions"
									optionLabel="surname"
									option-value="id"
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
