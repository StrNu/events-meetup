<script setup>
import CategoryCard from './CategoryCard.vue';

defineProps({
    categories: { type: Array, default: () => [] },
});
</script>

<template>
    <div class="grid grid-cols-2 gap-3">
        <CategoryCard
            v-for="category in categories"
            :key="category.id"
            :category="category"
        />
    </div>
</template>
