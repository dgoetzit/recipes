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
                v-for="recipe in recipes"
                :key="recipe.id"
                :recipe="recipe"
                class="rounded-lg shadow-sm transition-all duration-300 hover:translate-y-[-4px] hover:shadow-md"
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
