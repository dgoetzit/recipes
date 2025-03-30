<template>
    <div class="bg-white">
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

                            <div class="mt-3 flex items-center space-x-4 text-sm">
                                <p class="text-gray-600">
                                    <span class="font-medium text-gray-900">By:</span> {{ recipe.email }}
                                </p>
                                <span class="text-gray-300">|</span>
                                <p class="text-gray-600">
                                    <time :datetime="recipe.published_at">{{
                                        format(recipe.published_at, 'MMMM d, yyyy')
                                    }}</time>
                                </p>
                            </div>
                        </div>
                    </div>

                    <p class="mt-5 text-base leading-relaxed text-gray-700">{{ recipe.description }}</p>

                    <div class="mt-8">
                        <button
                            type="button"
                            class="flex w-full max-w-xs items-center justify-center rounded-md border border-transparent bg-sky-50 px-8 py-3 text-base font-medium text-sky-700 transition-colors duration-200 hover:bg-sky-100 focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-none"
                        >
                            <HeartIcon
                                class="mr-2 h-5 w-5 flex-shrink-0 text-sky-500"
                                aria-hidden="true"
                            />
                            <span>Like</span>
                        </button>
                    </div>
                </div>

                <div class="mx-auto mt-12 w-full max-w-2xl lg:col-span-4 lg:mt-0 lg:max-w-none">
                    <TabGroup as="div">
                        <div class="border-b border-gray-200">
                            <TabList class="-mb-px flex border-b border-gray-200">
                                <Tab
                                    as="template"
                                    v-slot="{ selected }"
                                >
                                    <button
                                        :class="[
                                            selected
                                                ? 'border-sky-600 text-sky-600'
                                                : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                            'border-b-2 px-8 py-6 text-sm font-medium whitespace-nowrap transition-colors duration-200',
                                        ]"
                                    >
                                        Ingredients
                                    </button>
                                </Tab>
                                <Tab
                                    as="template"
                                    v-slot="{ selected }"
                                >
                                    <button
                                        :class="[
                                            selected
                                                ? 'border-sky-600 text-sky-600'
                                                : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                            'border-b-2 px-8 py-6 text-sm font-medium whitespace-nowrap transition-colors duration-200',
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
        </div>
    </div>
</template>

<script setup>
    import { HeartIcon } from '@heroicons/vue/20/solid';
    import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue';
    import { format } from 'date-fns';

    const route = useRoute();
    const slug = route.params.slug;

    const { data: recipe, error } = await useFetch(`/api/recipes/${slug}`, {
        transform: (response) => {
            return response.data;
        },
    });
</script>
