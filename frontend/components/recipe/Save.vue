<template>
    <button
        type="button"
        :class="[
            'flex w-full max-w-xs items-center justify-center rounded-md border border-transparent px-8 py-3 text-base font-medium transition-colors duration-200 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-none',
            isSaved
                ? 'bg-green-100 text-green-800 hover:bg-green-200'
                : 'bg-green-50 text-green-700 hover:bg-green-100',
        ]"
        @click="toggleSave"
    >
        <component
            :is="isSaved ? BookmarkIconSolid : BookmarkIconOutline"
            class="mr-2 h-5 w-5 flex-shrink-0 text-green-500"
            aria-hidden="true"
        />
        <span>{{ isSaved ? 'Saved' : 'Save' }}</span>
    </button>
</template>

<script setup>
    import { BookmarkIcon as BookmarkIconOutline } from '@heroicons/vue/24/outline';
    import { BookmarkIcon as BookmarkIconSolid } from '@heroicons/vue/24/solid';
    import { ref, onMounted } from 'vue';
    import { useSavedRecipeStore } from '~/stores/useSavedRecipeStore';

    const props = defineProps({
        recipe: {
            type: Object,
            required: true,
        },
    });

    const recipeStore = useSavedRecipeStore();
    const isSaved = ref(false);

    onMounted(() => {
        if (props.recipe && props.recipe.id) {
            isSaved.value = recipeStore.isRecipeSaved(props.recipe.id);
        }
    });

    const toggleSave = () => {
        if (!props.recipe || !props.recipe.id) {
            return;
        }

        recipeStore.toggleSavedRecipe(props.recipe);
        isSaved.value = recipeStore.isRecipeSaved(props.recipe.id);
    };
</script>
