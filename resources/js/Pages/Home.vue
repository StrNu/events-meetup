<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import SpeakerCarousel from '@/Components/Speakers/SpeakerCarousel.vue';
import SessionCard from '@/Components/Sessions/SessionCard.vue';
import CategoryGrid from '@/Components/Categories/CategoryGrid.vue';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';

defineProps({
    event: { type: Object, default: null },
    speakers: { type: Array, default: () => [] },
    upcomingSessions: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
    rooms: { type: Array, default: () => [] },
});
</script>

<template>
    <AppLayout>
        <!-- Hero -->
        <section class="bg-gradient-to-br from-teal-600 via-teal-700 to-cyan-700 text-white px-4 py-8 text-center">
            <div v-if="event?.logo_url" class="w-16 h-16 mx-auto mb-3 rounded-xl overflow-hidden bg-white/20">
                <img :src="event.logo_url" :alt="event.name" class="w-full h-full object-cover" />
            </div>
            <h1 class="text-2xl font-bold mb-1">{{ event?.name ?? 'EventFlow' }}</h1>
            <p class="text-teal-100 text-sm">{{ event?.location }}</p>
            <p v-if="event?.start_date" class="text-teal-200 text-xs mt-1">
                {{ new Date(event.start_date).toLocaleDateString('es-MX', { month: 'long', day: 'numeric' }) }}
                &mdash;
                {{ new Date(event.end_date).toLocaleDateString('es-MX', { month: 'long', day: 'numeric', year: 'numeric' }) }}
            </p>
        </section>

        <!-- Speakers -->
        <section v-if="speakers.length" class="px-4 py-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-bold text-gray-800">Speakers</h2>
                <Link href="/speakers" class="flex items-center text-xs text-teal-600 font-medium">
                    Ver todos <ChevronRightIcon class="w-3.5 h-3.5 ml-0.5" />
                </Link>
            </div>
            <SpeakerCarousel :speakers="speakers" />
        </section>

        <!-- Upcoming Talks -->
        <section v-if="upcomingSessions.length" class="py-5">
            <div class="flex items-center justify-between mb-3 px-4">
                <h2 class="text-base font-bold text-gray-800">Talks</h2>
                <Link href="/talks" class="flex items-center text-xs text-teal-600 font-medium">
                    Ver todos <ChevronRightIcon class="w-3.5 h-3.5 ml-0.5" />
                </Link>
            </div>
            <div class="flex gap-3 overflow-x-auto snap-x snap-mandatory scrollbar-hide px-4">
                <SessionCard
                    v-for="session in upcomingSessions"
                    :key="session.id"
                    :session="session"
                />
            </div>
        </section>

        <!-- Categories -->
        <section v-if="categories.length" class="px-4 py-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-bold text-gray-800">Categorias</h2>
            </div>
            <CategoryGrid :categories="categories" />
        </section>

        <!-- Rooms / Map preview -->
        <section v-if="rooms.length" class="px-4 py-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-bold text-gray-800">Salas</h2>
                <Link href="/map" class="flex items-center text-xs text-teal-600 font-medium">
                    Ver mapa <ChevronRightIcon class="w-3.5 h-3.5 ml-0.5" />
                </Link>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <Link
                    v-for="room in rooms"
                    :key="room.id"
                    :href="`/map/${room.id}`"
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
                >
                    <div class="h-20 bg-gradient-to-br from-gray-100 to-gray-200">
                        <img
                            v-if="room.photo_url"
                            :src="room.photo_url"
                            :alt="room.name"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div class="p-2.5">
                        <p class="text-xs font-semibold text-gray-800">{{ room.name }}</p>
                        <p v-if="room.capacity" class="text-[10px] text-gray-400">Cap. {{ room.capacity }}</p>
                    </div>
                </Link>
            </div>
        </section>

        <!-- Empty state -->
        <div v-if="!event" class="px-4 py-12 text-center">
            <p class="text-gray-500 text-sm">No hay evento activo.</p>
            <p class="text-gray-400 text-xs mt-1">Ejecuta <code class="bg-gray-100 px-1 rounded">php artisan db:seed</code> para crear datos de prueba.</p>
        </div>
    </AppLayout>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
