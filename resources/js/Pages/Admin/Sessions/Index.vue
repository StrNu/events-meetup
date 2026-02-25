<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Button from '@/Components/UI/Button.vue';
import Card from '@/Components/UI/Card.vue';
import SearchBar from '@/Components/UI/SearchBar.vue';
import Badge from '@/Components/UI/Badge.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import Modal from '@/Components/UI/Modal.vue';
import { CalendarDaysIcon, PencilSquareIcon, TrashIcon, StarIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    sessions: { type: Array, default: () => [] },
    event: { type: Object, default: null },
});

const search = ref('');
const deleteModal = ref(false);
const sessionToDelete = ref(null);

const filteredSessions = computed(() => {
    if (!search.value) return props.sessions;
    const q = search.value.toLowerCase();
    return props.sessions.filter(
        (s) =>
            s.title.toLowerCase().includes(q) ||
            (s.room?.name && s.room.name.toLowerCase().includes(q))
    );
});

function formatTime(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return d.toLocaleString('es-MX', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
}

function confirmDelete(session) {
    sessionToDelete.value = session;
    deleteModal.value = true;
}

function deleteSession() {
    router.delete(route('admin.sessions.destroy', sessionToDelete.value.id), {
        onFinish: () => {
            deleteModal.value = false;
            sessionToDelete.value = null;
        },
    });
}
</script>

<template>
    <AdminLayout title="Sesiones">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <SearchBar v-model="search" placeholder="Buscar sesiones..." class="sm:max-w-xs" />
            <Link :href="route('admin.sessions.create')">
                <Button>Nueva Sesion</Button>
            </Link>
        </div>

        <Card :padding="false">
            <div v-if="filteredSessions.length === 0" class="p-6">
                <EmptyState
                    :icon="CalendarDaysIcon"
                    title="No hay sesiones"
                    :description="search ? 'No se encontraron resultados.' : 'Agrega tu primera sesion al evento.'"
                >
                    <template v-if="!search" #action>
                        <Link :href="route('admin.sessions.create')">
                            <Button size="sm">Nueva Sesion</Button>
                        </Link>
                    </template>
                </EmptyState>
            </div>

            <div v-else class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-left px-6 py-3 font-medium text-gray-500">Sesion</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden sm:table-cell">Sala</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden md:table-cell">Horario</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden lg:table-cell">Speakers</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="session in filteredSessions" :key="session.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <StarIcon v-if="session.is_featured" class="w-4 h-4 text-yellow-500 shrink-0" />
                                    <div>
                                        <p class="font-medium text-gray-800">{{ session.title }}</p>
                                        <p v-if="session.category" class="text-xs text-gray-400">{{ session.category.name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 hidden sm:table-cell">
                                {{ session.room?.name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 hidden md:table-cell">
                                <p>{{ formatTime(session.start_time) }}</p>
                                <p class="text-xs text-gray-400">{{ formatTime(session.end_time) }}</p>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="flex flex-wrap gap-1">
                                    <Badge v-for="sp in session.speakers" :key="sp.id" variant="success">
                                        {{ sp.name }}
                                    </Badge>
                                    <span v-if="!session.speakers?.length" class="text-gray-400">—</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="route('admin.sessions.edit', session.id)" class="text-gray-400 hover:text-teal-600">
                                        <PencilSquareIcon class="w-5 h-5" />
                                    </Link>
                                    <button class="text-gray-400 hover:text-red-600" @click="confirmDelete(session)">
                                        <TrashIcon class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>

        <Modal :show="deleteModal" title="Eliminar Sesion" @close="deleteModal = false">
            <p class="text-sm text-gray-600 mb-6">
                Estas seguro de eliminar <strong>{{ sessionToDelete?.title }}</strong>? Esta accion no se puede deshacer.
            </p>
            <div class="flex justify-end gap-3">
                <Button variant="secondary" @click="deleteModal = false">Cancelar</Button>
                <Button variant="danger" @click="deleteSession">Eliminar</Button>
            </div>
        </Modal>
    </AdminLayout>
</template>
