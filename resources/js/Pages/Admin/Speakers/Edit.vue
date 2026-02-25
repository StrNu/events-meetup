<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import SpeakerForm from '@/Components/Admin/SpeakerForm.vue';

const props = defineProps({
    speaker: { type: Object, required: true },
    event: { type: Object, required: true },
});
</script>

<template>
    <AdminLayout :title="`Editar: ${speaker.name}`">
        <div class="max-w-2xl">
            <Card>
                <SpeakerForm
                    :speaker="speaker"
                    :event="event"
                    :submit-url="route('admin.speakers.update', speaker.id)"
                    method="put"
                />
            </Card>
        </div>
    </AdminLayout>
</template>
