import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';

export const usePopover = () => {
    const popoverRef = ref(null);
    const router = useRouter();
    const stopRouteWatcher = ref(null);

    const handleClick = (event, close) => {
        const clickedElement = event.target;

        const isLink =
            clickedElement.tagName === 'A' ||
            clickedElement.closest('a') ||
            clickedElement.closest('.nuxt-link') ||
            clickedElement.closest('.recipe-card');

        if (isLink) {
            close();
        }
    };

    onMounted(() => {
        stopRouteWatcher.value = router.afterEach(() => {
            if (popoverRef.value?.$el) {
                const panel = popoverRef.value.$el.querySelector('[id^="headlessui-popover-panel-"]');

                if (panel) {
                    document.body.click();
                }
            }
        });
    });

    onBeforeUnmount(() => {
        if (stopRouteWatcher.value) {
            stopRouteWatcher.value();
        }
    });

    return {
        popoverRef,
        handleClick,
    };
};
