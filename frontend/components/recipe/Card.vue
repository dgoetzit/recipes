<template>
    <div class="group relative border-b border-r border-gray-200 p-4 sm:p-6">
        <img
            :src="recipe.image"
            :alt="recipe.image_alt"
            class="aspect-square rounded-lg bg-gray-200 object-cover group-hover:opacity-75"
        />
        <div class="pb-4 pt-10 text-center">
            <h3 class="text-sm font-medium text-gray-900">
                <NuxtLink :to="`/recipes/${recipe.slug}`">
                    <span aria-hidden="true" class="absolute inset-0" />
                    {{ recipe.name }}
                </NuxtLink>
            </h3>
            <p class="mt-1 text-xs text-gray-500">By: {{ recipe.email }}</p>
            <div class="mt-3 flex flex-col items-center">
                <p class="sr-only">{{ recipeRating }} out of 5 stars</p>
                <div class="flex items-center">
                    <StarIcon
                        v-for="rating in [0, 1, 2, 3, 4]"
                        :key="rating"
                        :class="[
                            recipeRating > rating
                                ? 'text-yellow-400'
                                : 'text-gray-200',
                            'size-5 shrink-0',
                        ]"
                        aria-hidden="true"
                    />
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    {{ reviewCount }} reviews
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { StarIcon } from "@heroicons/vue/20/solid";

defineProps({
    recipe: {
        type: Object,
        required: true,
    },
});

const recipeRating = ref(4);
const reviewCount = ref(10);
const href = ref("#");
</script>
