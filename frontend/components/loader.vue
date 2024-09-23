<template>
	<div
		class="loader-wrapper"
		v-if="loader">
		<div class="row loader-img">
			<div class="col-12">
				<div
					class="spinner-border"
					role="status"></div>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
	let router = useRouter();
	let loader = ref<boolean>(true);
	onMounted(() => {
		setTimeout(() => {
			loader.value = false;
		}, 1000);
	});
	watch(
		() => router,
		() => {
			loader.value = true;
			setTimeout(() => {
				loader.value = false;
			}, 3000);
		},
		{ deep: true }
	);
</script>

<style scoped></style>
