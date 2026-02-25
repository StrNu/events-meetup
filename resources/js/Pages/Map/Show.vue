<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Badge from '@/Components/UI/Badge.vue';
import {
    MapPinIcon,
    UsersIcon,
    ClockIcon,
    ArrowLeftIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    room: { type: Object, required: true },
    sessions: { type: Array, default: () => [] },
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
    <AppLayout>
        <!-- Room photo -->
        <div class="h-52 bg-gray-100 relative">
            <img
                v-if="room.photo_url"
                :src="room.photo_url"
                :alt="room.name"
                class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
                <MapPinIcon class="w-16 h-16 text-gray-300" />
            </div>

            <Link
                href="/map"
                class="absolute top-3 left-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur flex items-center justify-center"
            >
                <ArrowLeftIcon class="w-4 h-4 text-gray-700" />
            </Link>
        </div>

        <div class="px-4 py-4 space-y-5">
            <!-- Room info -->
            <div>
                <h1 class="text-xl font-bold text-gray-800">{{ room.name }}</h1>
                <div v-if="room.capacity" class="flex items-center gap-1.5 mt-1 text-sm text-gray-500">
                    <UsersIcon class="w-4 h-4" />
                    <span>Capacidad: {{ room.capacity }} personas</span>
                </div>
            </div>

            <!-- Description -->
            <div v-if="room.description">
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ room.description }}</p>
            </div>

            <!-- Sessions in this room -->
            <div>
                <h2 class="text-sm font-semibold text-gray-800 mb-3">
                    Sesiones en esta sala ({{ sessions.length }})
                </h2>

                <div v-if="sessions.length" class="space-y-2.5">
                    <Link
                        v-for="session in sessions"
                        :key="session.id"
                        :href="`/talks/${session.id}`"
                        class="block bg-gray-50 rounded-xl p-3"
                    >
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">{{ formatDate(session.start_time) }}</p>
                                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 mt-0.5">{{ session.title }}</h3>
                                <div class="flex items-center gap-1 mt-1 text-xs text-gray-500">
                                    <ClockIcon class="w-3.5 h-3.5" />
                                    <span>{{ formatTime(session.start_time) }} - {{ formatTime(session.end_time) }}</span>
                                </div>
                                <div v-if="session.speakers?.length" class="mt-1.5 text-[10px] text-gray-500">
                                    {{ session.speakers.map(s => s.name).join(', ') }}
                                </div>
                            </div>
                            <Badge v-if="session.category" variant="info" class="shrink-0 text-[10px]">
                                {{ session.category.name }}
                            </Badge>
                        </div>
                    </Link>
                </div>

                <p v-else class="text-xs text-gray-400 text-center py-4">
                    No hay sesiones programadas en esta sala.
                </p>
            </div>
        </div>
    </AppLayout>
</template>
