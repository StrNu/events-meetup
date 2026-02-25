<script setup>
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import SimpleForm from '@/Components/Admin/SimpleForm.vue';

const props = defineProps({
    category: { type: Object, required: true },
    event: { type: Object, required: true },
});

const fields = [
    { name: 'name', label: 'Nombre', required: true },
    { name: 'description', label: 'Descripcion', type: 'textarea', required: false },
    { name: 'image_url', label: 'URL de Imagen', required: false, placeholder: 'https://...' },
];
</script>

<template>
    <AdminLayout :title="`Editar: ${category.name}`">
        <div class="max-w-2xl">
            <Card>
                <SimpleForm
                    :item="category"
                    :event="event"
                    :fields="fields"
                    :submit-url="route('admin.categories.update', category.id)"
                    method="put"
                    :cancel-route="route('admin.categories.index')"
                />
            </Card>
        </div>
    </AdminLayout>
</template>
