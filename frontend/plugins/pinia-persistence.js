import { watch } from 'vue';
import { useSavedRecipeStore } from '~/stores/useSavedRecipeStore';

export default defineNuxtPlugin(() => {
    const recipeStore = useSavedRecipeStore();
    recipeStore.initFromLocalStorage();

    watch(
        () => recipeStore.savedRecipes,
        () => {
            try {
                recipeStore.saveToLocalStorage();
            } catch (error) {
                console.error('Failed to save recipes to localStorage:', error);
            }
        },
        { deep: true },
    );
});
