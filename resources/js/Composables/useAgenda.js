import { ref, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

export function useAgenda() {
    const page = usePage();
    const isAuthenticated = computed(() => !!page.props.auth?.user);

    // Filter out saved ids logic from localStorage as it's no longer used for unauthenticated users,
    // but we can compute it from the page props if the user is authenticated.
    const savedIds = computed(() => {
        if (!isAuthenticated.value || !page.props.auth.user.saved_sessions) return [];
        return page.props.auth.user.saved_sessions.map(s => s.id);
    });

    function isInAgenda(sessionId) {
        return savedIds.value.includes(sessionId);
    }

    function addToAgenda(sessionId) {
        if (!isAuthenticated.value) {
            router.get('/login');
            return;
        }

        router.post(`/my-talks/${sessionId}`, {}, {
            preserveScroll: true,
        });
    }

    function removeFromAgenda(sessionId) {
        if (!isAuthenticated.value) {
            router.get('/login');
            return;
        }

        router.delete(`/my-talks/${sessionId}`, {
            preserveScroll: true,
        });
    }

    function toggleAgenda(sessionId) {
        if (isInAgenda(sessionId)) {
            removeFromAgenda(sessionId);
        } else {
            addToAgenda(sessionId);
        }
    }

    return {
        isAuthenticated,
        isInAgenda,
        addToAgenda,
        removeFromAgenda,
        toggleAgenda,
        savedIds,
    };
}
