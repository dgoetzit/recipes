<template>
    <Popover
        class="flex"
        v-slot="{ open, close }"
        ref="popoverRef"
    >
        <div class="relative flex">
            <PopoverButton
                :class="[
                    open ? 'text-sky-600' : 'text-gray-700 hover:text-gray-800',
                    'relative z-10 flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out',
                ]"
            >
                Saved Recipes
                <span
                    :class="[
                        open ? 'bg-sky-600' : '',
                        'absolute inset-x-0 bottom-0 h-0.5 transition-colors duration-200 ease-out sm:mt-5 sm:translate-y-px sm:transform',
                    ]"
                    aria-hidden="true"
                />
            </PopoverButton>
        </div>

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
                    @vue:mounted="loadSavedRecipes"
                ></div>

                <div
                    class="absolute inset-0 top-1/2 bg-white shadow"
                    aria-hidden="true"
                />

                <div
                    class="relative bg-white"
                    @click="handleClick($event, close)"
                >
                    <div class="mx-auto max-w-7xl px-8">
                        <div class="py-16">
                            <!-- Header with Clear All button -->
                            <div
                                class="mb-6 flex items-center justify-between"
                                v-if="!isLoading && !error && savedRecipes.length > 0"
                            >
                                <h2 class="text-lg font-medium text-gray-900">Your Saved Recipes</h2>
                                <button
                                    @click="clearAllSaved"
                                    class="clear-btn rounded-md bg-red-50 px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-100 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none"
                                >
                                    Clear All
                                </button>
                            </div>

                            <div
                                v-if="isLoading"
                                class="flex items-center justify-center py-12"
                            >
                                <UiStatesLoading />
                            </div>

                            <div
                                v-else-if="error"
                                class="p-6 text-center"
                            >
                                <UiStatesError />
                            </div>

                            <div v-else>
                                <!-- Show empty state if no saved recipes -->
                                <div
                                    v-if="savedRecipes.length === 0"
                                    class="py-12 text-center"
                                >
                                    <p class="text-gray-500">No saved recipes yet</p>
                                </div>

                                <div
                                    v-else
                                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:gap-6"
                                >
                                    <RecipeFeaturedCard
                                        v-for="recipe in savedRecipes"
                                        :key="recipe.id"
                                        :recipe="recipe"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </PopoverPanel>
        </transition>
    </Popover>
</template>

<script setup>
    import { ref, onMounted, onBeforeUnmount, computed } from 'vue';
    import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
    import { useRouter } from 'vue-router';
    import { useRecipeStore } from '~/stores/savedRecipeStore';

    const router = useRouter();
    const recipeStore = useRecipeStore();
    const popoverRef = ref(null);
    const isLoading = ref(false);
    const error = ref(null);

    const savedRecipes = computed(() => recipeStore.getSavedRecipes);

    const handleClick = (event, close) => {
        const clickedElement = event.target;
        const isLink =
            clickedElement.tagName === 'A' ||
            clickedElement.closest('a') ||
            clickedElement.closest('.nuxt-link') ||
            clickedElement.closest('.recipe-card');

        if (isLink && !clickedElement.classList.contains('clear-btn')) {
            console.log('Link clicked, closing popover');
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

    const loadSavedRecipes = () => {
        isLoading.value = true;
        error.value = null;

        // simulated loading state...
        try {
            setTimeout(() => {
                isLoading.value = false;
            }, 300);
        } catch (err) {
            console.error('Error loading saved recipes:', err);
            isLoading.value = false;
            error.value = err;
        }
    };

    const clearAllSaved = () => {
        if (confirm('Are you sure you want to clear all saved recipes?')) {
            recipeStore.clearAllRecipes();
        }
    };
</script>
