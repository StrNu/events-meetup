<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    category: { type: Object, required: true },
});
</script>

<template>
    <Link :href="`/talks?category=${category.id}`" class="block relative rounded-xl overflow-hidden h-28 group">
        <div class="absolute inset-0 bg-gradient-to-br from-teal-600 to-purple-600">
            <img
                v-if="category.image_url"
                :src="category.image_url"
                :alt="category.name"
                class="w-full h-full object-cover opacity-60 group-hover:opacity-50 transition-opacity"
            />
        </div>
        <div class="absolute inset-0 flex items-end p-3">
            <h3 class="text-sm font-bold text-white drop-shadow">{{ category.name }}</h3>
        </div>
    </Link>
</template>
