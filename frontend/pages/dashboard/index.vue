<template>
	<section>
		<section
			class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8 tw-h-fit"
			v-if="user?.role == 'teacher'">
			<Stats :data="statsData" />
			<ProjectTable :cells="ProjectData" />
		</section>

		<section
			v-if="user?.role == 'student'"
			class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8">
			<Card :cards="ProjectData" />
		</section>

		<section
			v-if="user?.role == 'admin'"
			class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8">
			<Stats :data="statsData" />
			<ProjectTable :cells="ProjectData" />
			<UserTable />
		</section>
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

	const ProjectData = ref([]);
	const teacherName = `${user.value?.name} ${user.value?.surname}`;

	const {
		mutate: getProjects,
		status: projectsStatus,
		error,
	} = useMutation({
		mutationFn: () =>
			apiFetch('/project-info', {
				method: 'POST',
				body: {
					id: 4,
					role: user.value?.role,
				},
			}),
		onSuccess: (data) => {
			ProjectData.value = data;
		},
		onError: (error) => {
			console.log(error);
		},
	});

	const statsData = computed(() => {
		const projectsByTeacher = ProjectData.value.filter(
			(project: any) => project.teacher === teacherName
		);

		return {
			title: 'Vaše Projekty',
			overallNumber: projectsByTeacher.length,
			openStatus: projectsByTeacher.filter(
				(project: any) => project.status === 'Voľná'
			).length,
			waitingStatus: projectsByTeacher.filter(
				(project: any) => project.status === 'Čakajúca'
			).length,
			takenStatus: projectsByTeacher.filter(
				(project: any) => project.status === 'Zabraná'
			).length,
		};
	});

	definePageMeta({
		layout: 'default',
		middleware: [auth],
	});
</script>
