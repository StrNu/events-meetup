<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Button from '@/Components/UI/Button.vue';
import Card from '@/Components/UI/Card.vue';
import SearchBar from '@/Components/UI/SearchBar.vue';
import Avatar from '@/Components/UI/Avatar.vue';
import Badge from '@/Components/UI/Badge.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import Modal from '@/Components/UI/Modal.vue';
import { MicrophoneIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    speakers: { type: Array, default: () => [] },
    event: { type: Object, default: null },
});

const search = ref('');
const deleteModal = ref(false);
const speakerToDelete = ref(null);

const filteredSpeakers = computed(() => {
    if (!search.value) return props.speakers;
    const q = search.value.toLowerCase();
    return props.speakers.filter(
        (s) =>
            s.name.toLowerCase().includes(q) ||
            s.title.toLowerCase().includes(q) ||
            (s.organization && s.organization.toLowerCase().includes(q))
    );
});

const typeVariant = {
    keynote: 'info',
    speaker: 'success',
    panelist: 'warning',
    host: 'default',
};

function confirmDelete(speaker) {
    speakerToDelete.value = speaker;
    deleteModal.value = true;
}

function deleteSpeaker() {
    router.delete(route('admin.speakers.destroy', speakerToDelete.value.id), {
        onFinish: () => {
            deleteModal.value = false;
            speakerToDelete.value = null;
        },
    });
}
</script>

<template>
    <AdminLayout title="Speakers">
        <!-- Header actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <SearchBar v-model="search" placeholder="Buscar speakers..." class="sm:max-w-xs" />
            <Link :href="route('admin.speakers.create')">
                <Button>Nuevo Speaker</Button>
            </Link>
        </div>

        <!-- Table -->
        <Card :padding="false">
            <div v-if="filteredSpeakers.length === 0" class="p-6">
                <EmptyState
                    :icon="MicrophoneIcon"
                    title="No hay speakers"
                    :description="search ? 'No se encontraron resultados.' : 'Agrega tu primer speaker al evento.'"
                >
                    <template v-if="!search" #action>
                        <Link :href="route('admin.speakers.create')">
                            <Button size="sm">Nuevo Speaker</Button>
                        </Link>
                    </template>
                </EmptyState>
            </div>

            <div v-else class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-left px-6 py-3 font-medium text-gray-500">Speaker</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden sm:table-cell">Cargo</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden md:table-cell">Tipo</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="speaker in filteredSpeakers" :key="speaker.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <Avatar :src="speaker.photo_url" :name="speaker.name" />
                                    <div>
                                        <p class="font-medium text-gray-800">{{ speaker.name }}</p>
                                        <p class="text-xs text-gray-500 sm:hidden">{{ speaker.title }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 hidden sm:table-cell">
                                <p>{{ speaker.title }}</p>
                                <p v-if="speaker.organization" class="text-xs text-gray-400">{{ speaker.organization }}</p>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <Badge :variant="typeVariant[speaker.type]">{{ speaker.type }}</Badge>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="route('admin.speakers.edit', speaker.id)" class="text-gray-400 hover:text-teal-600">
                                        <PencilSquareIcon class="w-5 h-5" />
                                    </Link>
                                    <button class="text-gray-400 hover:text-red-600" @click="confirmDelete(speaker)">
                                        <TrashIcon class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>

        <!-- Delete modal -->
        <Modal :show="deleteModal" title="Eliminar Speaker" @close="deleteModal = false">
            <p class="text-sm text-gray-600 mb-6">
                Estas seguro de eliminar a <strong>{{ speakerToDelete?.name }}</strong>? Esta accion no se puede deshacer.
            </p>
            <div class="flex justify-end gap-3">
                <Button variant="secondary" @click="deleteModal = false">Cancelar</Button>
                <Button variant="danger" @click="deleteSpeaker">Eliminar</Button>
            </div>
        </Modal>
    </AdminLayout>
</template>
