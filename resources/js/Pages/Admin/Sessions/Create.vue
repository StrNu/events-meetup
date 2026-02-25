<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import SessionForm from '@/Components/Admin/SessionForm.vue';

defineProps({
    event: { type: Object, required: true },
    rooms: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
    speakers: { type: Array, default: () => [] },
});
</script>

<template>
    <AdminLayout title="Nueva Sesion">
        <div class="max-w-2xl">
            <Card>
                <SessionForm
                    :event="event"
                    :rooms="rooms"
                    :categories="categories"
                    :speakers="speakers"
                    :submit-url="route('admin.sessions.store')"
                    method="post"
                />
            </Card>
        </div>
    </AdminLayout>
</template>
