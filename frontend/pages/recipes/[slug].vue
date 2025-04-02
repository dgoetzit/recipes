<template>
    <div class="bg-white">
        <MetaSearchEngineOptimization :recipe="recipe" />

        <div class="mx-auto px-4 py-12 sm:px-6 sm:py-16 lg:max-w-7xl lg:px-8">
            <div class="lg:grid lg:grid-cols-7 lg:grid-rows-1 lg:gap-x-8 lg:gap-y-10 xl:gap-x-16">
                <div class="lg:col-span-4 lg:row-end-1">
                    <img
                        :src="recipe.image"
                        :alt="recipe.image_alt"
                        class="aspect-[4/3] w-full rounded-lg bg-gray-100 object-cover shadow-sm"
                    />
                </div>

                <div
                    class="mx-auto mt-10 max-w-2xl sm:mt-12 lg:col-span-3 lg:row-span-2 lg:row-end-2 lg:mt-0 lg:max-w-none"
                >
                    <div class="flex flex-col-reverse">
                        <div>
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                                {{ recipe.name }}
                            </h1>

                            <h2
                                id="information-heading"
                                class="sr-only"
                            >
                                Recipe Information
                            </h2>

                            <div
                                class="mt-3 flex flex-col space-y-2 text-sm sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4"
                            >
                                <p class="text-gray-600">
                                    <span class="mr-1 font-medium text-gray-900">By:</span>
                                    <NuxtLink
                                        :to="{ name: 'index', query: { email: recipe.email } }"
                                        class="underline hover:text-blue-500"
                                        >{{ recipe.email }}</NuxtLink
                                    >
                                </p>
                                <span class="hidden text-gray-300 sm:inline">|</span>
                                <p class="text-gray-600">
                                    <ClientOnly>
                                        <time :datetime="recipe.published_at">{{
                                            format(recipe.published_at, 'MMMM d, yyyy')
                                        }}</time>
                                    </ClientOnly>
                                </p>
                            </div>
                        </div>
                    </div>

                    <p class="mt-5 text-base leading-relaxed text-gray-700">
                        {{ recipe.description }}
                    </p>

                    <div class="save-button-wrapper mt-8">
                        <RecipeSave :recipe="recipe" />
                    </div>
                </div>

                <div class="mx-auto mt-12 w-full max-w-2xl lg:col-span-4 lg:mt-0 lg:max-w-none">
                    <TabGroup as="div">
                        <div class="border-b border-gray-200">
                            <TabList class="-mb-px flex border-b border-gray-200">
                                <Tab
                                    v-slot="{ selected }"
                                    as="template"
                                    class="flex-1 sm:flex-none"
                                >
                                    <button
                                        :class="[
                                            selected
                                                ? 'border-sky-600 text-sky-600'
                                                : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                            'w-full border-b-2 py-6 text-center text-sm font-medium whitespace-nowrap transition-colors duration-200 sm:w-auto sm:px-8',
                                            'focus:outline-none focus-visible:border-sky-400',
                                        ]"
                                    >
                                        Ingredients
                                    </button>
                                </Tab>
                                <Tab
                                    v-slot="{ selected }"
                                    as="template"
                                    class="flex-1 sm:flex-none"
                                >
                                    <button
                                        :class="[
                                            selected
                                                ? 'border-sky-600 text-sky-600'
                                                : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                            'w-full border-b-2 py-6 text-center text-sm font-medium whitespace-nowrap transition-colors duration-200 sm:w-auto sm:px-8',
                                            'focus:outline-none focus-visible:border-sky-400',
                                        ]"
                                    >
                                        Steps
                                    </button>
                                </Tab>
                            </TabList>
                        </div>
                        <TabPanels as="template">
                            <TabPanel class="py-6">
                                <RecipeIngredients :ingredients="recipe.ingredients" />
                            </TabPanel>

                            <TabPanel class="py-6 text-sm text-gray-700">
                                <RecipeSteps :steps="recipe.steps" />
                            </TabPanel>
                        </TabPanels>
                    </TabGroup>
                </div>
            </div>

            <RecipeRelated :recipe="recipe" />
        </div>
    </div>
</template>

<script setup>
    import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue';
    import { format } from 'date-fns';

    const route = useRoute();
    const slug = route.params.slug;

    const { data: recipe } = await useFetch(`/api/recipes/${slug}`, {
        transform: (response) => {
            return response.data;
        },
    });
</script>

<style scoped>
    @media (max-width: 639px) {
        .save-button-wrapper :deep(button) {
            max-width: none;
        }
    }
</style>
