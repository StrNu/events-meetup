<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import SpeakerForm from '@/Components/Admin/SpeakerForm.vue';

defineProps({
    event: { type: Object, required: true },
});
</script>

<template>
    <AdminLayout title="Nuevo Speaker">
        <div class="max-w-2xl">
            <Card>
                <SpeakerForm
                    :event="event"
                    :submit-url="route('admin.speakers.store')"
                    method="post"
                />
            </Card>
        </div>
    </AdminLayout>
</template>
