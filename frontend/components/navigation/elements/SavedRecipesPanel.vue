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
                <BookmarkIcon class="mr-1.5 h-5 w-5" />
                Saved Recipes
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
                    class="absolute inset-0 top-1/2 bg-white shadow-lg"
                    aria-hidden="true"
                />

                <div
                    class="relative z-20 border-t border-gray-100 bg-white shadow-xl"
                    @click="(event) => handleClick(event, close)"
                >
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="py-12">
                            <div class="mb-6 flex items-center justify-between">
                                <h2 class="text-xl font-bold text-gray-900">Your Saved Recipes</h2>

                                <button
                                    v-if="!isLoading && !error && savedRecipes.length > 0"
                                    class="rounded-md bg-red-50 px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-100 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none"
                                    @click="clearAllSaved"
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
                                <div
                                    v-if="savedRecipes.length === 0"
                                    class="py-12 text-center"
                                >
                                    <UiStatesEmpty
                                        title="No saved recipes"
                                        description="You haven't saved any recipes yet. Browse recipes and click the save button to add them here."
                                        emoji="🤷‍♂️"
                                    />
                                </div>

                                <div
                                    v-else
                                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3"
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
    import { ref, computed } from 'vue';
    import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
    import { usePopover } from '~/composables/usePopover';
    import { useSavedRecipeStore } from '~/stores/useSavedRecipeStore';
    import { BookmarkIcon } from '@heroicons/vue/24/solid';

    const { popoverRef, handleClick } = usePopover();

    const recipeStore = useSavedRecipeStore();
    const isLoading = ref(false);
    const error = ref(null);

    const savedRecipes = computed(() => recipeStore.getSavedRecipes);

    const clearAllSaved = () => {
        if (confirm('Are you sure you want to clear all saved recipes?')) {
            recipeStore.clearAllRecipes();
        }
    };
</script>
