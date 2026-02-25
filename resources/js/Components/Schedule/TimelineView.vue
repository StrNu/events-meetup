<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    sessions: { type: Array, default: () => [] },
});

const roomColors = [
    'bg-teal-500', 'bg-purple-500', 'bg-cyan-500',
    'bg-yellow-500', 'bg-pink-500', 'bg-indigo-500',
];

const rooms = computed(() => {
    const map = {};
    props.sessions.forEach((s) => {
        const name = s.room?.name ?? 'Sin sala';
        if (!map[name]) map[name] = [];
        map[name].push(s);
    });
    return Object.entries(map).map(([name, sessions], idx) => ({
        name,
        sessions,
        color: roomColors[idx % roomColors.length],
    }));
});

// Build hours from earliest to latest session
const hours = computed(() => {
    if (!props.sessions.length) return [];
    let minHour = 24, maxHour = 0;
    props.sessions.forEach((s) => {
        const start = new Date(s.start_time).getHours();
        const end = new Date(s.end_time).getHours() + 1;
        if (start < minHour) minHour = start;
        if (end > maxHour) maxHour = end;
    });
    return Array.from({ length: maxHour - minHour }, (_, i) => minHour + i);
});

function formatHour(h) {
    return `${h.toString().padStart(2, '0')}:00`;
}

function getSessionStyle(session) {
    if (!hours.value.length) return {};
    const startH = new Date(session.start_time).getHours();
    const startM = new Date(session.start_time).getMinutes();
    const endH = new Date(session.end_time).getHours();
    const endM = new Date(session.end_time).getMinutes();

    const baseHour = hours.value[0];
    const top = ((startH - baseHour) * 60 + startM) * (64 / 60); // 64px per hour
    const height = ((endH - startH) * 60 + (endM - startM)) * (64 / 60);

    return {
        top: `${top}px`,
        height: `${Math.max(height, 32)}px`,
    };
}

function formatTime(datetime) {
    const d = new Date(datetime);
    return d.toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
}
</script>

<template>
    <div v-if="sessions.length === 0" class="text-center py-12 text-sm text-gray-500">
        No hay sesiones programadas para este dia.
    </div>

    <div v-else class="overflow-x-auto">
        <!-- Room legend -->
        <div class="flex gap-3 mb-4 px-1">
            <div v-for="room in rooms" :key="room.name" class="flex items-center gap-1.5">
                <div :class="['w-2.5 h-2.5 rounded-full', room.color]" />
                <span class="text-xs text-gray-600">{{ room.name }}</span>
            </div>
        </div>

        <!-- Timeline -->
        <div class="relative" :style="{ height: hours.length * 64 + 'px' }">
            <!-- Hour lines -->
            <div
                v-for="(hour, idx) in hours"
                :key="hour"
                class="absolute left-0 right-0 border-t border-gray-100"
                :style="{ top: idx * 64 + 'px' }"
            >
                <span class="text-[10px] text-gray-400 -translate-y-1/2 block pl-1">{{ formatHour(hour) }}</span>
            </div>

            <!-- Session blocks -->
            <Link
                v-for="session in sessions"
                :key="session.id"
                :href="`/talks/${session.id}`"
                class="absolute left-12 right-2 rounded-lg px-2.5 py-1.5 text-white overflow-hidden shadow-sm"
                :class="rooms.find(r => r.sessions.includes(session))?.color ?? 'bg-teal-500'"
                :style="getSessionStyle(session)"
            >
                <p class="text-[10px] opacity-80">{{ formatTime(session.start_time) }} - {{ formatTime(session.end_time) }}</p>
                <p class="text-xs font-semibold leading-tight line-clamp-2">{{ session.title }}</p>
                <p v-if="session.speakers?.length" class="text-[10px] opacity-80 line-clamp-1">{{ session.speakers[0].name }}</p>
            </Link>
        </div>
    </div>
</template>
