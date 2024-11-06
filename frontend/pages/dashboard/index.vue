<template>
	<section
		class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8">
		<section v-if="authStore.user.value?.role == 'ROLE_TEACHER'"></section>
		<stats :data="statsData" />

		<section v-if="authStore.user.value?.role == 'ROLE_STUDENT'">
			<card :cards="ProjectData" />
		</section>

		<!-- <section v-if="authStore.user.role == 'ROLE_ADMIN'"></section> -->
	</section>
</template>
<script setup lang="ts">
	import ProjectData from '~/utils/data/projects.json';
	import stats from '~/components/stats.vue';
	import card from '~/components/card.vue';
	import auth from '~/middleware/auth';
	import useAuth from '~/composable/useAuth';

	const authStore = useAuth();

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
				(project) => project.status === 'Zabránená'
			).length,
		};
	});

	definePageMeta({
		layout: 'default',
		middleware: [auth],
	});
</script>
