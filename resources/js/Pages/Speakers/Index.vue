<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import SearchBar from '@/Components/UI/SearchBar.vue';

const props = defineProps({
    speakers: { type: Array, default: () => [] },
});

const search = ref('');
const activeType = ref('all');

const types = [
    { value: 'all', label: 'Todos' },
    { value: 'keynote', label: 'Keynote' },
    { value: 'speaker', label: 'Speaker' },
    { value: 'panelist', label: 'Panelist' },
    { value: 'host', label: 'Host' },
];

const filteredSpeakers = computed(() => {
    let result = props.speakers;
    if (activeType.value !== 'all') {
        result = result.filter((s) => s.type === activeType.value);
    }
    if (search.value) {
        const q = search.value.toLowerCase();
        result = result.filter(
            (s) =>
                s.name.toLowerCase().includes(q) ||
                s.title.toLowerCase().includes(q) ||
                (s.organization && s.organization.toLowerCase().includes(q))
        );
    }
    return result;
});
</script>

<template>
    <AppLayout title="Speakers">
        <!-- Search -->
        <div class="sticky top-14 z-20 bg-gray-50 px-4 pt-3 pb-2">
            <SearchBar v-model="search" placeholder="Buscar speakers..." />
            <!-- Type filter -->
            <div class="flex gap-2 mt-3 overflow-x-auto scrollbar-hide">
                <button
                    v-for="t in types"
                    :key="t.value"
                    :class="[
                        'px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition-colors',
                        activeType === t.value
                            ? 'bg-teal-600 text-white'
                            : 'bg-white text-gray-600 border border-gray-200',
                    ]"
                    @click="activeType = t.value"
                >
                    {{ t.label }}
                </button>
            </div>
        </div>

        <!-- Empty -->
        <div v-if="filteredSpeakers.length === 0" class="px-4 py-12 text-center">
            <p class="text-gray-500 text-sm">No se encontraron speakers.</p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-2 gap-3 px-4 py-4">
            <Link
                v-for="speaker in filteredSpeakers"
                :key="speaker.id"
                :href="`/speakers/${speaker.id}`"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden text-center pb-3"
            >
                <div class="h-32 bg-gradient-to-br from-teal-50 to-cyan-50">
                    <img
                        v-if="speaker.photo_url"
                        :src="speaker.photo_url"
                        :alt="speaker.name"
                        class="w-full h-full object-cover"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center text-3xl font-bold text-teal-300">
                        {{ speaker.name.split(' ').map(w => w[0]).join('').slice(0, 2) }}
                    </div>
                </div>
                <div class="px-2 pt-2">
                    <p class="text-sm font-semibold text-gray-800 leading-tight line-clamp-1">{{ speaker.name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ speaker.title }}</p>
                    <span class="inline-block mt-1 text-[10px] bg-teal-50 text-teal-700 px-2 py-0.5 rounded-full">{{ speaker.type }}</span>
                </div>
            </Link>
        </div>
    </AppLayout>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
