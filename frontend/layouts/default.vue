<template>
	<navbar :data="navigationData" :userData />
	<slot />
</template>

<script setup lang="ts">
	import navbar from '~/components/navbar.vue';
	import navigationData from '@/utils/data/navbar.json';
	import { useMutation } from '@tanstack/vue-query';
	import useAuth from '~/composable/useAuth';

	const { getUserIdFromToken } = useAuth();
	const userData = ref(null);

	const { mutate: mutateUser } = useMutation({
		mutationFn: () =>
			apiFetch('/student/info', {
				method: 'POST',
				body: {
					id: getUserIdFromToken(),
				},
			}),
		onSuccess: (data) => {
			userData.value = data;
		},
		onError: (error) => {
			console.log(error);
		},
	});

	onMounted(() => {
		if (getUserIdFromToken()) {
			mutateUser();
		}
	});
</script>
