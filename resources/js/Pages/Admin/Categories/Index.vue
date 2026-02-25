<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Layout/AdminLayout.vue';
import Button from '@/Components/UI/Button.vue';
import Card from '@/Components/UI/Card.vue';
import SearchBar from '@/Components/UI/SearchBar.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import Modal from '@/Components/UI/Modal.vue';
import { TagIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    categories: { type: Array, default: () => [] },
    event: { type: Object, default: null },
});

const search = ref('');
const deleteModal = ref(false);
const itemToDelete = ref(null);

const filteredCategories = computed(() => {
    if (!search.value) return props.categories;
    const q = search.value.toLowerCase();
    return props.categories.filter((c) => c.name.toLowerCase().includes(q));
});

function confirmDelete(cat) {
    itemToDelete.value = cat;
    deleteModal.value = true;
}

function deleteItem() {
    router.delete(route('admin.categories.destroy', itemToDelete.value.id), {
        onFinish: () => { deleteModal.value = false; itemToDelete.value = null; },
    });
}
</script>

<template>
    <AdminLayout title="Categorias">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <SearchBar v-model="search" placeholder="Buscar categorias..." class="sm:max-w-xs" />
            <Link :href="route('admin.categories.create')"><Button>Nueva Categoria</Button></Link>
        </div>

        <Card :padding="false">
            <div v-if="filteredCategories.length === 0" class="p-6">
                <EmptyState :icon="TagIcon" title="No hay categorias" :description="search ? 'No se encontraron resultados.' : 'Agrega tu primera categoria.'">
                    <template v-if="!search" #action>
                        <Link :href="route('admin.categories.create')"><Button size="sm">Nueva Categoria</Button></Link>
                    </template>
                </EmptyState>
            </div>
            <div v-else class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-left px-6 py-3 font-medium text-gray-500">Categoria</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden sm:table-cell">Descripcion</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="cat in filteredCategories" :key="cat.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ cat.name }}</td>
                            <td class="px-6 py-4 text-gray-600 hidden sm:table-cell">{{ cat.description ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="route('admin.categories.edit', cat.id)" class="text-gray-400 hover:text-teal-600"><PencilSquareIcon class="w-5 h-5" /></Link>
                                    <button class="text-gray-400 hover:text-red-600" @click="confirmDelete(cat)"><TrashIcon class="w-5 h-5" /></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>

        <Modal :show="deleteModal" title="Eliminar Categoria" @close="deleteModal = false">
            <p class="text-sm text-gray-600 mb-6">Estas seguro de eliminar <strong>{{ itemToDelete?.name }}</strong>?</p>
            <div class="flex justify-end gap-3">
                <Button variant="secondary" @click="deleteModal = false">Cancelar</Button>
                <Button variant="danger" @click="deleteItem">Eliminar</Button>
            </div>
        </Modal>
    </AdminLayout>
</template>
