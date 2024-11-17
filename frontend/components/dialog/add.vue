<template>
	<Dialog
		v-model:visible="visible"
		modal
		class="!tw-font-sans"
		header="Vyplňte údaje"
		:style="{ width: '25rem' }">
		<span class="tw-text-surface-500 tw-dark:text-surface-400 tw-block tw-mb-8">
			Vytvorenie učiteľského účtu
		</span>

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
				<Button @click="addTeacher" class="btn btn-lg btn-primary">
					Vytvoriť učiteľský účet
				</Button>
			</div>
		</div>
	</Dialog>
</template>

<script setup lang="ts">
	import { useMutation } from '@tanstack/vue-query';
	import { ref } from 'vue';
	import { defineEmits } from 'vue';
	import type { User } from '~/interfaces/user';

	const props = defineProps<{
		isModalVisible: boolean;
	}>();

	const toast = useToast();
	const emit = defineEmits(['update:isModalVisible', 'refetch']);
	const visible = ref(props.isModalVisible || false);

	const user = ref<User>({
		name: '',
		surname: '',
		email: '',
		role: 'teacher',
		password: '',
	});

	const { mutate } = useMutation({
		mutationFn: () =>
			apiFetch('/register', {
				method: 'POST',
				body: {
					id: user.value.id,
					email: user.value.email,
					password: user.value.password,
					name: user.value.name,
					surname: user.value.surname,
					role: user.value.role,
				},
			}),

		onSuccess: () => {
			setTimeout(() => {
				visible.value = false;
			}, 500);

			emit('refetch');
			toast.add({
				severity: 'success',
				summary: 'Úspešne vytvorené',
				detail: 'Učiteľ bol vytvorený',
				life: 3000,
			});
		},
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

	const addTeacher = () => {
		if (!inputValidation()) {
			return;
		}
		mutate();
	};

	watch(
		() => props.isModalVisible,
		(value) => {
			visible.value = value;
		}
	);

	watch(
		() => visible.value,
		(value) => {
			emit('update:isModalVisible', value);
		}
	);

	const inputStyle = {
		paddingLeft: `calc((var(--p-form-field-padding-x) * 2) + var(--p-icon-size))`,
		paddingRight: `var(--p-form-field-padding-x)`,
	};
</script>
