<script setup>
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import { UserIcon, ArrowRightOnRectangleIcon, EnvelopeIcon, LockClosedIcon } from '@heroicons/vue/24/outline';

defineProps({
    errors: { type: Object, default: () => ({}) },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <AppLayout title="Iniciar Sesión" :hideNav="true">
        <div class="min-h-[calc(100vh-3.5rem)] flex flex-col items-center justify-center px-6 py-10">

            <!-- Logo / Icon -->
            <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center mb-6">
                <UserIcon class="w-8 h-8" />
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-1">Bienvenido</h1>
            <p class="text-sm text-gray-500 mb-8 text-center">
                Inicia sesión para guardar tu agenda personalizada.
            </p>

            <!-- Form -->
            <form @submit.prevent="submit" class="w-full max-w-sm space-y-4">

                <!-- Error global -->
                <div
                    v-if="form.errors.email"
                    class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3"
                >
                    {{ form.errors.email }}
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Correo electrónico
                    </label>
                    <div class="relative">
                        <EnvelopeIcon class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                            required
                            placeholder="correo@ejemplo.com"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            :class="{ 'border-red-400': form.errors.email }"
                        />
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Contraseña
                    </label>
                    <div class="relative">
                        <LockClosedIcon class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            autocomplete="current-password"
                            required
                            placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            :class="{ 'border-red-400': form.errors.password }"
                        />
                    </div>
                    <p v-if="form.errors.password" class="text-xs text-red-500 mt-1">{{ form.errors.password }}</p>
                </div>

                <!-- Remember me -->
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input
                        v-model="form.remember"
                        type="checkbox"
                        class="w-4 h-4 rounded text-teal-600 border-gray-300 focus:ring-teal-500"
                    />
                    <span class="text-sm text-gray-600">Mantener sesión iniciada</span>
                </label>

                <!-- Submit -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full flex items-center justify-center gap-2 bg-teal-600 text-white rounded-xl py-3 px-4 font-semibold hover:bg-teal-700 disabled:opacity-60 transition-colors mt-2"
                >
                    <ArrowRightOnRectangleIcon class="w-5 h-5" />
                    <span>{{ form.processing ? 'Ingresando...' : 'Iniciar Sesión' }}</span>
                </button>

                <!-- Register link -->
                <p class="text-center text-sm text-gray-500 pt-2">
                    ¿No tienes cuenta?
                    <Link href="/register" class="text-teal-600 font-semibold hover:underline">Regístrate</Link>
                </p>
            </form>
        </div>
    </AppLayout>
</template>
