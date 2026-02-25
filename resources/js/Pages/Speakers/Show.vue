<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Badge from '@/Components/UI/Badge.vue';
import SocialLinks from '@/Components/UI/SocialLinks.vue';
import { ClockIcon, MapPinIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    speaker: { type: Object, required: true },
});

function formatTime(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleString('es-MX', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
}
</script>

<template>
    <AppLayout>
        <!-- Photo -->
        <div class="h-64 bg-gradient-to-br from-teal-600 to-cyan-700 relative">
            <img
                v-if="speaker.photo_url"
                :src="speaker.photo_url"
                :alt="speaker.name"
                class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center text-6xl font-bold text-white/30">
                {{ speaker.name.split(' ').map(w => w[0]).join('').slice(0, 2) }}
            </div>
        </div>

        <div class="px-4 py-4 space-y-5">
            <!-- Header -->
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h1 class="text-xl font-bold text-gray-800">{{ speaker.name }}</h1>
                    <Badge variant="success">{{ speaker.type }}</Badge>
                </div>
                <p class="text-sm text-gray-600">{{ speaker.title }}</p>
                <p v-if="speaker.organization" class="text-sm text-gray-400">{{ speaker.organization }}</p>
            </div>

            <!-- Social links -->
            <SocialLinks :links="speaker.social_links" />

            <!-- Bio -->
            <div v-if="speaker.bio">
                <h2 class="text-sm font-semibold text-gray-800 mb-2">Biografia</h2>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ speaker.bio }}</p>
            </div>

            <!-- Sessions -->
            <div v-if="speaker.sessions?.length">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Sesiones</h2>
                <div class="space-y-2">
                    <Link
                        v-for="session in speaker.sessions"
                        :key="session.id"
                        :href="`/talks/${session.id}`"
                        class="block bg-gray-50 rounded-xl p-3"
                    >
                        <p class="text-xs font-semibold text-teal-600 mb-0.5">
                            {{ formatTime(session.start_time) }}
                        </p>
                        <h3 class="text-sm font-semibold text-gray-800 leading-tight">{{ session.title }}</h3>
                        <p v-if="session.room" class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                            <MapPinIcon class="w-3 h-3" /> {{ session.room.name }}
                        </p>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
