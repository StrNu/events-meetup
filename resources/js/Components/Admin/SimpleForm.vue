<script setup>
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from '@/Components/UI/Button.vue';

const props = defineProps({
    item: { type: Object, default: null },
    event: { type: Object, required: true },
    fields: { type: Array, required: true },
    submitUrl: { type: String, required: true },
    method: { type: String, default: 'post' },
    cancelRoute: { type: String, required: true },
    submitLabel: { type: String, default: 'Guardar' },
});

const initialData = { event_id: props.event?.id ?? '' };
props.fields.forEach((f) => {
    initialData[f.name] = props.item?.[f.name] ?? f.default ?? '';
});

const form = useForm(initialData);
const isEditing = computed(() => !!props.item);

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
        <div v-for="field in fields" :key="field.name">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ field.label }} {{ field.required ? '*' : '' }}
            </label>

            <textarea
                v-if="field.type === 'textarea'"
                v-model="form[field.name]"
                rows="3"
                :required="field.required"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
            />
            <input
                v-else
                v-model="form[field.name]"
                :type="field.type || 'text'"
                :required="field.required"
                :placeholder="field.placeholder"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"
            />
            <p v-if="form.errors[field.name]" class="mt-1 text-sm text-red-600">{{ form.errors[field.name] }}</p>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <Button variant="secondary" @click="$inertia.visit(cancelRoute)">Cancelar</Button>
            <Button type="submit" :disabled="form.processing">
                {{ form.processing ? 'Guardando...' : (isEditing ? 'Actualizar' : submitLabel) }}
            </Button>
        </div>
    </form>
</template>
