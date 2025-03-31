import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useRecipeStore = defineStore('recipes', () => {
    const savedRecipes = ref([]);

    const getSavedRecipes = computed(() => savedRecipes.value);

    const isRecipeSaved = (recipeId) => {
        return savedRecipes.value.some((recipe) => recipe.id === recipeId);
    };

    function toggleSavedRecipe(recipe) {
        const isAlreadySaved = isRecipeSaved(recipe.id);

        if (isAlreadySaved) {
            savedRecipes.value = savedRecipes.value.filter((saved) => saved.id !== recipe.id);

            return false;
        } else {
            savedRecipes.value.push({
                id: recipe.id,
                name: recipe.name,
                image: recipe.image,
                image_alt: recipe.image_alt,
                slug: recipe.slug,
                description: recipe.description,
                email: recipe.email,
                rating: recipe.rating,
                reviews: recipe.reviews,
                published_at: recipe.published_at,
                savedAt: new Date().toISOString(),
            });

            return true;
        }
    }

    function initFromLocalStorage() {
        if (process.client) {
            const saved = localStorage.getItem('savedRecipes');

            if (saved) {
                try {
                    savedRecipes.value = JSON.parse(saved);
                } catch (e) {
                    console.error('Failed to parse saved recipes from localStorage:', e);
                }
            }
        }
    }

    function saveToLocalStorage() {
        if (process.client) {
            localStorage.setItem('savedRecipes', JSON.stringify(savedRecipes.value));
        }
    }

    function clearAllRecipes() {
        savedRecipes.value = [];
        saveToLocalStorage();
    }

    return {
        savedRecipes,
        getSavedRecipes,
        isRecipeSaved,
        toggleSavedRecipe,
        initFromLocalStorage,
        saveToLocalStorage,
        clearAllRecipes,
    };
});
