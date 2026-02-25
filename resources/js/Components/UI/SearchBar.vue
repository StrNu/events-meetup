<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    modelValue: { type: String, default: '' },
    placeholder: { type: String, default: 'Buscar...' },
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <div class="relative">
        <MagnifyingGlassIcon class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
        <input
            type="text"
            :value="modelValue"
            :placeholder="placeholder"
            class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
            @input="emit('update:modelValue', $event.target.value)"
        />
    </div>
</template>
