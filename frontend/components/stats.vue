<template>
	<div
		class="card custom-card tw-col-start-4 tw-col-span-1 !tw-font-sans !tw-mb-0">
		<div class="card-header justify-content-between">
			<div class="card-title">{{ props.data.title }}</div>
			<button
				@click="() => router.push('/dashboard/details')"
				class="btn btn-sm btn-primary btn-wave waves-light !tw-flex !tw-items-center !tw-justify-center">
				<i
					class="pi pi-plus fw-semibold align-middle me-1"
					style="font-size: 0.5rem"></i>
				Nový projekt
			</button>
		</div>
		<div class="card-body">
			<div class="d-flex align-items-center mb-3">
				<h4 class="fw-bold mb-0">{{ data.overallNumber }}</h4>
				<div class="ms-2">
					<span class="text-muted ms-1"> Celkový počet projektov </span>
				</div>
			</div>
			<div class="progress-stacked progress-animate progress-xs mb-4">
				<div
					class="progress-bar bg-success"
					role="progressbar"
					:style="{
						width: `${percentageCalc(data.openStatus, data.overallNumber)}%`,
					}"
					aria-valuenow="21"
					aria-valuemin="0"
					aria-valuemax="100"></div>
				<div
					class="progress-bar bg-warning"
					role="progressbar"
					:style="{
						width: `${percentageCalc(data.waitingStatus, data.overallNumber)}%`,
					}"
					aria-valuenow="26"
					aria-valuemin="0"
					aria-valuemax="100"></div>
				<div
					class="progress-bar bg-danger"
					role="progressbar"
					:style="{
						width: `${percentageCalc(data.takenStatus, data.overallNumber)}%`,
					}"
					aria-valuenow="18"
					aria-valuemin="0"
					aria-valuemax="100"></div>
			</div>
			<ul class="list-unstyled mb-0 pt-2 crm-deals-status">
				<li class="success">
					<div class="d-flex align-items-center justify-content-between">
						<div>Voľné projekty</div>
						<div class="fs-12 text-muted">{{ data.openStatus }}</div>
					</div>
				</li>
				<li class="warning">
					<div class="d-flex align-items-center justify-content-between">
						<div>Čakajuče projekty</div>
						<div class="fs-12 text-muted">{{ data.waitingStatus }}</div>
					</div>
				</li>
				<li class="danger">
					<div class="d-flex align-items-center justify-content-between">
						<div>Zabrané projekty</div>
						<div class="fs-12 text-muted">{{ data.takenStatus }}</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</template>

<script setup lang="ts">
	import { useRouter } from '#app';

	interface Stat {
		title: string;
		overallNumber: number;
		openStatus: number;
		waitingStatus: number;
		takenStatus: number;
	}

	const router = useRouter();
	const props = defineProps<{
		data: Stat;
	}>();

	const percentageCalc = (value: number, total: number) => {
		return (value / total) * 100;
	};
</script>
