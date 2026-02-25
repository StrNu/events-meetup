<script setup>
import { computed } from 'vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    currentDate: { type: String, required: true },
    dates: { type: Array, default: () => [] },
});

const emit = defineEmits(['change']);

const currentIndex = computed(() => props.dates.indexOf(props.currentDate));

const formattedDate = computed(() => {
    const d = new Date(props.currentDate + 'T00:00:00');
    return d.toLocaleDateString('es-MX', { weekday: 'long', month: 'long', day: 'numeric' });
});

function prev() {
    if (currentIndex.value > 0) {
        emit('change', props.dates[currentIndex.value - 1]);
    }
}

function next() {
    if (currentIndex.value < props.dates.length - 1) {
        emit('change', props.dates[currentIndex.value + 1]);
    }
}
</script>

<template>
    <div class="flex items-center justify-between bg-white rounded-xl px-4 py-3 shadow-sm border border-gray-100">
        <button
            :disabled="currentIndex <= 0"
            :class="['p-1 rounded-lg transition-colors', currentIndex > 0 ? 'text-gray-600 hover:bg-gray-100' : 'text-gray-300']"
            @click="prev"
        >
            <ChevronLeftIcon class="w-5 h-5" />
        </button>

        <div class="text-center">
            <p class="text-sm font-semibold text-gray-800 capitalize">{{ formattedDate }}</p>
            <p class="text-[10px] text-gray-400">Dia {{ currentIndex + 1 }} de {{ dates.length }}</p>
        </div>

        <button
            :disabled="currentIndex >= dates.length - 1"
            :class="['p-1 rounded-lg transition-colors', currentIndex < dates.length - 1 ? 'text-gray-600 hover:bg-gray-100' : 'text-gray-300']"
            @click="next"
        >
            <ChevronRightIcon class="w-5 h-5" />
        </button>
    </div>
</template>
