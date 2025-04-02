<template>
    <section
        aria-labelledby="recipes-heading"
        class="mx-auto max-w-7xl overflow-hidden px-4 py-6 sm:px-6 lg:px-8"
    >
        <h2
            id="recipes-heading"
            class="sr-only"
        >
            Recipes
        </h2>

        <div
            v-if="recipes.length > 0"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <RecipeCard
                v-for="(recipe, index) in recipes"
                :key="recipe.id"
                :recipe="recipe"
                :style="{ animationDelay: `${index * 0.05}s` }"
                class="recipe-card-reveal rounded-lg shadow-sm transition-all duration-300 hover:translate-y-[-4px] hover:shadow-md"
            />
        </div>

        <div
            v-else
            class="flex items-center justify-center py-16 text-center"
        >
            <UiStatesEmpty
                emoji="🍽️"
                title="No recipes found"
                description="Try adjusting your search criteria to find more delicious recipes."
            />
        </div>
    </section>
</template>

<script setup>
    defineProps({
        recipes: {
            type: Array,
            required: true,
        },
    });
</script>

<style scoped>
    .recipe-card-reveal {
        animation: reveal 0.5s ease forwards;
        opacity: 0;
        transform: translateY(10px);
    }

    @keyframes reveal {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
