<template>
	<section class="">
		<section
			class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8"
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
	import ProjectData from '~/utils/data/projects.json';
	import ProjectTable from '~/components/table.vue';
	import Stats from '~/components/stats.vue';
	import Card from '~/components/card.vue';
	import auth from '~/middleware/auth';
	import useAuth from '~/composable/useAuth';

	const { getUser, user } = useAuth();

	onMounted(async () => {
		try {
			await getUser();
		} catch (err) {
			console.log(err);
		}
	});

	const teacherName = 'Jozef Mrkvička';

	const statsData = computed(() => {
		const projectsByTeacher = ProjectData.filter(
			(project) => project.teacher === teacherName
		);

		return {
			title: 'Vaše Projekty',
			overallNumber: projectsByTeacher.length,
			openStatus: projectsByTeacher.filter((project) => project.status === 'Voľná')
				.length,
			waitingStatus: projectsByTeacher.filter(
				(project) => project.status === 'Čakajúca'
			).length,
			takenStatus: projectsByTeacher.filter(
				(project) => project.status === 'Zabraná'
			).length,
		};
	});

	definePageMeta({
		layout: 'default',
		middleware: [auth],
	});
</script>
