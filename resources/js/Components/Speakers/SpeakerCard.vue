<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    speaker: { type: Object, required: true },
});
</script>

<template>
    <Link :href="`/speakers/${speaker.id}`" class="flex flex-col items-center text-center shrink-0 w-28">
        <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 mb-2 ring-2 ring-white shadow">
            <img
                v-if="speaker.photo_url"
                :src="speaker.photo_url"
                :alt="speaker.name"
                class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center bg-teal-100 text-teal-700 text-lg font-bold">
                {{ speaker.name.split(' ').map(w => w[0]).join('').slice(0, 2) }}
            </div>
        </div>
        <p class="text-xs font-semibold text-gray-800 leading-tight line-clamp-2">{{ speaker.name }}</p>
        <p class="text-[10px] text-gray-500 leading-tight mt-0.5 line-clamp-1">{{ speaker.title }}</p>
    </Link>
</template>
