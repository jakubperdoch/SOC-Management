<template>
	<div
		class="card custom-card !tw-font-sans tw-transition-transform tw-duration-500 hover:-tw-translate-y-4 hover:tw-cursor-pointer !tw-mb-0"
		v-for="(card, cardIndex) in cards"
		:key="cardIndex">
		<div class="card-body" @click="() => onRoute(card)">
			<div class="d-flex align-items-center mb-3">
				<div>
					<p class="mb-0 fw-semibold fs-14 text-primary">
						{{ card.project_details.title }}
					</p>
					<p class="mb-0 fs-10 fw-semibold text-muted">
						{{ card.teacher }}
					</p>
				</div>
			</div>
			<div class="mb-3">
				<span
					class="text-muted tw-line-clamp-3 tw-overflow-hidden tw-text-ellipsis">
					{{ stripHtmlTags(card.project_details.description) }}
				</span>
			</div>
			<div class="d-flex align-items-center justify-content-between">
				<div class="float-end fs-12 fw-semibold text-muted text-end">
					<Tag
						:value="getSeverity(card.project_details.status)?.label"
						:severity="getSeverity(card.project_details.status)?.value" />
				</div>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
	import Card from 'primevue/card';
	import { useRouter } from '#app';

	interface Card {
		project_details: {
			id: '';
			title: '';
			description: '';
			status: '';
			student: null;
			teacher: null;
			odbor: '';
		};
		student: '';
		teacher: '';
	}

	const router = useRouter();
	const stripHtmlTags = (html: any) => html.replace(/<[^>]+>/g, '');
	const props = defineProps<{
		cards: Card[];
	}>();

	const onRoute = (card: Card) => {
		router.push(`/dashboard/details/${card.project_details.id}`);
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
