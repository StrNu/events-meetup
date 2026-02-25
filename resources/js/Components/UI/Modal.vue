<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';

defineProps({
    show: { type: Boolean, default: false },
    title: { type: String, default: '' },
    maxWidth: { type: String, default: 'md' },
});

const emit = defineEmits(['close']);

const maxWidthClasses = {
    sm: 'sm:max-w-sm',
    md: 'sm:max-w-md',
    lg: 'sm:max-w-lg',
    xl: 'sm:max-w-xl',
};
</script>

<template>
    <TransitionRoot :show="show" as="template">
        <Dialog class="relative z-50" @close="emit('close')">
            <TransitionChild
                enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500/75" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <TransitionChild
                        enter="ease-out duration-300" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100"
                        leave="ease-in duration-200" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel :class="['w-full bg-white rounded-xl shadow-xl p-6', maxWidthClasses[maxWidth]]">
                            <div class="flex items-center justify-between mb-4">
                                <DialogTitle class="text-lg font-semibold text-gray-800">{{ title }}</DialogTitle>
                                <button class="text-gray-400 hover:text-gray-600" @click="emit('close')">
                                    <XMarkIcon class="w-5 h-5" />
                                </button>
                            </div>
                            <slot />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
