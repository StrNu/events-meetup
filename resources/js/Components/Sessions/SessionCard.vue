<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    session: { type: Object, required: true },
});

function formatDate(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleDateString('es-MX', { month: 'short', day: 'numeric' });
}

function formatTime(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
}
</script>

<template>
    <Link :href="`/talks/${session.id}`" class="block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden shrink-0 w-64 snap-start">
        <!-- Speaker photo banner -->
        <div class="h-32 bg-gradient-to-br from-teal-500 to-cyan-600 relative">
            <img
                v-if="session.speakers?.[0]?.photo_url"
                :src="session.speakers[0].photo_url"
                :alt="session.speakers[0].name"
                class="w-full h-full object-cover"
            />
            <div v-if="session.is_featured" class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 text-[10px] font-bold px-2 py-0.5 rounded-full">
                Featured
            </div>
        </div>
        <div class="p-3">
            <p class="text-xs font-semibold text-teal-600 mb-1">
                {{ formatDate(session.start_time) }} &middot; {{ formatTime(session.start_time) }}
            </p>
            <h3 class="text-sm font-semibold text-gray-800 leading-tight line-clamp-2 mb-1">
                {{ session.title }}
            </h3>
            <p v-if="session.speakers?.length" class="text-xs text-gray-500">
                {{ session.speakers.map(s => s.name).join(', ') }}
            </p>
            <p v-if="session.room" class="text-[10px] text-gray-400 mt-1">
                {{ session.room.name }}
            </p>
        </div>
    </Link>
</template>
