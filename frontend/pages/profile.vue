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
		<div class="col-xxl-4 col-xl-12">
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
									<i class="ri-add-line me-1 align-middle"></i>
									Odhlásiť sa
								</button>
							</div>
							<p class="mb-1 text-muted text-fixed-white op-7">
								{{ user?.email }}
							</p>
							<p class="mb-0 text-muted text-fixed-white op-7 text-capitalize">
								{{ user?.role }}
							</p>
							<div class="d-flex mb-0" v-if="user?.role === 'teacher'">
								<div class="me-4">
									<p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">113</p>
									<p class="mb-0 fs-11 op-5 text-fixed-white">Projects</p>
								</div>
								<div class="me-4">
									<p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">12.2k</p>
									<p class="mb-0 fs-11 op-5 text-fixed-white">Followers</p>
								</div>
								<div class="me-4">
									<p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">128</p>
									<p class="mb-0 fs-11 op-5 text-fixed-white">Following</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
