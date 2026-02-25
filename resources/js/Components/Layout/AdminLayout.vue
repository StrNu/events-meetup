<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    HomeIcon,
    CalendarDaysIcon,
    Cog6ToothIcon,
    MicrophoneIcon,
    BuildingOfficeIcon,
    TagIcon,
    Bars3Icon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';

defineProps({
    title: { type: String, default: '' },
});

const page = usePage();
const sidebarOpen = ref(false);

const navigation = [
    { name: 'Dashboard', href: route('admin.dashboard'), icon: HomeIcon, routePrefix: 'admin.dashboard' },
    { name: 'Evento', href: route('admin.events.edit'), icon: Cog6ToothIcon, routePrefix: 'admin.events' },
    { name: 'Speakers', href: route('admin.speakers.index'), icon: MicrophoneIcon, routePrefix: 'admin.speakers' },
    { name: 'Sesiones', href: route('admin.sessions.index'), icon: CalendarDaysIcon, routePrefix: 'admin.sessions' },
    { name: 'Salas', href: route('admin.rooms.index'), icon: BuildingOfficeIcon, routePrefix: 'admin.rooms' },
    { name: 'Categorias', href: route('admin.categories.index'), icon: TagIcon, routePrefix: 'admin.categories' },
];

function isActive(routePrefix) {
    return route().current(routePrefix) || route().current(routePrefix + '.*');
}
</script>

<template>
    <div class="min-h-screen bg-gray-50 lg:grid lg:grid-cols-[256px_1fr] overflow-x-hidden">
        <!-- Mobile sidebar overlay -->
        <div
            v-if="sidebarOpen"
            class="fixed inset-0 z-40 bg-gray-600/75 lg:hidden"
            @click="sidebarOpen = false"
        />

        <!-- Sidebar -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform transition-transform duration-200 lg:relative lg:translate-x-0 lg:z-auto',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
            ]"
        >
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <Link href="/" class="text-xl font-bold text-teal-600">
                    EventFlow
                </Link>
                <button class="lg:hidden text-gray-500" @click="sidebarOpen = false">
                    <XMarkIcon class="w-6 h-6" />
                </button>
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-4 space-y-1">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors',
                        isActive(item.routePrefix)
                            ? 'bg-teal-50 text-teal-700'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
                    ]"
                >
                    <component :is="item.icon" class="w-5 h-5 shrink-0" />
                    {{ item.name }}
                </Link>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex flex-col min-h-screen min-w-0">
            <!-- Top bar -->
            <header class="flex items-center h-16 px-4 bg-white border-b border-gray-200 sm:px-6 shrink-0">
                <button class="lg:hidden text-gray-500 mr-4" @click="sidebarOpen = true">
                    <Bars3Icon class="w-6 h-6" />
                </button>
                <h1 class="text-lg font-semibold text-gray-800">{{ title }}</h1>

                <div class="ml-auto flex items-center gap-3">
                    <span v-if="page.props.auth?.user" class="text-sm text-gray-500">
                        {{ page.props.auth.user.name }}
                    </span>
                </div>
            </header>

            <!-- Flash messages -->
            <div v-if="page.props.flash?.success" class="mx-4 mt-4 sm:mx-6">
                <div class="rounded-lg bg-teal-50 border border-teal-200 px-4 py-3 text-sm text-teal-700">
                    {{ page.props.flash.success }}
                </div>
            </div>
            <div v-if="page.props.flash?.error" class="mx-4 mt-4 sm:mx-6">
                <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    {{ page.props.flash.error }}
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 px-4 py-4 sm:px-6">
                <slot />
            </main>
        </div>
    </div>
</template>
