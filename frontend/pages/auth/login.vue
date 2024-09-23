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
									Meno používateľa
								</label>
								<IconField class="w-100">
									<InputIcon class="pi pi-user" />
									<InputText
										id="username"
										v-model="user.username"
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
									@click="login"
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
	import { useAuthStore } from '#imports';
	import { useToast } from 'primevue/usetoast';
	import Button from 'primevue/button';
	import { useRouter } from '#imports';

	const { logUserIn } = useAuthStore();
	const toast = useToast();
	const router = useRouter();
	const user = ref({
		username: '',
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
		} else if (!user.value.username || user.value.username === '') {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Meno používateľa je povinné',
				life: 3000,
			});
			return false;
		} else {
			return true;
		}
	};

	const login = async () => {
		try {
			if (!inputValidation()) {
				return;
			}

			const data = await logUserIn(user.value);

			if (data.authenticated) {
				setTimeout(() => {
					router.push('/');
				}, 1000);

				toast.add({
					severity: 'success',
					summary: 'Úspešné prihlásenie',
					detail: 'Vitajte späť',
					life: 3000,
				});
			} else {
				toast.add({
					severity: 'error',
					summary: 'Nastala chyba',
					detail: 'Nesprávne meno alebo heslo',
					life: 3000,
				});
			}
		} catch (e) {
			toast.add({
				severity: 'error',
				summary: 'Nastala chyba',
				detail: 'Nastala chyba pri prihlásení',
				life: 3000,
			});
			console.error(e);
		}
	};

	const inputStyle = {
		paddingLeft: `calc((var(--p-form-field-padding-x) * 2) + var(--p-icon-size))`,
		paddingRight: `var(--p-form-field-padding-x)`,
	};
</script>

<style scoped></style>
