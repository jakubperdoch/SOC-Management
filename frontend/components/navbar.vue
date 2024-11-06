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
				class="navbar-toggler !tw-text-white hover:!tw-text-black"
				data-bs-toggle="offcanvas"
				data-bs-target="#offcanvasNavbar"
				aria-controls="offcanvasNavbar">
				<i class="pi pi-bars"></i>
			</Button>
			<div
				class="offcanvas offcanvas-start !tw-w-64"
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
							v-for="(navItem, itemIndex) in filteredData"
							:key="itemIndex">
							<a
								class="nav-link hover:!tw-text-[#7031f7] !tw-font-extralight tw-font-sans"
								:class="[
									route.path == navItem.route
										? '!tw-text-[#7031f7]'
										: 'min-[991px]:!tw-text-white',
								]"
								aria-current="page"
								:href="navItem.route"
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
	import useAuth from '~/composable/useAuth';

	const authStore = useAuth();
	const route = useRoute();

	interface Sidebar {
		title: string;
		route: string;
		role: string;
	}

	const props = defineProps<{
		data: Sidebar[];
	}>();

	const filteredData = props.data.filter((item) => {
		const token = useCookie('token').value;

		if (!item.role) {
			if (
				token &&
				(item.route === 'auth/login' || item.route === 'auth/register')
			) {
				return false;
			}
			return true;
		}

		if (token && item.route.startsWith('auth')) {
			return false;
		}

		return (
			authStore.user.value?.role && item.role.includes(authStore.user.value.role)
		);
	});
</script>
