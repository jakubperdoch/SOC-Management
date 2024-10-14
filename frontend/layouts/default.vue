<template>
	<navbar :data="navigationData" />
	<slot />
</template>

<script setup lang="ts">
	import navbar from '~/components/navbar.vue';
	import navigationData from '@/utils/data/navbar.json';
</script>
