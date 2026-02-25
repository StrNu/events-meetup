<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import SessionForm from '@/Components/Admin/SessionForm.vue';

const props = defineProps({
    session: { type: Object, required: true },
    event: { type: Object, required: true },
    rooms: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
    speakers: { type: Array, default: () => [] },
});
</script>

<template>
    <AdminLayout :title="`Editar: ${session.title}`">
        <div class="max-w-2xl">
            <Card>
                <SessionForm
                    :session="session"
                    :event="event"
                    :rooms="rooms"
                    :categories="categories"
                    :speakers="speakers"
                    :submit-url="route('admin.sessions.update', session.id)"
                    method="put"
                />
            </Card>
        </div>
    </AdminLayout>
</template>
