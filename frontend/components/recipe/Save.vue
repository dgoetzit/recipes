<template>
    <button
        type="button"
        :class="[
            'flex w-full max-w-xs items-center justify-center rounded-md border border-transparent px-8 py-3 text-base font-medium transition-colors duration-200 focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-none',
            isSaved ? 'bg-sky-100 text-sky-800 hover:bg-sky-200' : 'bg-sky-50 text-sky-700 hover:bg-sky-100',
        ]"
        @click="toggleSave"
    >
        <component
            :is="isSaved ? BookmarkIconSolid : BookmarkIconOutline"
            class="mr-2 h-5 w-5 flex-shrink-0 text-sky-500"
            aria-hidden="true"
        />
        <span>{{ isSaved ? 'Saved' : 'Save' }}</span>
    </button>
</template>

<script setup>
    import { BookmarkIcon as BookmarkIconOutline } from '@heroicons/vue/24/outline';
    import { BookmarkIcon as BookmarkIconSolid } from '@heroicons/vue/24/solid';
    import { computed } from 'vue';
    import { useRecipeStore } from '~/stores/savedRecipeStore';

    const props = defineProps({
        recipe: {
            type: Object,
            required: true,
        },
    });

    const recipeStore = useRecipeStore();

    const isSaved = computed(() => {
        if (!props.recipe || !props.recipe.id) {
            return false;
        }
        return recipeStore.isRecipeSaved(props.recipe.id);
    });

    const toggleSave = () => {
        if (!props.recipe || !props.recipe.id) {
            return;
        }

        recipeStore.toggleSavedRecipe(props.recipe);
    };
</script>
