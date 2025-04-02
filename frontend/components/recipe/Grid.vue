<template>
    <section
        aria-labelledby="recipes-heading"
        class="mx-auto max-w-7xl overflow-hidden px-2 sm:px-6 lg:px-8"
    >
        <h2
            id="recipes-heading"
            class="sr-only"
        >
            Recipes
        </h2>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <RecipeCard
                v-for="recipe in recipes"
                :key="recipe.id"
                :recipe="recipe"
                class="rounded-lg shadow-sm transition-shadow duration-300 hover:shadow-md"
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
