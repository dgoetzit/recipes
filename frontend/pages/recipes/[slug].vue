<template>
    <div class="bg-white">
        <MetaSearchEngineOptimization :recipe="recipe" />

        <div class="mx-auto px-4 py-6 sm:px-6 sm:py-12 lg:max-w-7xl lg:px-8">
            <div class="mb-4 block lg:hidden">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                    {{ recipe.name }}
                </h1>
                <div class="mt-2 flex flex-wrap items-center text-sm">
                    <p class="mr-3 mb-1 text-gray-600">
                        <span class="mr-1 font-medium text-gray-900">By:</span>
                        <NuxtLink
                            :to="{ name: 'index', query: { email: recipe.email } }"
                            class="text-blue-600 hover:text-blue-700 hover:underline"
                            >{{ recipe.email }}</NuxtLink
                        >
                    </p>
                    <span class="mx-1 hidden text-gray-300 sm:inline">|</span>
                    <p class="mb-1 text-gray-600">
                        <ClientOnly>
                            <time :datetime="recipe.published_at">{{
                                format(recipe.published_at, 'MMMM d, yyyy')
                            }}</time>
                        </ClientOnly>
                    </p>
                </div>
            </div>

            <div class="lg:grid lg:grid-cols-7 lg:grid-rows-1 lg:gap-x-8 lg:gap-y-10 xl:gap-x-16">
                <div class="lg:col-span-4 lg:row-end-1">
                    <div
                        class="relative overflow-hidden rounded-lg shadow-md transition-all duration-300 hover:shadow-lg"
                    >
                        <img
                            :src="recipe.image"
                            :alt="recipe.image_alt"
                            class="aspect-[4/3] w-full rounded-lg bg-gray-100 object-cover transition-transform duration-500 hover:scale-105"
                        />

                        <div
                            v-if="recipe.rating"
                            class="absolute top-3 right-3 flex items-center rounded-full bg-white/90 px-3 py-1 shadow-md"
                        >
                            <div class="flex text-yellow-400">
                                <span
                                    v-for="i in Math.floor(recipe.rating)"
                                    :key="i"
                                    >★</span
                                >
                                <span
                                    v-for="i in 5 - Math.floor(recipe.rating)"
                                    :key="`empty-${i}`"
                                    class="text-gray-300"
                                    >★</span
                                >
                            </div>
                            <span class="ml-1 text-sm font-medium text-gray-700">{{ recipe.rating || 0 }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="mx-auto mt-6 max-w-2xl sm:mt-8 md:mt-10 lg:col-span-3 lg:row-span-2 lg:row-end-2 lg:mt-0 lg:max-w-none"
                >
                    <div class="flex flex-col-reverse">
                        <div class="hidden lg:block">
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
                                    <span class="mr-1 font-medium text-gray-900">By:</span>
                                    <NuxtLink
                                        :to="{ name: 'index', query: { email: recipe.email } }"
                                        class="text-blue-600 hover:text-blue-700 hover:underline"
                                        >{{ recipe.email }}</NuxtLink
                                    >
                                </p>
                                <span class="text-gray-300">|</span>
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

                    <p class="text-base leading-relaxed text-gray-700">
                        {{ recipe.description }}
                    </p>

                    <div class="save-button-container mt-6 sm:mt-8">
                        <RecipeSave :recipe="recipe" />
                    </div>
                </div>

                <div class="mx-auto mt-8 w-full max-w-2xl sm:mt-10 lg:col-span-4 lg:mt-0 lg:max-w-none">
                    <TabGroup as="div">
                        <div class="border-b border-gray-200">
                            <TabList class="-mb-px flex">
                                <Tab
                                    v-slot="{ selected }"
                                    as="template"
                                    class="flex-1 sm:flex-none"
                                >
                                    <button
                                        :class="[
                                            selected
                                                ? 'border-green-600 text-green-600'
                                                : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                            'w-full border-b-2 py-3 text-center text-sm font-medium whitespace-nowrap transition-colors duration-200 sm:w-auto sm:px-8 sm:py-4',
                                            'focus:outline-none focus-visible:border-green-400',
                                        ]"
                                    >
                                        <span class="flex items-center justify-center">
                                            <svg
                                                class="mr-2 h-5 w-5"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                                                />
                                            </svg>
                                            Ingredients
                                        </span>
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
                                                ? 'border-green-600 text-green-600'
                                                : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-800',
                                            'w-full border-b-2 py-3 text-center text-sm font-medium whitespace-nowrap transition-colors duration-200 sm:w-auto sm:px-8 sm:py-4',
                                            'focus:outline-none focus-visible:border-green-400',
                                        ]"
                                    >
                                        <span class="flex items-center justify-center">
                                            <svg
                                                class="mr-2 h-5 w-5"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                            Steps
                                        </span>
                                    </button>
                                </Tab>
                            </TabList>
                        </div>
                        <TabPanels as="template">
                            <TabPanel class="py-4 sm:py-6">
                                <RecipeIngredients :ingredients="recipe.ingredients" />
                            </TabPanel>

                            <TabPanel class="py-4 text-sm text-gray-700 sm:py-6">
                                <RecipeSteps :steps="recipe.steps" />
                            </TabPanel>
                        </TabPanels>
                    </TabGroup>
                </div>
            </div>

            <div class="mt-6 border-t border-gray-100 pt-4 sm:mt-16 sm:pt-10">
                <RecipeRelated :recipe="recipe" />
            </div>
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
    /* Target the save button container to modify its child button */
    .save-button-container :deep(button) {
        max-width: none;
        width: 100%;
    }

    /* Return to original max-width on larger screens */
    @media (min-width: 640px) {
        .save-button-container :deep(button) {
            max-width: 20rem; /* or whatever width you prefer for desktop */
        }
    }

    /* Add smooth transition for tab panels */
    :deep(.tab-panels-enter-active),
    :deep(.tab-panels-leave-active) {
        transition: opacity 0.3s ease;
    }

    :deep(.tab-panels-enter-from),
    :deep(.tab-panels-leave-to) {
        opacity: 0;
    }
</style>
