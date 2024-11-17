<template>
	<div class="row tw-p-9">
		<div class="card custom-card">
			<div class="card-header justify-content-between">
				<div class="card-title">Detaily projektu</div>

				<Button
					v-if="user?.role === 'student' && project.project.status === 'free'"
					@click="assignToProject()"
					label="Priradiť sa"
					icon="pi pi-user-plus"
					size="small"
					class="p-button-success"></Button>
			</div>
			<div class="card-body">
				<h5 class="fw-semibold mb-4 task-title">{{ project.project.title }}</h5>
				<div class="fs-15 fw-semibold mb-2">Popis Projektu :</div>
				<p class="text-muted task-description">
					{{ stripHtmlTags(project.project.description) }}
				</p>
			</div>
			<div class="card-footer">
				<div
					class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
					<div>
						<span class="d-block text-muted fs-12"> Priradený učiteľ </span>
						<div class="d-flex align-items-center">
							<span class="d-block fs-14 fw-semibold">{{ project.teacher }}</span>
						</div>
					</div>
					<div v-if="project.student">
						<span class="d-block text-muted fs-12"> Priradený študent </span>
						<span class="d-block fs-14 fw-semibold">{{ project.student }} </span>
					</div>
					<div>
						<span class="d-block text-muted fs-12">Status</span>
						<Tag
							class="!tw-capitalize !tw-text-xs"
							:value="getSeverity(project.project.status)?.label"
							:severity="getSeverity(project.project.status)?.value" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<Toast />
	<ConfirmDialog />
</template>
<script lang="ts" setup>
	import { useMutation } from '@tanstack/vue-query';
	import Toast from 'primevue/toast';
	import ConfirmDialog from 'primevue/confirmdialog';
	import useAuth from '~/composable/useAuth';

	const route = useRoute();
	const toast = useToast();
	const confirm = useConfirm();
	const stripHtmlTags = (html: any) => html.replace(/<[^>]+>/g, '');

	const { getUserIdFromToken, getUser, user } = useAuth();

	const project = ref({
		project: {
			id: null,
			title: '',
			description: '',
			status: '',
			student: null,
			teacher: null,
			odbor: '',
		},
		student: '',
		teacher: '',
	});

	const { mutate: getProjectDetails } = useMutation({
		mutationKey: ['getDetails'],
		mutationFn: () =>
			apiFetch('/project', {
				method: 'POST',
				body: {
					id: route.params?.params[0],
				},
			}),
		onSuccess: (data) => {
			project.value = data;
		},
		onError: (error) => {
			navigateTo('/dashboard');
		},
	});

	const { mutate: updateProject } = useMutation({
		mutationFn: () =>
			apiFetch('/project/update', {
				method: 'PUT',
				body: {
					id: project.value.project.id,
					student_id: getUserIdFromToken(),
					teacher_id: project.value.teacher,
					status: 'waiting',
					title: project.value.project.title,
					description: project.value.project.description,
					odbor: project.value.project.odbor,
				},
			}),
	});

	const assignToProject = () => {
		confirm.require({
			message: 'Checete sa priradiť k tomuto projektu?',
			header: 'Potvrdenie',
			icon: 'pi pi-info-circle',
			rejectLabel: 'Cancel',
			rejectProps: {
				label: 'Nie',
				severity: 'secondary',
				outlined: true,
			},
			acceptProps: {
				label: 'Ano',
				severity: 'success',
			},
			accept: () => {
				updateProject();

				setTimeout(() => {
					navigateTo('/dashboard');
				}, 1000);

				toast.add({
					severity: 'info',
					summary: 'Uspesne priradený',
					detail: 'Priradili ste sa k projektu',
					life: 3000,
				});
			},
		});
	};

	onMounted(() => {
		getProjectDetails();
		getUser();
	});

	const getSeverity = (status: any) => {
		switch (status) {
			case 'taken':
				return {
					value: 'danger',
					label: 'Zabraná',
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
</script>
