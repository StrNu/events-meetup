<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import SimpleForm from '@/Components/Admin/SimpleForm.vue';

defineProps({
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
    <AdminLayout title="Nueva Sala">
        <div class="max-w-2xl">
            <Card>
                <SimpleForm
                    :event="event"
                    :fields="fields"
                    :submit-url="route('admin.rooms.store')"
                    :cancel-route="route('admin.rooms.index')"
                    submit-label="Crear Sala"
                />
            </Card>
        </div>
    </AdminLayout>
</template>
