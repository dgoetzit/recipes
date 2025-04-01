<template>
    <Popover
        v-slot="{ open, close }"
        ref="popoverRef"
        class="flex"
    >
        <div class="relative flex space-x-4">
            <PopoverButton
                :class="[
                    open ? 'text-sky-600' : 'text-gray-700 hover:text-gray-800',
                    'relative z-10 flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out',
                ]"
            >
                Recipes
                <span
                    :class="[
                        open ? 'bg-sky-600' : '',
                        'absolute inset-x-0 bottom-0 h-0.5 transition-colors duration-200 ease-out sm:mt-5 sm:translate-y-px sm:transform',
                    ]"
                    aria-hidden="true"
                />
            </PopoverButton>

            <transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0"
                enter-to="opacity-100"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100"
                leave-to="opacity-0"
            >
                <PopoverPanel class="absolute inset-x-0 top-full z-20">
                    <div
                        v-if="open"
                        v-once
                        class="hidden"
                        @vue:mounted="fetchInitialData"
                    />

                    <div
                        class="absolute inset-0 top-1/2 bg-white shadow"
                        aria-hidden="true"
                    />

                    <div
                        class="relative bg-white"
                        @click="handleClick($event, close)"
                    >
                        <div class="mx-auto max-w-7xl px-8">
                            <div class="py-8">
                                <Tab.Group v-model="activeTab">
                                    <Tab.List class="flex space-x-8 border-b border-gray-200">
                                        <Tab v-slot="{ selected }">
                                            <button
                                                :class="[
                                                    selected
                                                        ? 'border-sky-600 text-sky-600'
                                                        : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                                    'border-b-2 px-1 py-4 text-sm font-medium whitespace-nowrap transition-colors duration-200',
                                                ]"
                                            >
                                                Popular
                                            </button>
                                        </Tab>
                                        <Tab v-slot="{ selected }">
                                            <button
                                                :class="[
                                                    selected
                                                        ? 'border-sky-600 text-sky-600'
                                                        : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                                    'border-b-2 px-1 py-4 text-sm font-medium whitespace-nowrap transition-colors duration-200',
                                                ]"
                                            >
                                                Saved
                                            </button>
                                        </Tab>
                                    </Tab.List>

                                    <Tab.Panels class="mt-6">
                                        <Tab.Panel>
                                            <NavigationElementsTopRecipesPanel
                                                :recipes="topRecipes"
                                                :is-loading="isLoadingTop"
                                                :error="topError"
                                            />
                                        </Tab.Panel>

                                        <Tab.Panel>
                                            <NavigationElementsSavedRecipesPanel
                                                :recipes="savedRecipes"
                                                :is-loading="isLoadingSaved"
                                                :error="savedError"
                                            />
                                        </Tab.Panel>
                                    </Tab.Panels>
                                </Tab.Group>
                            </div>
                        </div>
                    </div>
                </PopoverPanel>
            </transition>
        </div>
    </Popover>
</template>

<script setup>
    import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
    import { Popover, PopoverButton, PopoverPanel, Tab } from '@headlessui/vue';
    import { useRouter } from 'vue-router';
    import { useRecipeStore } from '~/stores/savedRecipeStore';

    const router = useRouter();
    const recipeStore = useRecipeStore();
    const popoverRef = ref(null);
    const activeTab = ref(0);

    const topRecipes = ref([]);
    const isLoadingTop = ref(false);
    const hasLoadedTop = ref(false);
    const topError = ref(null);

    const savedRecipes = ref([]);
    const isLoadingSaved = ref(false);
    const hasLoadedSaved = ref(false);
    const savedError = ref(null);

    watch(activeTab, (newTabIndex) => {
        if (newTabIndex === 0) {
            if (!hasLoadedTop.value) {
                fetchTopRecipes();
            }
        } else if (newTabIndex === 1) {
            if (!hasLoadedSaved.value) {
                fetchSavedRecipes();
            }
        }
    });

    const fetchInitialData = () => {
        if (activeTab.value === 0) {
            fetchTopRecipes();
        } else {
            fetchSavedRecipes();
        }
    };

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

    const stopRouteWatcher = ref(null);

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

    const fetchTopRecipes = async () => {
        if (hasLoadedTop.value && topRecipes.value.length > 0) return;

        isLoadingTop.value = true;
        topError.value = null;

        try {
            const response = await $fetch('/api/recipes/top');
            topRecipes.value = response.data.data || [];
            hasLoadedTop.value = true;
        } catch (err) {
            topError.value = err.message || 'An error occurred while fetching top recipes';
            console.error('Failed to fetch top recipes:', err);
        } finally {
            isLoadingTop.value = false;
        }
    };

    const fetchSavedRecipes = async () => {
        if (hasLoadedSaved.value) return;

        isLoadingSaved.value = true;
        savedError.value = null;

        try {
            savedRecipes.value = recipeStore.getSavedRecipes;
            hasLoadedSaved.value = true;
        } catch (err) {
            savedError.value = err.message || 'An error occurred while fetching saved recipes';
            console.error('Failed to fetch saved recipes:', err);
        } finally {
            isLoadingSaved.value = false;
        }
    };
</script>
