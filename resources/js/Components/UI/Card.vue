<script setup>
defineProps({
    padding: { type: Boolean, default: true },
});
</script>

<template>
    <div :class="['bg-white rounded-xl shadow-sm border border-gray-200', padding ? 'p-6' : '']">
        <slot />
    </div>
</template>
