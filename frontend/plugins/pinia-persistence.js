import { useRecipeStore } from '~/stores/savedRecipeStore';
import { watch } from 'vue';

export default defineNuxtPlugin(({ $pinia }) => {
    const recipeStore = useRecipeStore();
    recipeStore.initFromLocalStorage();

    watch(
        () => recipeStore.savedRecipes,
        () => {
            recipeStore.saveToLocalStorage();
        },
        { deep: true },
    );
});
