<template>
    <section
        aria-labelledby="recipes-heading"
        class="mx-auto max-w-7xl overflow-hidden sm:px-6 lg:px-8"
    >
        <h2
            id="recipes-heading"
            class="sr-only"
        >
            Recipes
        </h2>

        <div class="-mx-px grid grid-cols-2 border-l border-gray-200 sm:mx-0 md:grid-cols-3 lg:grid-cols-4">
            <RecipeCard
                v-for="recipe in recipes"
                :key="recipe.id"
                :recipe="recipe"
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
