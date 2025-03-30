<template>
    <Popover
        class="flex"
        v-slot="{ open }"
    >
        <div class="relative flex">
            <PopoverButton
                :class="[
                    open ? 'text-sky-600' : 'text-gray-700 hover:text-gray-800',
                    'relative z-10 flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out',
                ]"
            >
                Top Recipes
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
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <PopoverPanel class="absolute inset-x-0 top-full z-20">
                <div
                    v-if="open"
                    v-once
                    class="hidden"
                    @vue:mounted="fetchTopRecipes()"
                ></div>

                <div
                    class="absolute inset-0 top-1/2 bg-white shadow"
                    aria-hidden="true"
                />

                <div class="relative bg-white">
                    <div class="mx-auto max-w-7xl px-8">
                        <div class="py-16">
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
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:gap-6">
                                    <RecipeFeaturedCard
                                        v-for="recipe in topRecipes"
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
    import { ref } from 'vue';
    import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';

    const topRecipes = ref([]);
    const isLoading = ref(false);
    const hasLoaded = ref(false);
    const error = ref(null);

    const fetchTopRecipes = async () => {
        console.log('Fetching hot recipes...');

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
            console.error('Failed to fetch hot recipes:', err);
        } finally {
            isLoading.value = false;
        }
    };
</script>
