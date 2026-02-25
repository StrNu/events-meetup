<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Card from '@/Components/UI/Card.vue';
import Button from '@/Components/UI/Button.vue';

const props = defineProps({
    event: { type: Object, default: null },
});

const form = useForm({
    name: props.event?.name ?? '',
    description: props.event?.description ?? '',
    start_date: props.event?.start_date ?? '',
    end_date: props.event?.end_date ?? '',
    location: props.event?.location ?? '',
    contact_phone: props.event?.contact_phone ?? '',
    contact_email: props.event?.contact_email ?? '',
    twitter_url: props.event?.twitter_url ?? '',
    logo_url: props.event?.logo_url ?? '',
});

function submit() {
    form.put(route('admin.events.update', props.event.id));
}
</script>

<template>
    <AdminLayout title="Configurar Evento">
        <div class="max-w-2xl">
            <Card>
                <form v-if="event" @submit.prevent="submit" class="space-y-6">
                    <!-- Logo preview -->
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                            <img v-if="form.logo_url" :src="form.logo_url" alt="Logo" class="w-full h-full object-cover" />
                            <div v-else class="w-full h-full flex items-center justify-center text-gray-400 text-xl font-bold">EF</div>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL del Logo</label>
                            <input v-model="form.logo_url" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Evento *</label>
                        <input v-model="form.name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripcion *</label>
                        <textarea v-model="form.description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio *</label>
                            <input v-model="form.start_date" type="date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                            <p v-if="form.errors.start_date" class="mt-1 text-sm text-red-600">{{ form.errors.start_date }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin *</label>
                            <input v-model="form.end_date" type="date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                            <p v-if="form.errors.end_date" class="mt-1 text-sm text-red-600">{{ form.errors.end_date }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ubicacion *</label>
                        <input v-model="form.location" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                        <p v-if="form.errors.location" class="mt-1 text-sm text-red-600">{{ form.errors.location }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telefono</label>
                            <input v-model="form.contact_phone" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input v-model="form.contact_email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Twitter</label>
                            <input v-model="form.twitter_url" type="url" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <Button type="submit" :disabled="form.processing">
                            {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                        </Button>
                    </div>
                </form>

                <div v-else class="text-center py-8 text-gray-500">
                    No hay evento creado. Ejecuta los seeders para crear uno.
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
