<template>
    <section
        v-if="relatedRecipes.length > 0"
        aria-labelledby="related-recipes-heading"
        class="bg-white"
    >
        <div class="mx-auto max-w-7xl">
            <div class="mb-6">
                <h2
                    id="related-recipes-heading"
                    class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl"
                >
                    Related Recipes
                </h2>
                <p class="mt-1 text-sm text-gray-500">You might also enjoy these similar recipes</p>
            </div>

            <div class="grid-container relative overflow-hidden">
                <div class="sm:hidden">
                    <div
                        ref="mobileScrollContainer"
                        class="no-scrollbar grid snap-x snap-mandatory auto-cols-[calc(100%-1.5rem)] grid-flow-col gap-4 overflow-x-auto scroll-smooth pb-4"
                        @scroll="updateCurrentItem"
                    >
                        <RecipeCard
                            v-for="(recipe, index) in relatedRecipes"
                            :key="recipe.id"
                            :recipe="recipe"
                            class="w-full shrink-0 snap-center rounded-lg shadow-sm transition-all duration-300 hover:translate-y-[-4px] hover:shadow-md"
                            :data-index="index"
                        />
                    </div>

                    <div class="mt-6 mb-8 flex items-center justify-center space-x-4">
                        <template
                            v-for="(_, index) in relatedRecipes"
                            :key="index"
                        >
                            <button
                                @click="scrollToItem(index)"
                                class="h-3 w-3 rounded-full transition-colors duration-300 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none"
                                :class="{
                                    'bg-gray-300 hover:bg-gray-400': currentItemIndex !== index,
                                    'h-3 w-4 bg-green-600': currentItemIndex === index,
                                }"
                                :aria-label="`Go to slide ${index + 1}`"
                                :aria-current="currentItemIndex === index ? 'true' : 'false'"
                            ></button>
                        </template>
                    </div>
                </div>

                <div class="hidden grid-cols-2 gap-6 sm:grid md:grid lg:hidden">
                    <RecipeCard
                        v-for="recipe in relatedRecipes"
                        :key="recipe.id"
                        :recipe="recipe"
                        class="w-full rounded-lg shadow-sm transition-all duration-300 hover:translate-y-[-4px] hover:shadow-md"
                    />
                </div>

                <div class="hidden grid-cols-3 gap-6 lg:grid">
                    <RecipeCard
                        v-for="recipe in relatedRecipes"
                        :key="recipe.id"
                        :recipe="recipe"
                        class="w-full rounded-lg shadow-sm transition-all duration-300 hover:translate-y-[-4px] hover:shadow-md"
                    />
                </div>
            </div>
        </div>
    </section>
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

        let maxVisibleWidth = 0;
        let mostVisibleIndex = 0;

        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            const cardRect = card.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();

            const visibleLeft = Math.max(cardRect.left, containerRect.left);
            const visibleRight = Math.min(cardRect.right, containerRect.right);
            const visibleWidth = Math.max(0, visibleRight - visibleLeft);

            if (visibleWidth > maxVisibleWidth) {
                maxVisibleWidth = visibleWidth;
                mostVisibleIndex = parseInt(card.dataset.index);
            }
        }

        currentItemIndex.value = mostVisibleIndex;
    };

    const scrollToItem = (index) => {
        if (!mobileScrollContainer.value) return;

        const container = mobileScrollContainer.value;
        const targetCard = container.children[index];

        if (targetCard) {
            container.scrollTo({
                left: targetCard.offsetLeft - container.offsetLeft,
                behavior: 'smooth',
            });

            currentItemIndex.value = index;
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

    /* Add subtle animation for recipe cards */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .grid-container {
        animation: fadeIn 0.5s ease-out;
    }
</style>
