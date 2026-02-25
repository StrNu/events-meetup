<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import SearchBar from '@/Components/UI/SearchBar.vue';
import RoomGrid from '@/Components/Map/RoomGrid.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { MapPinIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    rooms: { type: Array, default: () => [] },
});

const search = ref('');

const filteredRooms = computed(() => {
    if (!search.value) return props.rooms;
    const q = search.value.toLowerCase();
    return props.rooms.filter((r) =>
        r.name.toLowerCase().includes(q)
    );
});
</script>

<template>
    <AppLayout>
        <div class="px-4 py-4 space-y-4">
            <h1 class="text-lg font-bold text-gray-800">Salas</h1>

            <SearchBar
                v-if="rooms.length"
                v-model="search"
                placeholder="Buscar sala..."
            />

            <RoomGrid v-if="filteredRooms.length" :rooms="filteredRooms" />

            <EmptyState
                v-else-if="search"
                :icon="MapPinIcon"
                title="Sin resultados"
                :description="`No se encontraron salas para '${search}'.`"
            />

            <EmptyState
                v-else
                :icon="MapPinIcon"
                title="Sin salas disponibles"
                description="Aun no hay salas registradas para este evento."
            />
        </div>
    </AppLayout>
</template>
