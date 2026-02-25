<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import SimpleForm from '@/Components/Admin/SimpleForm.vue';

defineProps({
    event: { type: Object, required: true },
});

const fields = [
    { name: 'name', label: 'Nombre', required: true },
    { name: 'description', label: 'Descripcion', type: 'textarea', required: false },
    { name: 'image_url', label: 'URL de Imagen', required: false, placeholder: 'https://...' },
];
</script>

<template>
    <AdminLayout title="Nueva Categoria">
        <div class="max-w-2xl">
            <Card>
                <SimpleForm
                    :event="event"
                    :fields="fields"
                    :submit-url="route('admin.categories.store')"
                    :cancel-route="route('admin.categories.index')"
                    submit-label="Crear Categoria"
                />
            </Card>
        </div>
    </AdminLayout>
</template>
