<template>
	<navbar :data="navigationData" />
	<div class="landing-page-wrapper">
		<div class="main-content landing-main tw-h-max px-0 !tw-bg-[#845adfb3]">
			<section
				class="landing-banner tw-py-10"
				id="home">
				<section class="section">
					<div class="container main-banner-container pb-lg-0">
						<div class="row">
							<div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
								<div class="py-lg-5">
									<div class="mb-3">
										<h5 class="text-fixed-white op-9 tw-text-xl tw-font-sans">
											V jednoduchosti je krása
										</h5>
									</div>
									<p
										class="landing-banner-heading !tw-text-balance mb-3 tw-font-sans tw-text-5xl tw-text-white tw-font-semibold">
										Zjednodušte správu a hodnotenie školských prác
									</p>
									<div class="fs-16 mb-5 text-fixed-white op-7 tw-font-sans">
										EduManage vám teraz ponúka platformu, pomocou ktorej môžete spravovať
										všetky zadania a školské práce s maximálnou efektivitou.
									</div>
									<NuxtLink
										to="/"
										class="m-1 btn btn-primary !tw-font-sans !tw-font-light">
										Začni svoje dobrodrúžstvo
										<i class="pi pi-graduation-cap ms-2 align-middle"></i>
									</NuxtLink>
								</div>
							</div>
							<div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4">
								<div class="text-end landing-main-image landing-heading-img">
									<img
										src="../public/images/landing--image.png"
										class="img-fluid tw-hidden md:tw-block tw-rounded-2xl !tw-transition-transform !tw-duration-500 hover:-tw-translate-y-4" />
								</div>
							</div>
						</div>
					</div>
				</section>
			</section>
		</div>
	</div>
</template>

<script setup lang="ts">
	import navbar from '~/components/navbar.vue';
	import navigationData from '@/utils/data/navbar.json';
</script>
