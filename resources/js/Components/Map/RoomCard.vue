<script setup>
import { Link } from '@inertiajs/vue3';
import { MapPinIcon } from '@heroicons/vue/24/outline';

defineProps({
    room: { type: Object, required: true },
});
</script>

<template>
    <Link
        :href="`/map/${room.id}`"
        class="block bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow"
    >
        <div class="h-28 bg-gray-100 relative">
            <img
                v-if="room.photo_url"
                :src="room.photo_url"
                :alt="room.name"
                class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
                <MapPinIcon class="w-10 h-10 text-gray-300" />
            </div>
        </div>

        <div class="p-3">
            <h3 class="text-sm font-semibold text-gray-800 line-clamp-1">{{ room.name }}</h3>
            <div class="flex items-center justify-between mt-1">
                <p v-if="room.capacity" class="text-[10px] text-gray-500">
                    Capacidad: {{ room.capacity }}
                </p>
                <p v-if="room.sessions_count !== undefined" class="text-[10px] text-teal-600 font-medium">
                    {{ room.sessions_count }} sesiones
                </p>
            </div>
        </div>
    </Link>
</template>
