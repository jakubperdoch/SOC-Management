<script setup lang="ts">
	import auth from '~/middleware/auth';
	import useAuth from '~/composable/useAuth';

	const { getUser, user, logout } = useAuth();

	onMounted(async () => {
		await getUser();
	});

	definePageMeta({
		layout: 'default',
		middleware: [auth],
	});
</script>

<template>
	<div class="row tw-p-9 !tw-font-sans">
		<div>
			<div class="card custom-card overflow-hidden">
				<div class="card-body p-0">
					<div
						class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
						<div>
							<span class="avatar avatar-xxl avatar-rounded me-3 bg-light-transparent">
								<Icon name="iconamoon:profile-fill" />
							</span>
						</div>
						<div class="flex-fill main-profile-info">
							<div class="d-flex align-items-center justify-content-between">
								<h6 class="fw-semibold mb-1 text-fixed-white">
									{{ user?.name }} {{ user?.surname }}
								</h6>
								<button class="btn btn-light btn-wave" @click="logout">
									Odhlásiť sa
								</button>
							</div>
							<p class="mb-1 text-muted text-fixed-white op-7">
								{{ user?.email }}
							</p>
							<p class="mb-0 text-muted text-fixed-white op-7 text-capitalize">
								{{ user?.role }}
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
