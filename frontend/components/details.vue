<template>
	<div class="row tw-p-9">
		<div class="card custom-card">
			<div class="card-header justify-content-between">
				<div class="card-title">Detaily projektu</div>
			</div>
			<div class="card-body">
				<h5 class="fw-semibold mb-4 task-title">{{ project.project.title }}</h5>
				<div class="fs-15 fw-semibold mb-2">Popis Projektu :</div>
				<p class="text-muted task-description">
					{{ project.project.description }}
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
					<div>
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
</template>
<script lang="ts" setup>
	import { useMutation } from '@tanstack/vue-query';

	const props = defineProps<{
		projectId: any;
	}>();

	const project = ref({
		project: {
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
					id: props.projectId,
				},
			}),
		onSuccess: (data) => {
			project.value = data;
		},
		onError: (error) => {
			navigateTo('/');
		},
	});

	onMounted(() => {
		getProjectDetails();
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
