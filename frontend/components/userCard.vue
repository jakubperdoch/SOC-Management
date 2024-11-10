<template>
	<div
		class="tw-col-span-4 !tw-flex !tw-flex-col md:tw-col-span-2 lg:tw-col-span-1 tw-bg-white tw-rounded-2xl tw-shadow">
		<div class="tw-flex tw-justify-end tw-items-center tw-px-3 tw-pt-3">
			<div class="dropdown">
				<button
					class="btn btn-sm btn-icon btn-light btn-wave"
					type="button"
					data-bs-toggle="dropdown"
					aria-expanded="false">
					<i class="pi pi-ellipsis-h"></i>
				</button>
				<ul class="dropdown-menu">
					<li>
						<button class="dropdown-item" @click="isModalVisible = !isModalVisible">
							Upraviť
						</button>
					</li>
					<li>
						<button class="dropdown-item" @click="props.deleteUserDialog(2)">
							Vymazať
						</button>
					</li>
				</ul>
			</div>
		</div>

		<div class="card-body p-0">
			<div
				class="d-flex flex-wrap align-item-center mt-sm-0 mt-5 justify-content-between border-bottom border-block-end-dashed p-3">
				<div>
					<p class="mb-0 fw-semibold fs-16 text-truncate">
						<a href="javascript:void(0);">Michal Palica</a>
					</p>
					<p class="mb-0 fs-12 text-muted">michalpalica@spsit.sk</p>
				</div>
			</div>
			<div
				class="team-member-stats d-sm-flex justify-content-evenly !tw-flex tw-flex-wrap">
				<div class="text-center p-3 my-auto">
					<p class="fw-semibold mb-0">Projekty</p>
					<span class="text-muted fs-12">45</span>
				</div>
				<div class="text-center p-3 my-auto">
					<p class="fw-semibold mb-0">Zameranie</p>
					<span class="text-muted fs-12">IT</span>
				</div>
			</div>
		</div>
	</div>

	<DialogEdit v-model:isModalVisible="isModalVisible" />
</template>

<script setup lang="ts">
	const props = defineProps<{
		deleteUserDialog: (id: number) => void;
	}>();

	const isModalVisible = ref(false);
</script>
