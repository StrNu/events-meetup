<script setup>
defineProps({
    title: { type: String, required: true },
    description: { type: String, default: '' },
    icon: { type: Object, default: null },
});
</script>

<template>
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <component
            v-if="icon"
            :is="icon"
            class="w-12 h-12 text-gray-300 mb-4"
        />
        <h3 class="text-sm font-medium text-gray-800">{{ title }}</h3>
        <p v-if="description" class="mt-1 text-sm text-gray-500">{{ description }}</p>
        <div v-if="$slots.action" class="mt-4">
            <slot name="action" />
        </div>
    </div>
</template>
