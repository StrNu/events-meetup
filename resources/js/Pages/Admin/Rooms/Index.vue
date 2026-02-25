<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Button from '@/Components/UI/Button.vue';
import Card from '@/Components/UI/Card.vue';
import SearchBar from '@/Components/UI/SearchBar.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import Modal from '@/Components/UI/Modal.vue';
import { BuildingOfficeIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    rooms: { type: Array, default: () => [] },
    event: { type: Object, default: null },
});

const search = ref('');
const deleteModal = ref(false);
const roomToDelete = ref(null);

const filteredRooms = computed(() => {
    if (!search.value) return props.rooms;
    const q = search.value.toLowerCase();
    return props.rooms.filter((r) => r.name.toLowerCase().includes(q));
});

function confirmDelete(room) {
    roomToDelete.value = room;
    deleteModal.value = true;
}

function deleteRoom() {
    router.delete(route('admin.rooms.destroy', roomToDelete.value.id), {
        onFinish: () => { deleteModal.value = false; roomToDelete.value = null; },
    });
}
</script>

<template>
    <AdminLayout title="Salas">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <SearchBar v-model="search" placeholder="Buscar salas..." class="sm:max-w-xs" />
            <Link :href="route('admin.rooms.create')"><Button>Nueva Sala</Button></Link>
        </div>

        <Card :padding="false">
            <div v-if="filteredRooms.length === 0" class="p-6">
                <EmptyState :icon="BuildingOfficeIcon" title="No hay salas" :description="search ? 'No se encontraron resultados.' : 'Agrega tu primera sala.'">
                    <template v-if="!search" #action>
                        <Link :href="route('admin.rooms.create')"><Button size="sm">Nueva Sala</Button></Link>
                    </template>
                </EmptyState>
            </div>
            <div v-else class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-left px-6 py-3 font-medium text-gray-500">Sala</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden sm:table-cell">Capacidad</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden md:table-cell">Sesiones</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="room in filteredRooms" :key="room.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ room.name }}</p>
                                <p v-if="room.description" class="text-xs text-gray-400">{{ room.description }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600 hidden sm:table-cell">{{ room.capacity ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-600 hidden md:table-cell">{{ room.sessions_count ?? 0 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="route('admin.rooms.edit', room.id)" class="text-gray-400 hover:text-teal-600"><PencilSquareIcon class="w-5 h-5" /></Link>
                                    <button class="text-gray-400 hover:text-red-600" @click="confirmDelete(room)"><TrashIcon class="w-5 h-5" /></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>

        <Modal :show="deleteModal" title="Eliminar Sala" @close="deleteModal = false">
            <p class="text-sm text-gray-600 mb-6">Estas seguro de eliminar <strong>{{ roomToDelete?.name }}</strong>?</p>
            <div class="flex justify-end gap-3">
                <Button variant="secondary" @click="deleteModal = false">Cancelar</Button>
                <Button variant="danger" @click="deleteRoom">Eliminar</Button>
            </div>
        </Modal>
    </AdminLayout>
</template>
