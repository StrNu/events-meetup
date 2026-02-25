<script setup>
import SpeakerCard from './SpeakerCard.vue';

defineProps({
    speakers: { type: Array, default: () => [] },
});
</script>

<template>
    <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-hide px-4 py-2 -mx-4">
        <SpeakerCard
            v-for="speaker in speakers"
            :key="speaker.id"
            :speaker="speaker"
            class="snap-start"
        />
    </div>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
