<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Badge from '@/Components/UI/Badge.vue';
import { useAgenda } from '@/Composables/useAgenda';
import {
    ClockIcon,
    MapPinIcon,
    TagIcon,
    HeartIcon,
} from '@heroicons/vue/24/outline';
import { HeartIcon as HeartSolidIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    session: { type: Object, required: true },
});

const { isInAgenda, toggleAgenda } = useAgenda();
const saved = computed(() => isInAgenda(props.session.id));

function formatDate(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleDateString('es-MX', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
}

function formatTime(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
}
</script>

<template>
    <AppLayout>
        <!-- Banner -->
        <div class="h-48 bg-gradient-to-br from-teal-600 to-cyan-700 relative">
            <img
                v-if="session.speakers?.[0]?.photo_url"
                :src="session.speakers[0].photo_url"
                :alt="session.title"
                class="w-full h-full object-cover opacity-40"
            />
            <div class="absolute inset-0 flex items-end p-4">
                <div>
                    <Badge v-if="session.is_featured" variant="warning" class="mb-2">Featured</Badge>
                    <h1 class="text-xl font-bold text-white leading-tight drop-shadow">{{ session.title }}</h1>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 space-y-5">
            <!-- Meta info -->
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <ClockIcon class="w-4 h-4 text-teal-600 shrink-0" />
                    <span>{{ formatDate(session.start_time) }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <ClockIcon class="w-4 h-4 text-teal-600 shrink-0" />
                    <span>{{ formatTime(session.start_time) }} - {{ formatTime(session.end_time) }}</span>
                </div>
                <div v-if="session.room" class="flex items-center gap-2 text-sm text-gray-600">
                    <MapPinIcon class="w-4 h-4 text-teal-600 shrink-0" />
                    <span>{{ session.room.name }}</span>
                </div>
                <div v-if="session.category" class="flex items-center gap-2 text-sm text-gray-600">
                    <TagIcon class="w-4 h-4 text-teal-600 shrink-0" />
                    <span>{{ session.category.name }}</span>
                </div>
            </div>

            <!-- Description -->
            <div v-if="session.description">
                <h2 class="text-sm font-semibold text-gray-800 mb-2">Descripcion</h2>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ session.description }}</p>
            </div>

            <!-- Speakers -->
            <div v-if="session.speakers?.length">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Speakers</h2>
                <div class="space-y-3">
                    <Link
                        v-for="speaker in session.speakers"
                        :key="speaker.id"
                        :href="`/speakers/${speaker.id}`"
                        class="flex items-center gap-3 bg-gray-50 rounded-xl p-3"
                    >
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 shrink-0">
                            <img
                                v-if="speaker.photo_url"
                                :src="speaker.photo_url"
                                :alt="speaker.name"
                                class="w-full h-full object-cover"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center bg-teal-100 text-teal-700 font-bold">
                                {{ speaker.name.split(' ').map(w => w[0]).join('').slice(0, 2) }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ speaker.name }}</p>
                            <p class="text-xs text-gray-500">{{ speaker.title }}</p>
                            <Badge v-if="speaker.pivot?.role" variant="success" class="mt-0.5">{{ speaker.pivot.role }}</Badge>
                        </div>
                    </Link>
                </div>
            </div>

            <!-- Add to agenda button -->
            <button
                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-semibold text-sm transition-colors"
                :class="saved ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-teal-600 text-white hover:bg-teal-700'"
                @click="toggleAgenda(session.id)"
            >
                <HeartSolidIcon v-if="saved" class="w-5 h-5" />
                <HeartIcon v-else class="w-5 h-5" />
                {{ saved ? 'Eliminar de Mi Agenda' : 'Agregar a Mi Agenda' }}
            </button>
        </div>
    </AppLayout>
</template>
