<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Button from '@/Components/UI/Button.vue';
import Badge from '@/Components/UI/Badge.vue';
import { XMarkIcon, PlusIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    session: { type: Object, default: null },
    event: { type: Object, required: true },
    rooms: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
    speakers: { type: Array, default: () => [] },
    submitUrl: { type: String, required: true },
    method: { type: String, default: 'post' },
});

const existingSpeakers = (props.session?.speakers ?? []).map((s) => ({
    id: s.id,
    role: s.pivot?.role ?? 'main',
}));

const form = useForm({
    event_id: props.event?.id ?? '',
    room_id: props.session?.room_id ?? '',
    category_id: props.session?.category_id ?? '',
    title: props.session?.title ?? '',
    description: props.session?.description ?? '',
    start_time: props.session?.start_time ? props.session.start_time.slice(0, 16) : '',
    end_time: props.session?.end_time ? props.session.end_time.slice(0, 16) : '',
    is_featured: props.session?.is_featured ?? false,
    speakers: existingSpeakers,
});

const isEditing = computed(() => !!props.session);

const selectedSpeakerId = ref('');
const selectedSpeakerRole = ref('main');

const availableSpeakers = computed(() => {
    const assignedIds = form.speakers.map((s) => s.id);
    return props.speakers.filter((s) => !assignedIds.includes(s.id));
});

function addSpeaker() {
    if (!selectedSpeakerId.value) return;
    form.speakers.push({
        id: Number(selectedSpeakerId.value),
        role: selectedSpeakerRole.value,
    });
    selectedSpeakerId.value = '';
    selectedSpeakerRole.value = 'main';
}

function removeSpeaker(index) {
    form.speakers.splice(index, 1);
}

function getSpeakerName(id) {
    return props.speakers.find((s) => s.id === id)?.name ?? 'Desconocido';
}

const roles = [
    { value: 'main', label: 'Principal' },
    { value: 'co-speaker', label: 'Co-Speaker' },
    { value: 'moderator', label: 'Moderador' },
];

function submit() {
    if (props.method === 'put') {
        form.put(props.submitUrl);
    } else {
        form.post(props.submitUrl);
    }
}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <!-- Title -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Titulo *</label>
            <input
                v-model="form.title"
                type="text"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
            />
            <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
        </div>

        <!-- Room & Category -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sala</label>
                <select
                    v-model="form.room_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                >
                    <option value="">Sin sala asignada</option>
                    <option v-for="room in rooms" :key="room.id" :value="room.id">
                        {{ room.name }}
                    </option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                <select
                    v-model="form.category_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                >
                    <option value="">Sin categoria</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                        {{ cat.name }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Start & End time -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Inicio *</label>
                <input
                    v-model="form.start_time"
                    type="datetime-local"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                />
                <p v-if="form.errors.start_time" class="mt-1 text-sm text-red-600">{{ form.errors.start_time }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fin *</label>
                <input
                    v-model="form.end_time"
                    type="datetime-local"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                />
                <p v-if="form.errors.end_time" class="mt-1 text-sm text-red-600">{{ form.errors.end_time }}</p>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Descripcion</label>
            <textarea
                v-model="form.description"
                rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
            />
            <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
        </div>

        <!-- Featured -->
        <div class="flex items-center gap-2">
            <input
                v-model="form.is_featured"
                type="checkbox"
                id="is_featured"
                class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
            />
            <label for="is_featured" class="text-sm text-gray-700">Sesion destacada</label>
        </div>

        <!-- Speakers -->
        <div>
            <h3 class="text-sm font-medium text-gray-700 mb-3">Speakers</h3>

            <!-- Assigned speakers list -->
            <div v-if="form.speakers.length" class="space-y-2 mb-4">
                <div
                    v-for="(s, idx) in form.speakers"
                    :key="s.id"
                    class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2"
                >
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-800">{{ getSpeakerName(s.id) }}</span>
                        <Badge variant="success">{{ roles.find((r) => r.value === s.role)?.label }}</Badge>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-red-500" @click="removeSpeaker(idx)">
                        <XMarkIcon class="w-4 h-4" />
                    </button>
                </div>
            </div>

            <!-- Add speaker -->
            <div v-if="availableSpeakers.length" class="flex items-end gap-2">
                <div class="flex-1">
                    <select
                        v-model="selectedSpeakerId"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                    >
                        <option value="">Seleccionar speaker...</option>
                        <option v-for="sp in availableSpeakers" :key="sp.id" :value="sp.id">
                            {{ sp.name }}
                        </option>
                    </select>
                </div>
                <div>
                    <select
                        v-model="selectedSpeakerRole"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
                    >
                        <option v-for="r in roles" :key="r.value" :value="r.value">{{ r.label }}</option>
                    </select>
                </div>
                <Button type="button" variant="secondary" size="md" @click="addSpeaker">
                    <PlusIcon class="w-4 h-4" />
                </Button>
            </div>
            <p v-if="form.errors.speakers" class="mt-1 text-sm text-red-600">{{ form.errors.speakers }}</p>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <Button variant="secondary" @click="$inertia.visit(route('admin.sessions.index'))">
                Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing">
                {{ form.processing ? 'Guardando...' : (isEditing ? 'Actualizar Sesion' : 'Crear Sesion') }}
            </Button>
        </div>
    </form>
</template>
