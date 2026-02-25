<script setup>
defineProps({
    variant: {
        type: String,
        default: 'default',
        validator: (v) => ['default', 'success', 'warning', 'danger', 'info'].includes(v),
    },
});

const variantClasses = {
    default: 'bg-gray-100 text-gray-700',
    success: 'bg-teal-100 text-teal-700',
    warning: 'bg-yellow-100 text-yellow-700',
    danger: 'bg-red-100 text-red-700',
    info: 'bg-purple-100 text-purple-700',
};
</script>

<template>
    <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium', variantClasses[variant]]">
        <slot />
    </span>
</template>
