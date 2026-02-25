<script setup>
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from '@/Components/UI/Button.vue';

const props = defineProps({
    speaker: { type: Object, default: null },
    event: { type: Object, required: true },
    submitUrl: { type: String, required: true },
    method: { type: String, default: 'post' },
});

const form = useForm({
    event_id: props.event?.id ?? '',
    name: props.speaker?.name ?? '',
    title: props.speaker?.title ?? '',
    organization: props.speaker?.organization ?? '',
    bio: props.speaker?.bio ?? '',
    photo_url: props.speaker?.photo_url ?? '',
    type: props.speaker?.type ?? 'speaker',
    social_links: {
        twitter: props.speaker?.social_links?.twitter ?? '',
        linkedin: props.speaker?.social_links?.linkedin ?? '',
        website: props.speaker?.social_links?.website ?? '',
    },
});

const isEditing = computed(() => !!props.speaker);

function submit() {
    if (props.method === 'put') {
        form.put(props.submitUrl);
    } else {
        form.post(props.submitUrl);
    }
}

const speakerTypes = [
    { value: 'keynote', label: 'Keynote' },
    { value: 'speaker', label: 'Speaker' },
    { value: 'panelist', label: 'Panelist' },
    { value: 'host', label: 'Host' },
];
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <!-- Photo preview -->
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 shrink-0">
                <img
                    v-if="form.photo_url"
                    :src="form.photo_url"
                    alt="Preview"
                    class="w-full h-full object-cover"
                />
                <div v-else class="w-full h-full flex items-center justify-center text-gray-400 text-2xl font-semibold">
                    {{ form.name ? form.name.charAt(0).toUpperCase() : '?' }}
                </div>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">URL de foto</label>
                <input
                    v-model="form.photo_url"
                    type="text"
                    placeholder="https://example.com/photo.jpg"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                />
                <p v-if="form.errors.photo_url" class="mt-1 text-sm text-red-600">{{ form.errors.photo_url }}</p>
            </div>
        </div>

        <!-- Name & Title -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input
                    v-model="form.name"
                    type="text"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cargo / Titulo *</label>
                <input
                    v-model="form.title"
                    type="text"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                />
                <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
            </div>
        </div>

        <!-- Organization & Type -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Organizacion</label>
                <input
                    v-model="form.organization"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                />
                <p v-if="form.errors.organization" class="mt-1 text-sm text-red-600">{{ form.errors.organization }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                <select
                    v-model="form.type"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                >
                    <option v-for="t in speakerTypes" :key="t.value" :value="t.value">
                        {{ t.label }}
                    </option>
                </select>
                <p v-if="form.errors.type" class="mt-1 text-sm text-red-600">{{ form.errors.type }}</p>
            </div>
        </div>

        <!-- Bio -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Biografia</label>
            <textarea
                v-model="form.bio"
                rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
            />
            <p v-if="form.errors.bio" class="mt-1 text-sm text-red-600">{{ form.errors.bio }}</p>
        </div>

        <!-- Social Links -->
        <div>
            <h3 class="text-sm font-medium text-gray-700 mb-3">Redes Sociales</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Twitter</label>
                    <input
                        v-model="form.social_links.twitter"
                        type="url"
                        placeholder="https://twitter.com/..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                    />
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">LinkedIn</label>
                    <input
                        v-model="form.social_links.linkedin"
                        type="url"
                        placeholder="https://linkedin.com/in/..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                    />
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Website</label>
                    <input
                        v-model="form.social_links.website"
                        type="url"
                        placeholder="https://..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                    />
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <Button variant="secondary" @click="$inertia.visit(route('admin.speakers.index'))">
                Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing">
                {{ form.processing ? 'Guardando...' : (isEditing ? 'Actualizar Speaker' : 'Crear Speaker') }}
            </Button>
        </div>
    </form>
</template>
