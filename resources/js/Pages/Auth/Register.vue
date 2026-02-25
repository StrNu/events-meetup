<script setup>
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import { UserPlusIcon, EnvelopeIcon, LockClosedIcon, UserIcon } from '@heroicons/vue/24/outline';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <AppLayout title="Crear cuenta" :hideNav="true">
        <div class="min-h-[calc(100vh-3.5rem)] flex flex-col items-center justify-center px-6 py-10">

            <!-- Icon -->
            <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center mb-6">
                <UserPlusIcon class="w-8 h-8" />
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-1">Crear cuenta</h1>
            <p class="text-sm text-gray-500 mb-8 text-center">
                Regístrate para guardar tu agenda personalizada.
            </p>

            <!-- Form -->
            <form @submit.prevent="submit" class="w-full max-w-sm space-y-4">

                <!-- Name -->
                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <div class="relative">
                        <UserIcon class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            autocomplete="name"
                            required
                            placeholder="Tu nombre"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            :class="{ 'border-red-400': form.errors.name }"
                        />
                    </div>
                    <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
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
                    <p v-if="form.errors.email" class="text-xs text-red-500">{{ form.errors.email }}</p>
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="relative">
                        <LockClosedIcon class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            autocomplete="new-password"
                            required
                            minlength="8"
                            placeholder="Mínimo 8 caracteres"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            :class="{ 'border-red-400': form.errors.password }"
                        />
                    </div>
                    <p v-if="form.errors.password" class="text-xs text-red-500">{{ form.errors.password }}</p>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                    <div class="relative">
                        <LockClosedIcon class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            placeholder="Repite tu contraseña"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        />
                    </div>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full flex items-center justify-center gap-2 bg-teal-600 text-white rounded-xl py-3 px-4 font-semibold hover:bg-teal-700 disabled:opacity-60 transition-colors mt-2"
                >
                    <UserPlusIcon class="w-5 h-5" />
                    <span>{{ form.processing ? 'Creando cuenta...' : 'Crear cuenta' }}</span>
                </button>

                <!-- Login link -->
                <p class="text-center text-sm text-gray-500 pt-2">
                    ¿Ya tienes cuenta?
                    <Link href="/login" class="text-teal-600 font-semibold hover:underline">Iniciar sesión</Link>
                </p>
            </form>
        </div>
    </AppLayout>
</template>
