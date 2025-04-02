<template>
    <ClientOnly>
        <section
            v-if="relatedRecipes.length > 0"
            aria-labelledby="related-recipes-heading"
            class="bg-white py-12"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2
                    id="related-recipes-heading"
                    class="mb-6 text-2xl font-bold tracking-tight text-gray-900"
                >
                    Related Recipes
                </h2>

                <div class="grid-container relative overflow-hidden">
                    <div class="sm:hidden">
                        <div
                            ref="mobileScrollContainer"
                            class="no-scrollbar grid snap-x snap-mandatory auto-cols-[calc(100%-2rem)] grid-flow-col gap-4 overflow-x-auto scroll-smooth"
                            @scroll="updateCurrentItem"
                        >
                            <RecipeCard
                                v-for="(recipe, index) in relatedRecipes"
                                :key="recipe.id"
                                :recipe="recipe"
                                class="w-full shrink-0 snap-center"
                                :data-index="index"
                            />
                        </div>

                        <div class="mt-4 flex items-center justify-center space-x-2">
                            <template
                                v-for="(_, index) in relatedRecipes"
                                :key="index"
                            >
                                <span
                                    class="h-2 w-2 rounded-full transition-colors duration-300"
                                    :class="{
                                        'bg-gray-300': currentItemIndex !== index,
                                        'bg-gray-800': currentItemIndex === index,
                                    }"
                                ></span>
                            </template>
                        </div>
                    </div>

                    <div class="hidden grid-cols-2 grid-rows-3 gap-4 sm:grid md:grid lg:hidden">
                        <RecipeCard
                            v-for="recipe in relatedRecipes"
                            :key="recipe.id"
                            :recipe="recipe"
                            class="w-full"
                        />
                    </div>

                    <div class="hidden grid-cols-3 grid-rows-2 gap-4 lg:grid">
                        <RecipeCard
                            v-for="recipe in relatedRecipes"
                            :key="recipe.id"
                            :recipe="recipe"
                            class="w-full"
                        />
                    </div>
                </div>
            </div>
        </section>
    </ClientOnly>
</template>

<script setup>
    const props = defineProps({
        recipe: {
            type: Object,
            required: true,
        },
    });

    const relatedRecipes = ref([]);
    const isLoading = ref(false);
    const hasLoaded = ref(false);
    const error = ref(null);
    const mobileScrollContainer = ref(null);
    const currentItemIndex = ref(0);

    const fetchRelatedRecipes = async () => {
        if (hasLoaded.value && relatedRecipes.value.length > 0) {
            return;
        }

        isLoading.value = true;
        error.value = null;

        try {
            const response = await $fetch('/api/recipes/related', {
                params: {
                    id: props.recipe.id,
                },
            });

            relatedRecipes.value = response.data.data || [];
            hasLoaded.value = true;
        } catch (err) {
            error.value = err.message || 'An error occurred while fetching recipes';
            console.error('Failed to fetch related recipes:', err);
        } finally {
            isLoading.value = false;
        }
    };

    const updateCurrentItem = () => {
        if (!mobileScrollContainer.value) return;

        const container = mobileScrollContainer.value;
        const cards = container.children;

        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            const cardRect = card.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();

            if (cardRect.left >= containerRect.left && cardRect.right <= containerRect.right) {
                currentItemIndex.value = parseInt(card.dataset.index);
                break;
            }
        }
    };

    onMounted(() => {
        fetchRelatedRecipes();
    });
</script>

<style scoped>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .snap-x {
        scroll-snap-type: x mandatory;
    }

    .snap-center {
        scroll-snap-align: center;
    }

    .scroll-smooth {
        scroll-behavior: smooth;
    }
</style>
