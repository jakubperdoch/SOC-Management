<template>
	<div class="landing-page-wrapper">
		<!-- Main Section -->
		<div class="main-content landing-main tw-h-max px-0 !tw-bg-[#845adfb3]">
			<section class="landing-banner tw-py-10" id="home">
				<section class="section">
					<div class="container main-banner-container pb-lg-0">
						<div class="row">
							<div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
								<div class="py-lg-5">
									<div class="mb-3">
										<h5 class="text-fixed-white op-9 md:tw-text-xl tw-font-sans">
											V jednoduchosti je krása
										</h5>
									</div>
									<p
										class="landing-banner-heading !tw-text-balance mb-3 tw-font-sans tw-text-3xl md:tw-text-5xl tw-text-white tw-font-semibold">
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
							<div
								class="col-xxl-5 col-xl-5 col-lg-5 col-md-4 tw-flex tw-items-end md:tw-items-center">
								<div class="text-end landing-main-image landing-heading-img">
									<img
										src="../public/images/landing--image.png"
										class="img-fluid tw-hidden lg:tw-block tw-rounded-2xl tw-max-h-96 !tw-transition-transform !tw-duration-500 hover:-tw-translate-y-4" />
								</div>
							</div>
						</div>
					</div>
				</section>
			</section>
		</div>

		<!-- Hero Section -->
		<section class="section tw-mt-16" id="team">
			<div class="container text-center">
				<p class="fs-12 fw-semibold text-success mb-1">
					<span class="landing-section-heading"> Náš tím </span>
				</p>
				<h3 class="fw-semibold mb-2">
					Skvelé výsledky dosahujeme len vďaka skvelému tímu
				</h3>
				<div class="row justify-content-center">
					<div class="col-xl-7">
						<p class="text-muted fs-15 mb-5 fw-normal">
							Naši členovia tímu sú skvelí odborníci, ktorí sú pripravení pomôcť vám s
							akýmkoľvek problémom, ktoré by ste mohli mať.
						</p>
					</div>
				</div>
				<div class="row">
					<div class="tw-grid md:tw-grid-cols-2 gap-5">
						<div
							class="card custom-card text-center team-card"
							v-for="(member, memberId) in teamMembers"
							:key="memberId">
							<div class="card-body p-5">
								<span class="avatar avatar-rounded mb-3 team-avatar">
									<img class="!tw-w-24 !tw-h-24" :src="member.image" alt="avatar" />
									/>
								</span>
								<p class="fw-semibold fs-17 mb-0 text-default">{{ member.name }}</p>
								<span class="text-muted fs-14 text-primary fw-semibold">{{
									member.role
								}}</span>
								<p class="text-muted mt-2 fs-13">
									{{ member.descritpion }}
								</p>
								<div class="mt-2 tw-flex tw-justify-center tw-gap-4">
									<a
										:href="member.linkedin"
										class="btn btn-primary btn-sm btn-icon btn-icon-start">
										<i class="pi pi-link !tw-text-white"></i>
									</a>

									<a
										:href="member.github"
										class="btn btn-primary btn-sm btn-icon btn-icon-start">
										<i class="pi pi-github !tw-text-white"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script setup lang="ts">
	definePageMeta({
		title: 'EduManage',
		description: 'EduManage - správa školských prác',
		layout: 'default',
	});

	const teamMembers = ref([
		{
			name: 'Jakub Perďoch',
			role: 'Frontend Developer',
			descritpion: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			image: 'https://github.com/jakubperdoch.png',
			linkedin: 'https://www.linkedin.com/in/jakub-per%C4%8Foch/',
			github: '',
		},
		{
			name: 'Kristian Válek',
			role: 'Backend Developer',
			descritpion: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			image: 'https://github.com/Los-Kaleros.png',
			linkedin: 'https://www.linkedin.com/in/jakub-per%C4%8Foch/',
		},
	]);
</script>
