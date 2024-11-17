<template>
	<section v-if="ProjectData">
		<section
			class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8 tw-h-fit"
			v-if="user?.role == 'teacher'">
			<Stats :data="statsData" />
			<ProjectTable @refresh="getProjects" :cells="ProjectData.projects" />
		</section>

		<section
			v-if="
				user?.role == 'student' &&
				ProjectData.message !== 'Student already has a project.'
			"
			class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8">
			<Card :cards="ProjectData.projects" />
		</section>

		<section
			v-if="
				user?.role == 'student' &&
				ProjectData.message === 'Student already has a project.'
			">
			<Details :project-id="ProjectData.project_details?.id" />
		</section>

		<section
			v-if="user?.role == 'admin'"
			class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8">
			<Stats :data="statsData" />
			<ProjectTable :cells="ProjectData.projects" />
			<UserTable />
		</section>
	</section>

	<section v-else>
		<Loader />
	</section>
</template>
<script setup lang="ts">
	import ProjectTable from '~/components/table.vue';
	import Stats from '~/components/stats.vue';
	import Card from '~/components/card.vue';
	import auth from '~/middleware/auth';
	import useAuth from '~/composable/useAuth';
	import { useMutation } from '@tanstack/vue-query';

	const { getUser, user, getUserIdFromToken } = useAuth();

	onMounted(async () => {
		try {
			await getUser();
			getProjects();
		} catch (err) {
			console.log(err);
		}
	});

	const ProjectData = ref();

	const {
		mutate: getProjects,
		status: projectsStatus,
		error,
	} = useMutation({
		mutationFn: () =>
			apiFetch('/project/info', {
				method: 'POST',
				body: {
					id: getUserIdFromToken(),
					role: user.value?.role,
				},
			}),
		onSuccess: (data) => {
			ProjectData.value = data || {};
		},
		onError: (error) => {
			console.log(error);
		},
	});

	const statsData = computed(() => {
		const projects = ProjectData.value?.projects || [];
		return {
			title: 'Vaše Projekty',
			overallNumber: projects.length,
			openStatus: projects.filter(
				(project: any) => project.project_details?.status === 'free'
			).length,
			waitingStatus: projects.filter(
				(project: any) => project.project_details?.status === 'waiting'
			).length,
			takenStatus: projects.filter(
				(project: any) => project.project_details?.status === 'taken'
			).length,
		};
	});

	definePageMeta({
		layout: 'default',
		middleware: [auth],
		roles: ['student', 'teacher', 'admin'],
	});
</script>
