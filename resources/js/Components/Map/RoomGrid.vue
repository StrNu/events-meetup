<script setup>
import RoomCard from './RoomCard.vue';

defineProps({
    rooms: { type: Array, default: () => [] },
});
</script>

<template>
    <div class="grid grid-cols-2 gap-3">
        <RoomCard
            v-for="room in rooms"
            :key="room.id"
            :room="room"
        />
    </div>
</template>
