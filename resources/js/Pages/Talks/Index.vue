<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import SearchBar from '@/Components/UI/SearchBar.vue';
import { ChevronRightIcon, ClockIcon, MapPinIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    sessionsByRoom: { type: Array, default: () => [] },
});

const search = ref('');

const filteredGroups = computed(() => {
    if (!search.value) return props.sessionsByRoom;
    const q = search.value.toLowerCase();
    return props.sessionsByRoom
        .map((group) => ({
            ...group,
            sessions: group.sessions.filter(
                (s) =>
                    s.title.toLowerCase().includes(q) ||
                    s.speakers?.some((sp) => sp.name.toLowerCase().includes(q))
            ),
        }))
        .filter((group) => group.sessions.length > 0);
});

function formatTime(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
}

function formatDate(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleDateString('es-MX', { weekday: 'short', month: 'short', day: 'numeric' });
}
</script>

<template>
    <AppLayout title="Talks">
        <!-- Search -->
        <div class="sticky top-14 z-20 bg-gray-50 px-4 py-3">
            <SearchBar v-model="search" placeholder="Buscar sesiones o speakers..." />
        </div>

        <!-- Empty -->
        <div v-if="filteredGroups.length === 0" class="px-4 py-12 text-center">
            <p class="text-gray-500 text-sm">{{ search ? 'No se encontraron resultados.' : 'No hay sesiones disponibles.' }}</p>
        </div>

        <!-- Sessions by room -->
        <div v-for="group in filteredGroups" :key="group.room.id ?? 'none'" class="mb-6">
            <div class="flex items-center justify-between px-4 py-2">
                <h2 class="text-sm font-bold text-gray-800">{{ group.room.name }}</h2>
                <span class="text-xs text-gray-400">{{ group.sessions.length }} talks</span>
            </div>

            <div class="space-y-2 px-4">
                <Link
                    v-for="session in group.sessions"
                    :key="session.id"
                    :href="`/talks/${session.id}`"
                    class="block bg-white rounded-xl p-3 shadow-sm border border-gray-100"
                >
                    <div class="flex gap-3">
                        <!-- Speaker photo -->
                        <div v-if="session.speakers?.[0]" class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 shrink-0">
                            <img
                                v-if="session.speakers[0].photo_url"
                                :src="session.speakers[0].photo_url"
                                :alt="session.speakers[0].name"
                                class="w-full h-full object-cover"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center bg-teal-100 text-teal-700 text-sm font-bold">
                                {{ session.speakers[0].name.charAt(0) }}
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-teal-600 mb-0.5">
                                {{ formatDate(session.start_time) }} &middot; {{ formatTime(session.start_time) }} - {{ formatTime(session.end_time) }}
                            </p>
                            <h3 class="text-sm font-semibold text-gray-800 leading-tight line-clamp-2">
                                {{ session.title }}
                            </h3>
                            <p v-if="session.speakers?.length" class="text-xs text-gray-500 mt-0.5">
                                {{ session.speakers.map(s => s.name).join(', ') }}
                            </p>
                            <div v-if="session.category" class="mt-1">
                                <span class="text-[10px] bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded-full">{{ session.category.name }}</span>
                            </div>
                        </div>

                        <ChevronRightIcon class="w-4 h-4 text-gray-300 shrink-0 self-center" />
                    </div>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
