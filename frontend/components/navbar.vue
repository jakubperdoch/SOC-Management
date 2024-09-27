<template>
	<nav
		class="navbar navbar-expand-lg !tw-rounded-none !tw-bg-[#845adfb3] !tw-py-0 tw-fixed">
		<div class="container-fluid tw-flex tw-items-center tw-justify-center">
			<img
				src="../public/images/logo.png"
				class="navbar-brand tw-w-16" />
			<Button
				outlined
				severity="secondary"
				class="navbar-toggler"
				data-bs-toggle="offcanvas"
				data-bs-target="#offcanvasNavbar"
				aria-controls="offcanvasNavbar">
				<i class="pi pi-bars"></i>
			</Button>
			<div
				class="offcanvas offcanvas-start"
				tabindex="-1"
				id="offcanvasNavbar"
				aria-labelledby="offcanvasNavbarLabel">
				<div class="offcanvas-header !tw-items-start">
					<img
						src="../public/images/logo.png"
						class="navbar-brand tw-w-24" />
					<button
						type="button"
						class="btn-close mt-1"
						data-bs-dismiss="offcanvas"
						aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
						<li
							class="nav-item"
							v-for="(navItem, itemIndex) in props.data"
							:key="itemIndex">
							<a
								class="nav-link !tw-text-white !tw-font-extralight tw-font-sans"
								aria-current="page"
								href="javascript:void(0);"
								>{{ navItem.title }}</a
							>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
</template>

<script setup lang="ts">
	import Sidebar from 'primevue/sidebar';
	import { useRoute } from '#app';

	interface Sidebar {
		title: string;
		route: string;
	}

	const route = useRoute();

	const props = defineProps<{
		data: Sidebar[];
	}>();
</script>
