<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import DaySelector from '@/Components/Schedule/DaySelector.vue';
import TimelineView from '@/Components/Schedule/TimelineView.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { CalendarDaysIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    sessions: { type: Array, default: () => [] },
    currentDate: { type: String, required: true },
    eventDates: { type: Array, default: () => [] },
});

function changeDate(date) {
    router.get('/schedule', { date }, {
        preserveState: true,
        preserveScroll: true,
    });
}
</script>

<template>
    <AppLayout>
        <div class="px-4 py-4 space-y-4">
            <h1 class="text-lg font-bold text-gray-800">Programa</h1>

            <DaySelector
                v-if="eventDates.length"
                :current-date="currentDate"
                :dates="eventDates"
                @change="changeDate"
            />

            <TimelineView :sessions="sessions" />

            <EmptyState
                v-if="!eventDates.length"
                :icon="CalendarDaysIcon"
                title="Sin programa disponible"
                description="Aun no hay un evento activo con programa publicado."
            />
        </div>
    </AppLayout>
</template>
