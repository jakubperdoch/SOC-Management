<template>
	<div class="container !tw-font-sans">
		<div
			class="row justify-content-center align-items-center authentication authentication-basic h-100">
			<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
				<div class="card custom-card">
					<div class="card-body p-5">
						<p class="h5 fw-semibold mb-2 text-center">Registrácia</p>
						<p class="mb-4 text-muted op-7 fw-normal text-center">
							Vitajte, zaregistrujte sa do svojho účtu.
						</p>

						<div class="row gy-3">
							<div class="col-lg-6">
								<label for="signin-password" class="form-label text-default d-block">
									Meno
								</label>
								<IconField class="w-100">
									<InputIcon class="pi pi-user" />
									<InputText
										class="!tw-text-sm"
										id="username"
										v-model="user.name"
										type="text"
										fluid />
								</IconField>
							</div>
							<div class="col-lg-6">
								<label for="signin-password" class="form-label text-default d-block">
									Priezvisko
								</label>
								<IconField class="w-100">
									<InputIcon class="pi pi-user" />
									<InputText
										class="!tw-text-sm"
										id="username"
										v-model="user.surname"
										type="text"
										fluid />
								</IconField>
							</div>

							<div class="col-xl-12">
								<label for="signin-password" class="form-label text-default d-block">
									Email
								</label>
								<IconField class="w-100">
									<InputIcon class="pi pi-envelope" />
									<InputText
										class="!tw-text-sm"
										id="username"
										v-model="user.email"
										type="email"
										fluid />
								</IconField>
							</div>

							<div class="col-xl-12 mb-2">
								<label for="signin-password" class="form-label text-default d-block">
									Heslo
								</label>
								<div class="input-group">
									<IconField class="w-100" id="signin-password">
										<InputIcon class="pi pi-lock" style="z-index: 1" />
										<Password
											class="!tw-text-sm"
											v-model="user.password"
											toggleMask
											fluid
											:inputStyle="inputStyle"
											:feedback="false" />
									</IconField>
								</div>
							</div>

							<div class="col-xl-12 d-grid mt-2">
								<Button @click="registerUser" class="btn btn-lg btn-primary">
									Zaregistrovať sa
								</Button>
							</div>
						</div>
						<div class="text-center">
							<p class="fs-12 text-muted mt-3">
								Máte účet?
								<NuxtLink to="/auth/login" class="text-primary">
									Prihlásiť sa
								</NuxtLink>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<Toast />
	</div>
</template>

<script setup lang="ts">
	import useAuth from '~/composable/useAuth';
	import { useToast } from 'primevue/usetoast';
	import Button from 'primevue/button';
	import { useRouter } from '#imports';
	import auth from '~/middleware/auth';
	import { useMutation } from '@tanstack/vue-query';

	definePageMeta({
		title: 'EduManage',
		description: 'EduManage - správa školských prác',
		middleware: [auth],
		layout: 'custom',
	});

	const { register } = useAuth();

	const toast = useToast();
	const router = useRouter();
	const user = ref({
		name: '',
		surname: '',
		email: '',
		password: '',
	});

	const inputValidation = () => {
		if (!user.value.password || user.value.password === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Heslo je povinné',
				life: 3000,
			});

			return false;
		} else if (!user.value.email || user.value.email === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Email je povinny',
				life: 3000,
			});

			return false;
		} else if (!user.value.name || user.value.name === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Meno je povinné',
				life: 3000,
			});

			return false;
		} else if (!user.value.surname || user.value.surname === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Priezvisko je povinné',
				life: 3000,
			});

			return false;
		} else {
			return true;
		}
	};

	const {
		mutate: registerMutation,
		status: claimStatus,
		error,
	} = useMutation({
		mutationFn: () =>
			register(
				user.value.name,
				user.value.surname,
				user.value.email,
				user.value.password,
				'student'
			),
		onSuccess: () => {
			setTimeout(() => {
				navigateTo({
					path: '/auth/login',
					query: { email: user.value.email },
				});
			}, 1000);

			toast.add({
				severity: 'success',
				summary: 'Úspešná registrácia',
				detail: 'Vitajte v systéme',
				life: 3000,
			});
		},
		onError: () => {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Nesprávne zadané údaje',
				life: 3000,
			});
		},
	});

	const registerUser = () => {
		if (inputValidation()) {
			registerMutation();
		}
	};

	const inputStyle = {
		paddingLeft: `calc((var(--p-form-field-padding-x) * 2) + var(--p-icon-size))`,
		paddingRight: `var(--p-form-field-padding-x)`,
	};
</script>

<style scoped></style>
