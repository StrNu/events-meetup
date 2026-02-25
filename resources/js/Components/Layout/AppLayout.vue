<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import BottomNav from './BottomNav.vue';
import { usePWA } from '@/Composables/usePWA';
import { Bars3Icon, XMarkIcon, ArrowDownTrayIcon } from '@heroicons/vue/24/outline';

defineProps({
    title: { type: String, default: '' },
    hideNav: { type: Boolean, default: false },
});

const page = usePage();
const menuOpen = ref(false);
const eventName = page.props.event?.name ?? 'EventFlow';
const { canInstall, dismissed, install, dismiss } = usePWA();
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-[428px] mx-auto bg-white min-h-screen relative shadow-sm">
            <!-- Header -->
            <header class="sticky top-0 z-30 bg-teal-600 text-white">
            <div class="flex items-center justify-between h-14 px-4">
                    <Link href="/" class="text-lg font-bold tracking-tight">
                        {{ eventName }}
                    </Link>
                    <div class="flex items-center gap-2">
                        <!-- User avatar if logged in -->
                        <Link
                            v-if="page.props.auth?.user"
                            href="/my-talks"
                            class="flex items-center gap-1.5 bg-teal-500 hover:bg-teal-400 transition-colors rounded-full px-2.5 py-1"
                        >
                            <div class="w-5 h-5 rounded-full bg-white text-teal-600 flex items-center justify-center text-[10px] font-bold shrink-0">
                                {{ page.props.auth.user.name.split(' ').map(w => w[0]).join('').slice(0,2).toUpperCase() }}
                            </div>
                            <span class="text-xs font-medium text-white leading-none">{{ page.props.auth.user.name.split(' ')[0] }}</span>
                        </Link>
                        <button @click="menuOpen = !menuOpen" class="p-1">
                            <XMarkIcon v-if="menuOpen" class="w-6 h-6" />
                            <Bars3Icon v-else class="w-6 h-6" />
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div v-if="menuOpen" class="border-t border-teal-500 px-4 py-3 space-y-2">
                    <Link href="/" class="block py-2 text-sm hover:text-teal-200" @click="menuOpen = false">Home</Link>
                    <Link href="/talks" class="block py-2 text-sm hover:text-teal-200" @click="menuOpen = false">Talks</Link>
                    <Link href="/schedule" class="block py-2 text-sm hover:text-teal-200" @click="menuOpen = false">Schedule</Link>
                    <Link href="/speakers" class="block py-2 text-sm hover:text-teal-200" @click="menuOpen = false">Speakers</Link>
                    <Link href="/map" class="block py-2 text-sm hover:text-teal-200" @click="menuOpen = false">Map</Link>
                    <Link href="/info" class="block py-2 text-sm hover:text-teal-200" @click="menuOpen = false">Info</Link>
                    <div class="border-t border-teal-500 pt-2 mt-2 space-y-1">
                        <template v-if="page.props.auth?.user">
                            <!-- Logged in: show name + actions -->
                            <div class="py-1 text-xs text-teal-200">
                                Sesión iniciada como <span class="font-semibold text-white">{{ page.props.auth.user.name }}</span>
                            </div>
                            <Link
                                href="/my-talks"
                                class="block py-2 text-sm hover:text-teal-200"
                                @click="menuOpen = false"
                            >
                                Mi Agenda
                            </Link>
                            <Link
                                v-if="page.props.auth.user.is_admin"
                                href="/admin"
                                class="block py-2 text-sm hover:text-teal-200"
                                @click="menuOpen = false"
                            >
                                Admin Panel
                            </Link>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                class="block w-full text-left py-2 text-sm text-red-300 hover:text-red-200"
                                @click="menuOpen = false"
                            >
                                Cerrar Sesión
                            </Link>
                        </template>
                        <template v-else>
                            <!-- Guest: show login link -->
                            <Link
                                href="/login"
                                class="block py-2 text-sm hover:text-teal-200"
                                @click="menuOpen = false"
                            >
                                Iniciar Sesión
                            </Link>
                        </template>
                    </div>
                </div>
            </header>

            <!-- Page title -->
            <div v-if="title" class="px-4 pt-4 pb-2">
                <h1 class="text-xl font-bold text-gray-800">{{ title }}</h1>
            </div>

            <!-- PWA Install Banner -->
            <div
                v-if="canInstall && !dismissed"
                class="mx-4 mt-3 flex items-center gap-3 bg-teal-50 border border-teal-200 rounded-xl px-4 py-3"
            >
                <ArrowDownTrayIcon class="w-5 h-5 text-teal-600 shrink-0" />
                <p class="flex-1 text-xs text-teal-800">Instala la app para acceso rapido.</p>
                <button
                    class="text-xs font-semibold text-teal-600 hover:text-teal-700 whitespace-nowrap"
                    @click="install"
                >
                    Instalar
                </button>
                <button
                    class="text-xs text-gray-400 hover:text-gray-500"
                    @click="dismiss"
                >
                    &times;
                </button>
            </div>

            <!-- Content -->
            <main class="pb-20">
                <slot />
            </main>

            <!-- Bottom navigation -->
            <BottomNav v-if="!hideNav" />
        </div>
    </div>
</template>
