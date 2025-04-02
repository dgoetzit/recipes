<template>
    <TabGroup
        v-model="activeTab"
        as="div"
        class="mt-2"
    >
        <div class="border-b border-gray-200">
            <TabList class="-mb-px flex px-4">
                <Tab
                    v-slot="{ selected }"
                    as="template"
                >
                    <button
                        :class="[
                            selected ? 'border-sky-600 text-sky-600' : 'border-transparent text-gray-900',
                            'flex-1 border-b-2 px-1 py-4 text-base font-medium whitespace-nowrap',
                            'focus:ring-0 focus:outline-none',
                        ]"
                    >
                        Top Recipes
                    </button>
                </Tab>

                <Tab
                    v-slot="{ selected }"
                    as="template"
                >
                    <button
                        :class="[
                            selected ? 'border-sky-600 text-sky-600' : 'border-transparent text-gray-900',
                            'flex-1 border-b-2 px-1 py-4 text-base font-medium whitespace-nowrap',
                            'focus:ring-0 focus:outline-none',
                        ]"
                    >
                        Saved Recipes
                    </button>
                </Tab>
            </TabList>
        </div>

        <TabPanels as="template">
            <TabPanel class="px-4 pt-6 pb-8">
                <div @click="handleLinkClick">
                    <div
                        v-if="isLoadingTop"
                        class="flex items-center justify-center py-8"
                    >
                        <UiStatesLoading />
                    </div>

                    <div
                        v-else-if="topError"
                        class="p-4 text-center"
                    >
                        <UiStatesError />
                    </div>

                    <div
                        v-else
                        class="grid grid-cols-2 gap-4"
                    >
                        <RecipeFeaturedCard
                            v-for="recipe in topRecipes"
                            :key="recipe.id"
                            :recipe="recipe"
                            class="col-span-2 sm:col-span-1"
                        />
                    </div>
                </div>
            </TabPanel>

            <TabPanel class="px-4 pt-6 pb-8">
                <div @click="handleLinkClick">
                    <div
                        v-if="!isLoadingSaved && !savedError && savedRecipes.length > 0"
                        class="mb-6 flex items-center justify-end"
                    >
                        <button
                            class="clear-btn rounded-md bg-red-50 px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-100 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none"
                            @click.stop="clearAllSaved"
                        >
                            Clear All
                        </button>
                    </div>

                    <div
                        v-if="isLoadingSaved"
                        class="flex items-center justify-center py-8"
                    >
                        <UiStatesLoading />
                    </div>

                    <div
                        v-else-if="savedError"
                        class="p-4 text-center"
                    >
                        <UiStatesError />
                    </div>

                    <div v-else>
                        <div
                            v-if="savedRecipes.length === 0"
                            class="py-8 text-center"
                        >
                            <UiStatesEmpty
                                title="No saved recipes"
                                description="You haven't saved any recipes yet."
                                emoji="🤷‍♂️"
                            />
                        </div>

                        <div
                            v-else
                            class="grid grid-cols-2 gap-4"
                        >
                            <RecipeFeaturedCard
                                v-for="recipe in savedRecipes"
                                :key="recipe.id"
                                :recipe="recipe"
                                class="col-span-2 sm:col-span-1"
                            />
                        </div>
                    </div>
                </div>
            </TabPanel>
        </TabPanels>
    </TabGroup>
</template>

<script setup>
    import { ref, watch, onMounted, computed } from 'vue';
    import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue';
    import { useSavedRecipeStore } from '~/stores/useSavedRecipeStore';

    const recipeStore = useSavedRecipeStore();
    const activeTab = ref(0);

    // Top recipes state
    const topRecipes = ref([]);
    const isLoadingTop = ref(false);
    const hasLoadedTop = ref(false);
    const topError = ref(null);

    // Saved recipes state
    const savedRecipes = computed(() => recipeStore.getSavedRecipes);
    const isLoadingSaved = ref(false);
    const hasLoadedSaved = ref(false);
    const savedError = ref(null);

    // Watch for tab changes to load data
    watch(activeTab, (newTabIndex) => {
        if (newTabIndex === 0) {
            if (!hasLoadedTop.value) {
                fetchTopRecipes();
            }
        } else if (newTabIndex === 1) {
            if (!hasLoadedSaved.value) {
                loadSavedRecipes();
            }
        }
    });

    // Load initial tab data
    onMounted(() => {
        if (activeTab.value === 0) {
            fetchTopRecipes();
        } else {
            loadSavedRecipes();
        }
    });

    const emit = defineEmits(['close']);

    const handleLinkClick = (event) => {
        const clickedElement = event.target;
        const isLink =
            clickedElement.tagName === 'A' ||
            clickedElement.closest('a') ||
            clickedElement.closest('.nuxt-link') ||
            clickedElement.closest('.recipe-card');

        if (isLink && !clickedElement.classList.contains('clear-btn')) {
            emit('close');
        }
    };

    // Fetch top recipes from API
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

    // Load saved recipes from store
    const loadSavedRecipes = () => {
        isLoadingSaved.value = true;
        savedError.value = null;

        try {
            // Simulate loading state for better UX
            setTimeout(() => {
                hasLoadedSaved.value = true;
                isLoadingSaved.value = false;
            }, 300);
        } catch (err) {
            console.error('Error loading saved recipes:', err);
            savedError.value = err.message || 'An error occurred while loading saved recipes';
            isLoadingSaved.value = false;
        }
    };

    // Clear all saved recipes
    const clearAllSaved = () => {
        if (confirm('Are you sure you want to clear all saved recipes?')) {
            recipeStore.clearAllRecipes();
        }
    };
</script>

<style scoped>
    button:focus {
        outline: none;
        box-shadow: none;
    }

    button:focus-visible {
        outline: 2px solid #0284c7; /* sky-600 */
        outline-offset: 2px;
    }
</style>
