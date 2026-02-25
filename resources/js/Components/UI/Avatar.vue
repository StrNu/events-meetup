<script setup>
import { computed } from 'vue';

const props = defineProps({
    src: { type: String, default: null },
    name: { type: String, required: true },
    size: {
        type: String,
        default: 'md',
        validator: (v) => ['sm', 'md', 'lg'].includes(v),
    },
});

const initials = computed(() => {
    return props.name
        .split(' ')
        .map((w) => w[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
});

const sizeClasses = {
    sm: 'w-8 h-8 text-xs',
    md: 'w-10 h-10 text-sm',
    lg: 'w-16 h-16 text-lg',
};
</script>

<template>
    <div :class="['rounded-full overflow-hidden shrink-0', sizeClasses[size]]">
        <img
            v-if="src"
            :src="src"
            :alt="name"
            class="w-full h-full object-cover"
        />
        <div
            v-else
            class="w-full h-full flex items-center justify-center bg-teal-100 text-teal-700 font-semibold"
        >
            {{ initials }}
        </div>
    </div>
</template>
