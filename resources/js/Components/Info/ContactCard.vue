<script setup>
import {
    PhoneIcon,
    EnvelopeIcon,
} from '@heroicons/vue/24/outline';

defineProps({
    event: { type: Object, required: true },
});
</script>

<template>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 space-y-3">
        <h2 class="text-sm font-semibold text-gray-800">Contacto</h2>

        <div v-if="event.contact_phone" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-teal-50 flex items-center justify-center shrink-0">
                <PhoneIcon class="w-4 h-4 text-teal-600" />
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-500">Telefono</p>
                <a
                    :href="`tel:${event.contact_phone}`"
                    class="text-sm text-teal-600 font-medium hover:underline"
                >
                    {{ event.contact_phone }}
                </a>
            </div>
        </div>

        <div v-if="event.contact_email" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-teal-50 flex items-center justify-center shrink-0">
                <EnvelopeIcon class="w-4 h-4 text-teal-600" />
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-500">Email</p>
                <a
                    :href="`mailto:${event.contact_email}`"
                    class="text-sm text-teal-600 font-medium hover:underline truncate block"
                >
                    {{ event.contact_email }}
                </a>
            </div>
        </div>

        <div v-if="event.twitter_url" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-teal-50 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-500">X / Twitter</p>
                <a
                    :href="event.twitter_url"
                    target="_blank"
                    class="text-sm text-teal-600 font-medium hover:underline truncate block"
                >
                    {{ event.twitter_url }}
                </a>
            </div>
        </div>

        <p
            v-if="!event.contact_phone && !event.contact_email && !event.twitter_url"
            class="text-xs text-gray-400 text-center py-2"
        >
            No hay informacion de contacto disponible.
        </p>
    </div>
</template>
