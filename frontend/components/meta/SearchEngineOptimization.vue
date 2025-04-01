<template>
    <div />
</template>

<script setup>
    const props = defineProps({
        recipe: {
            type: Object,
            required: true,
        },
    });

    useSeoMeta({
        title: computed(() => props.recipe.name || 'Recipe Details'),
        description: computed(() => {
            return props.recipe.description || 'View detailed recipe instructions and ingredients.';
        }),
        ogTitle: computed(() => props.recipe.name || 'Recipe Details'),
        ogDescription: computed(() => {
            return props.recipe.description || 'View detailed recipe instructions and ingredients.';
        }),
        ogImage: computed(() => props.recipe.image || 'https://yoursite.com/images/default-recipe.jpg'),
        script: computed(() => {
            if (!props.recipe.value) return [];

            return [
                {
                    type: 'application/ld+json',
                    innerHTML: JSON.stringify({
                        '@context': 'https://schema.org',
                        '@type': 'Recipe',
                        'name': props.recipe.name,
                        'image': props.recipe.image,
                        'description': props.recipe.description,
                    }),
                },
            ];
        }),
    });
</script>
