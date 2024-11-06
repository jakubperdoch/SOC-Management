<template>
	<div class="container">
		<div
			class="row justify-content-center align-items-center authentication authentication-basic h-100">
			<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
				<div class="card custom-card">
					<div class="card-body p-5">
						<p class="h5 fw-semibold mb-2 text-center">Prihlásenie</p>
						<p class="mb-4 text-muted op-7 fw-normal text-center">
							Vitajte späť, prihláste sa do svojho účtu.
						</p>
						<div class="row gy-3">
							<div class="col-xl-12">
								<label
									for="signin-password"
									class="form-label text-default d-block">
									Email
								</label>
								<IconField class="w-100">
									<InputIcon class="pi pi-user" />
									<InputText
										id="username"
										v-model="user.email"
										type="email"
										fluid />
								</IconField>
							</div>
							<div class="col-xl-12 mb-2">
								<label
									for="signin-password"
									class="form-label text-default d-block">
									Heslo
								</label>
								<div class="input-group">
									<IconField
										class="w-100"
										id="signin-password">
										<InputIcon
											class="pi pi-lock"
											style="z-index: 1" />
										<Password
											v-model="user.password"
											toggleMask
											fluid
											:inputStyle="inputStyle"
											:feedback="false" />
									</IconField>
								</div>
							</div>
							<div class="col-xl-12 d-grid mt-2">
								<Button
									@click="loginUserIn"
									class="btn btn-lg btn-primary">
									Prihlásiť sa
								</Button>
							</div>
						</div>
						<div class="text-center">
							<p class="fs-12 text-muted mt-3">
								Nemáte účet?
								<NuxtLink
									to="/authentication/sign-up/basic"
									class="text-primary">
									Zaregistrovať sa
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

	const { login } = useAuth();

	const toast = useToast();
	const router = useRouter();
	const user = ref({
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
		} else {
			return true;
		}
	};

	const {
		mutate: loginMutation,
		status: claimStatus,
		error,
	} = useMutation({
		mutationFn: () => login(user.value.email, user.value.password),
		onSuccess: () => {
			setTimeout(() => {
				router.push('/');
			}, 1000);

			toast.add({
				severity: 'success',
				summary: 'Úspešné prihlásenie',
				detail: 'Vitajte späť',
				life: 3000,
			});
		},
		onError: () => {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Nesprávne meno alebo heslo',
				life: 3000,
			});
		},
	});

	const loginUserIn = () => {
		if (inputValidation()) {
			loginMutation();
		}
	};

	const inputStyle = {
		paddingLeft: `calc((var(--p-form-field-padding-x) * 2) + var(--p-icon-size))`,
		paddingRight: `var(--p-form-field-padding-x)`,
	};
</script>

<style scoped></style>
