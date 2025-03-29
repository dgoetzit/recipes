<template>
    <div class="bg-white">
        <div class="mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <div class="lg:grid lg:grid-cols-7 lg:grid-rows-1 lg:gap-x-8 lg:gap-y-10 xl:gap-x-16">
                <div class="lg:col-span-4 lg:row-end-1">
                    <img
                        :src="recipe.image"
                        :alt="recipe.image_alt"
                        class="aspect-[4/3] w-full rounded-lg bg-gray-100 object-cover"
                    />
                </div>

                <div
                    class="mx-auto mt-14 max-w-2xl sm:mt-16 lg:col-span-3 lg:row-span-2 lg:row-end-2 lg:mt-0 lg:max-w-none"
                >
                    <div class="flex flex-col-reverse">
                        <div class="mt-2">
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                                {{ recipe.name }}
                            </h1>

                            <h2
                                id="information-heading"
                                class="sr-only"
                            >
                                Recipe Information
                            </h2>
                            <p class="mt-2 text-sm text-gray-500">Brought to you by: {{ recipe.email }}</p>
                            <p class="mt-2 text-sm text-gray-500">
                                <time :datetime="recipe.published_at">{{ recipe.published_at }}</time>
                            </p>
                        </div>
                    </div>

                    <p class="mt-6 text-gray-500">{{ recipe.description }}</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                        <!-- TODO transform this to a like button or something like that -->
                        <button
                            type="button"
                            class="flex w-full items-center justify-center rounded-md border border-transparent bg-sky-50 px-8 py-3 text-base font-medium text-sky-700 hover:bg-sky-100 focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-none"
                        >
                            <HeartIcon
                                class="h-5 w-5 flex-shrink-0 text-sky-500"
                                aria-hidden="true"
                            />
                            Like
                        </button>
                    </div>
                </div>

                <div class="mx-auto mt-16 w-full max-w-2xl lg:col-span-4 lg:mt-0 lg:max-w-none">
                    <TabGroup as="div">
                        <div class="border-b border-gray-200">
                            <TabList class="-mb-px flex space-x-8">
                                <Tab
                                    as="template"
                                    v-slot="{ selected }"
                                >
                                    <button
                                        :class="[
                                            selected
                                                ? 'border-sky-600 text-sky-600'
                                                : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                            'border-b-2 py-6 text-sm font-medium whitespace-nowrap',
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
                                            'border-b-2 py-6 text-sm font-medium whitespace-nowrap',
                                        ]"
                                    >
                                        Steps
                                    </button>
                                </Tab>
                            </TabList>
                        </div>
                        <TabPanels as="template">
                            <TabPanel class="-mb-10">
                                <RecipeIngredients :ingredients="recipe.ingredients" />
                            </TabPanel>

                            <TabPanel class="text-sm text-gray-500">
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

    const route = useRoute();
    const config = useRuntimeConfig();
    const baseApiEndpoint = config.public.apiEndpoint;
    const apiEndpoint = `${baseApiEndpoint}/recipes/${route.params.slug}`;

    const { data: recipe } = await useFetch(`${apiEndpoint}`, {
        transform: (response) => {
            return response.data;
        },
    });
</script>
