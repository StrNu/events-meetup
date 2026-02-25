<script setup>
import { Link } from '@inertiajs/vue3';
import {
    HomeIcon,
    MicrophoneIcon,
    CalendarDaysIcon,
    HeartIcon,
    InformationCircleIcon,
} from '@heroicons/vue/24/outline';
import {
    HomeIcon as HomeIconSolid,
    MicrophoneIcon as MicrophoneIconSolid,
    CalendarDaysIcon as CalendarDaysIconSolid,
    HeartIcon as HeartIconSolid,
    InformationCircleIcon as InformationCircleIconSolid,
} from '@heroicons/vue/24/solid';

const items = [
    { name: 'Home', href: '/', routeName: 'home', icon: HomeIcon, iconActive: HomeIconSolid },
    { name: 'Talks', href: '/talks', routeName: 'talks.index', icon: MicrophoneIcon, iconActive: MicrophoneIconSolid },
    { name: 'Schedule', href: '/schedule', routeName: 'schedule.index', icon: CalendarDaysIcon, iconActive: CalendarDaysIconSolid },
    { name: 'My Talks', href: '/my-talks', routeName: 'my-talks.index', icon: HeartIcon, iconActive: HeartIconSolid },
    { name: 'Info', href: '/info', routeName: 'info.index', icon: InformationCircleIcon, iconActive: InformationCircleIconSolid },
];

function isActive(routeName) {
    try {
        return route().current(routeName) || route().current(routeName + '.*');
    } catch {
        return false;
    }
}
</script>

<template>
    <nav class="fixed bottom-0 inset-x-0 z-40 bg-white border-t border-gray-200 safe-area-bottom">
        <div class="max-w-[428px] mx-auto flex items-center justify-around h-16">
            <Link
                v-for="item in items"
                :key="item.name"
                :href="item.href"
                :class="[
                    'flex flex-col items-center gap-0.5 px-2 py-1 text-[10px] font-medium transition-colors',
                    isActive(item.routeName) ? 'text-teal-600' : 'text-gray-400',
                ]"
            >
                <component
                    :is="isActive(item.routeName) ? item.iconActive : item.icon"
                    class="w-6 h-6"
                />
                {{ item.name }}
            </Link>
        </div>
    </nav>
</template>

<style scoped>
.safe-area-bottom {
    padding-bottom: env(safe-area-inset-bottom);
}
</style>
