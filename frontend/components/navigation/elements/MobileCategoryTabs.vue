<template>
    <TabGroup
        as="div"
        class="mt-2"
    >
        <div class="border-b border-gray-200">
            <TabList class="-mb-px flex px-4">
                <Tab
                    as="template"
                    v-slot="{ selected }"
                >
                    <button
                        :class="[
                            selected ? 'border-sky-600 text-sky-600' : 'border-transparent text-gray-900',
                            'flex-1 border-b-2 px-1 py-4 text-base font-medium whitespace-nowrap',
                            'focus:ring-0 focus:outline-none', // Remove default focus styling
                        ]"
                    >
                        Popular
                    </button>
                </Tab>

                <Tab
                    as="template"
                    v-slot="{ selected }"
                >
                    <button
                        :class="[
                            selected ? 'border-sky-600 text-sky-600' : 'border-transparent text-gray-900',
                            'flex-1 border-b-2 px-1 py-4 text-base font-medium whitespace-nowrap',
                            'focus:ring-0 focus:outline-none', // Remove default focus styling
                        ]"
                    >
                        Liked
                    </button>
                </Tab>
            </TabList>
        </div>

        <TabPanels as="template">
            <TabPanel class="px-4 pt-6 pb-8">
                <div>
                    <div
                        v-if="isLoading"
                        class="flex items-center justify-center py-8"
                    >
                        <UiStatesLoading />
                    </div>

                    <div
                        v-else-if="error"
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
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <svg
                        class="mb-3 h-16 w-16 text-gray-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                        ></path>
                    </svg>
                    <h3 class="mb-1 text-lg font-medium text-gray-900">No liked recipes yet</h3>
                    <p class="mb-4 text-gray-500">Sign in to save your favorite recipes</p>
                    <NuxtLink
                        to="/login"
                        class="inline-flex items-center rounded-md border border-transparent bg-sky-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-sky-700 focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:outline-none"
                    >
                        Sign in
                    </NuxtLink>
                </div>
            </TabPanel>
        </TabPanels>
    </TabGroup>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue';

    const topRecipes = ref([]);
    const isLoading = ref(false);
    const hasLoaded = ref(false);
    const error = ref(null);

    const fetchTopRecipes = async () => {
        if (hasLoaded.value && topRecipes.value.length > 0) return;

        isLoading.value = true;
        error.value = null;

        try {
            const response = await $fetch('/api/recipes/top');

            console.log('response', response);

            topRecipes.value = response.data.data || [];
            hasLoaded.value = true;
        } catch (err) {
            error.value = err.message || 'An error occurred while fetching recipes';
            console.error('Failed to fetch top recipes:', err);
        } finally {
            isLoading.value = false;
        }
    };

    onMounted(() => {
        fetchTopRecipes();
    });
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
