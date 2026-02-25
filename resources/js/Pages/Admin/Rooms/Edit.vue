<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import SimpleForm from '@/Components/Admin/SimpleForm.vue';

const props = defineProps({
    room: { type: Object, required: true },
    event: { type: Object, required: true },
});

const fields = [
    { name: 'name', label: 'Nombre', required: true },
    { name: 'capacity', label: 'Capacidad', type: 'number', required: false },
    { name: 'description', label: 'Descripcion', type: 'textarea', required: false },
    { name: 'photo_url', label: 'URL de Foto', required: false, placeholder: 'https://...' },
];
</script>

<template>
    <AdminLayout :title="`Editar: ${room.name}`">
        <div class="max-w-2xl">
            <Card>
                <SimpleForm
                    :item="room"
                    :event="event"
                    :fields="fields"
                    :submit-url="route('admin.rooms.update', room.id)"
                    method="put"
                    :cancel-route="route('admin.rooms.index')"
                />
            </Card>
        </div>
    </AdminLayout>
</template>
