<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import Badge from '@/Components/UI/Badge.vue';
import {
    MicrophoneIcon,
    CalendarDaysIcon,
    BuildingOfficeIcon,
    TagIcon,
} from '@heroicons/vue/24/outline';

defineProps({
    event: { type: Object, default: null },
    stats: { type: Object, default: () => ({}) },
    upcomingSessions: { type: Array, default: () => [] },
});

const statCards = [
    { key: 'speakers', label: 'Speakers', icon: MicrophoneIcon, color: 'text-purple-600 bg-purple-100' },
    { key: 'sessions', label: 'Sesiones', icon: CalendarDaysIcon, color: 'text-teal-600 bg-teal-100' },
    { key: 'rooms', label: 'Salas', icon: BuildingOfficeIcon, color: 'text-cyan-600 bg-cyan-100' },
    { key: 'categories', label: 'Categorias', icon: TagIcon, color: 'text-yellow-600 bg-yellow-100' },
];

function formatTime(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleString('es-MX', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
}
</script>

<template>
    <AdminLayout title="Dashboard">
        <!-- Event info -->
        <div v-if="event" class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ event.name }}</h2>
            <p class="text-sm text-gray-500">{{ event.location }}</p>
        </div>
        <div v-else class="mb-6 rounded-lg bg-yellow-50 border border-yellow-200 px-4 py-3 text-sm text-yellow-700">
            No hay evento activo. Ejecuta los seeders: <code class="bg-yellow-100 px-1 rounded">php artisan db:seed</code>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <Card v-for="s in statCards" :key="s.key">
                <div class="flex items-center gap-3">
                    <div :class="['p-2.5 rounded-lg', s.color]">
                        <component :is="s.icon" class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ stats[s.key] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">{{ s.label }}</p>
                    </div>
                </div>
            </Card>
        </div>

        <!-- Upcoming sessions -->
        <Card>
            <h3 class="text-base font-semibold text-gray-800 mb-4">Proximas Sesiones</h3>
            <div v-if="upcomingSessions.length === 0" class="text-sm text-gray-500 py-4 text-center">
                No hay sesiones programadas.
            </div>
            <div v-else class="divide-y divide-gray-100">
                <div v-for="session in upcomingSessions" :key="session.id" class="flex items-center justify-between py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ session.title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ session.room?.name ?? 'Sin sala' }} &middot; {{ formatTime(session.start_time) }}
                        </p>
                    </div>
                    <div class="flex gap-1">
                        <Badge v-for="sp in session.speakers" :key="sp.id" variant="success">{{ sp.name }}</Badge>
                    </div>
                </div>
            </div>
        </Card>
    </AdminLayout>
</template>
