<template>
	<div
		class="card custom-card !tw-font-sans tw-transition-transform tw-duration-500 hover:-tw-translate-y-4 hover:tw-cursor-pointer !tw-mb-0"
		v-for="(card, cardIndex) in cards"
		:key="cardIndex">
		<div class="card-body" @click="() => onRoute(card)">
			<div class="d-flex align-items-center mb-3">
				<div>
					<p class="mb-0 fw-semibold fs-14 text-primary">
						{{ card.title }}
					</p>
					<p class="mb-0 fs-10 fw-semibold text-muted">
						{{ card.teacher_id }}
					</p>
				</div>
			</div>
			<div class="mb-3">
				<span
					class="text-muted tw-line-clamp-3 tw-overflow-hidden tw-text-ellipsis">
					{{ card.description }}
				</span>
			</div>
			<div class="d-flex align-items-center justify-content-between">
				<div class="float-end fs-12 fw-semibold text-muted text-end">
					<Tag
						:value="getSeverity(card.status)?.label"
						:severity="getSeverity(card.status)?.value" />
				</div>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
	import Card from 'primevue/card';
	import { useRouter } from '#app';

	interface Card {
		id: Number;
		title: String;
		teacher_id: String;
		subject: String;
		description: String;
		status: String;
	}

	const router = useRouter();
	const props = defineProps<{
		cards: Card[];
	}>();

	const onRoute = (card: Card) => {
		router.push(`/dashboard/details/${card.id}`);
	};

	const getSeverity = (status: any) => {
		switch (status) {
			case 'taken':
				return {
					value: 'danger',
					label: 'Obsadená',
				};

			case 'free':
				return {
					value: 'success',
					label: 'Voľná',
				};

			case 'waiting':
				return {
					value: 'info',
					label: 'Čakájúca',
				};
		}
	};
</script>
