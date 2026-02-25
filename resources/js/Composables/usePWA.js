import { ref, onMounted, onBeforeUnmount } from 'vue';

const deferredPrompt = ref(null);
const canInstall = ref(false);
const dismissed = ref(localStorage.getItem('pwa_dismissed') === '1');

export function usePWA() {
    function onBeforeInstallPrompt(e) {
        e.preventDefault();
        deferredPrompt.value = e;
        canInstall.value = true;
    }

    function onAppInstalled() {
        deferredPrompt.value = null;
        canInstall.value = false;
    }

    onMounted(() => {
        window.addEventListener('beforeinstallprompt', onBeforeInstallPrompt);
        window.addEventListener('appinstalled', onAppInstalled);
    });

    onBeforeUnmount(() => {
        window.removeEventListener('beforeinstallprompt', onBeforeInstallPrompt);
        window.removeEventListener('appinstalled', onAppInstalled);
    });

    async function install() {
        if (!deferredPrompt.value) return;
        deferredPrompt.value.prompt();
        const { outcome } = await deferredPrompt.value.userChoice;
        if (outcome === 'accepted') {
            canInstall.value = false;
        }
        deferredPrompt.value = null;
    }

    function dismiss() {
        dismissed.value = true;
        localStorage.setItem('pwa_dismissed', '1');
    }

    return {
        canInstall,
        dismissed,
        install,
        dismiss,
    };
}
