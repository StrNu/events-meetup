<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import Badge from '@/Components/UI/Badge.vue';
import { useAgenda } from '@/Composables/useAgenda';
import {
    HeartIcon,
    ClockIcon,
    MapPinIcon,
    CalendarDaysIcon,
} from '@heroicons/vue/24/outline';
import { HeartIcon as HeartSolidIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    sessions: { type: Array, default: () => [] },
});

const { removeFromAgenda } = useAgenda();

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
    <AppLayout>
        <div class="px-4 py-4 space-y-4">
            <h1 class="text-lg font-bold text-gray-800">Mi Agenda</h1>

            <EmptyState
                v-if="!sessions.length"
                :icon="CalendarDaysIcon"
                title="Tu agenda esta vacia"
                description="Agrega sesiones desde el programa o la lista de talks para armar tu agenda personalizada."
            />

            <div v-else class="space-y-3">
                <div
                    v-for="session in sessions"
                    :key="session.id"
                    class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden"
                >
                    <Link :href="`/talks/${session.id}`" class="block p-3">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">
                                    {{ formatDate(session.start_time) }}
                                </p>
                                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2">{{ session.title }}</h3>

                                <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <ClockIcon class="w-3.5 h-3.5" />
                                        {{ formatTime(session.start_time) }} - {{ formatTime(session.end_time) }}
                                    </span>
                                    <span v-if="session.room" class="flex items-center gap-1">
                                        <MapPinIcon class="w-3.5 h-3.5" />
                                        {{ session.room.name }}
                                    </span>
                                </div>

                                <div v-if="session.speakers?.length" class="flex items-center gap-1.5 mt-2">
                                    <div
                                        v-for="speaker in session.speakers.slice(0, 3)"
                                        :key="speaker.id"
                                        class="w-6 h-6 rounded-full overflow-hidden bg-gray-200 shrink-0"
                                    >
                                        <img
                                            v-if="speaker.photo_url"
                                            :src="speaker.photo_url"
                                            :alt="speaker.name"
                                            class="w-full h-full object-cover"
                                        />
                                        <div v-else class="w-full h-full flex items-center justify-center bg-teal-100 text-teal-700 text-[8px] font-bold">
                                            {{ speaker.name.split(' ').map(w => w[0]).join('').slice(0, 2) }}
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-gray-500">{{ session.speakers.map(s => s.name).join(', ') }}</span>
                                </div>
                            </div>

                            <Badge v-if="session.category" variant="info" class="shrink-0 text-[10px]">
                                {{ session.category.name }}
                            </Badge>
                        </div>
                    </Link>

                    <div class="border-t border-gray-50 px-3 py-2">
                        <button
                            class="flex items-center gap-1.5 text-xs text-red-500 hover:text-red-600 transition-colors"
                            @click="removeFromAgenda(session.id)"
                        >
                            <HeartSolidIcon class="w-4 h-4" />
                            Eliminar de mi agenda
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
