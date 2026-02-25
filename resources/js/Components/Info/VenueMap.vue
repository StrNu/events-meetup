<script setup>
import { MapPinIcon } from '@heroicons/vue/24/outline';

defineProps({
    location: { type: String, default: '' },
});
</script>

<template>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <!-- Placeholder map area -->
        <div class="h-48 bg-gray-100 relative flex items-center justify-center">
            <div class="text-center">
                <MapPinIcon class="w-10 h-10 text-gray-300 mx-auto mb-2" />
                <p class="text-xs text-gray-400">Mapa del venue</p>
                <p class="text-[10px] text-gray-300 mt-0.5">Configura Mapbox o Google Maps API key</p>
            </div>
        </div>

        <div v-if="location" class="px-4 py-3">
            <div class="flex items-start gap-2">
                <MapPinIcon class="w-4 h-4 text-teal-600 shrink-0 mt-0.5" />
                <p class="text-sm text-gray-600">{{ location }}</p>
            </div>
        </div>
    </div>
</template>
