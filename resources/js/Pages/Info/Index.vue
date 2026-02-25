<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import ContactCard from '@/Components/Info/ContactCard.vue';
import VenueMap from '@/Components/Info/VenueMap.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { InformationCircleIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    event: { type: Object, default: null },
});
</script>

<template>
    <AppLayout>
        <div class="px-4 py-4 space-y-4">
            <h1 class="text-lg font-bold text-gray-800">Informacion</h1>

            <template v-if="event">
                <!-- Event name and description -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <img
                            v-if="event.logo_url"
                            :src="event.logo_url"
                            :alt="event.name"
                            class="w-12 h-12 rounded-lg object-cover"
                        />
                        <div>
                            <h2 class="text-sm font-bold text-gray-800">{{ event.name }}</h2>
                            <p class="text-xs text-gray-500">{{ event.location }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ event.description }}</p>
                </div>

                <!-- Venue map -->
                <VenueMap :location="event.location" />

                <!-- Contact card -->
                <ContactCard :event="event" />
            </template>

            <EmptyState
                v-else
                :icon="InformationCircleIcon"
                title="Sin informacion"
                description="No hay un evento activo registrado."
            />
        </div>
    </AppLayout>
</template>
