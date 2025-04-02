<template>
    <Popover
        v-slot="{ open, close }"
        ref="popoverRef"
        class="flex"
    >
        <div class="relative flex">
            <PopoverButton
                :class="[
                    open ? 'text-green-600' : 'text-gray-700 hover:text-gray-800',
                    'relative z-10 flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out focus:outline-none',
                    'px-4 py-2',
                ]"
            >
                <StarIcon class="mr-1.5 h-5 w-5" />
                Top Recipes
                <span
                    :class="[
                        open ? 'bg-green-600' : 'bg-transparent',
                        'absolute inset-x-0 bottom-0 h-0.5 transition-colors duration-200 ease-out',
                    ]"
                    aria-hidden="true"
                />
            </PopoverButton>
        </div>

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to="opacity-0 translate-y-1"
        >
            <PopoverPanel class="absolute inset-x-0 top-full z-20">
                <div
                    v-if="open"
                    v-once
                    class="hidden"
                    @vue:mounted="fetchTopRecipes()"
                />

                <div
                    class="absolute inset-0 top-1/2 bg-white shadow-lg"
                    aria-hidden="true"
                />

                <div
                    class="relative z-20 border-t border-gray-100 bg-white shadow-xl"
                    @click="(event) => handleClick(event, close)"
                >
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="py-12">
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
                                <h2 class="mb-6 text-xl font-bold text-gray-900">Featured Recipes</h2>
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
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
    import { StarIcon } from '@heroicons/vue/24/solid';
    import { usePopover } from '~/composables/usePopover';

    const { popoverRef, handleClick } = usePopover();

    const topRecipes = ref([]);
    const isLoading = ref(false);
    const hasLoaded = ref(false);
    const error = ref(null);

    const fetchTopRecipes = async () => {
        if (hasLoaded.value && topRecipes.value.length > 0) {
            return;
        }

        isLoading.value = true;
        error.value = null;

        try {
            const response = await $fetch('/api/recipes/top');

            topRecipes.value = response.data.data || [];
            hasLoaded.value = true;
        } catch (err) {
            error.value = err.message || 'An error occurred while fetching recipes';

            console.error('Failed to fetch top recipes:', err);
        } finally {
            isLoading.value = false;
        }
    };
</script>
