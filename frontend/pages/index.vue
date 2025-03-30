<template>
    <div class="bg-white">
        <main class="pb-24">
            <div class="px-4 py-16 text-center sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">Our Recipes</h1>
                <p class="mx-auto mt-4 max-w-xl text-base text-gray-500">Find a recipe to your delight.</p>
            </div>

            <!-- Search -->
            <Disclosure
                as="section"
                aria-labelledby="search-heading"
                class="grid items-center border-t border-b border-gray-200"
            >
                <h2
                    id="search-heading"
                    class="sr-only"
                >
                    Search Inputs
                </h2>
                <div class="relative col-start-1 row-start-1 py-4">
                    <div class="mx-auto flex max-w-7xl justify-between px-4 text-sm sm:px-6 lg:px-8">
                        <Search
                            identifier="author-email"
                            type="text"
                            label="Author Email"
                            placeholder="Search by author email"
                            :model-value="state.search.email"
                            :validation-rules="['email']"
                            @search-updated="handleSearchUpdated"
                        ></Search>

                        <Search
                            identifier="keyword"
                            type="text"
                            label="Keyword"
                            placeholder="Search by recipe keyword"
                            :model-value="state.search.keyword"
                            :validation-rules="['minLength:2']"
                            @search-updated="handleSearchUpdated"
                        ></Search>

                        <Search
                            identifier="ingredient"
                            type="text"
                            label="Ingredient"
                            placeholder="Search by an ingredient"
                            :model-value="state.search.ingredient"
                            :validation-rules="['minLength:2']"
                            @search-updated="handleSearchUpdated"
                        ></Search>
                    </div>
                </div>
            </Disclosure>

            <div
                v-if="state.loading"
                class="flex justify-center py-12"
            >
                <UiStatesLoading />
            </div>

            <div
                v-else-if="state.error"
                class="py-12 text-center"
            >
                <UiStatesError />
            </div>

            <div
                v-else-if="isEmpty"
                class="py-12 text-center"
            >
                <UiStatesEmpty
                    emoji="🍽️"
                    title="No recipes found"
                    description="Try adjusting your search or check back later."
                />
            </div>

            <!-- Recipe grid -->
            <RecipeGrid
                v-else
                :recipes="state.recipes"
            />

            <!-- Pagination -->
            <div
                v-if="!state.loading && !state.error && state.recipes.length > 0"
                class="mt-8"
            >
                <Pagination
                    :current-page="state.pagination.currentPage"
                    :last-page="state.pagination.lastPage"
                    :next-page-url="state.pagination.nextPageUrl"
                    :prev-page-url="state.pagination.prevPageUrl"
                    :search-params="state.search"
                    @page-change="handlePageChange"
                />
            </div>
        </main>
    </div>
</template>

<script setup>
    import { ref, reactive, computed } from 'vue';
    import { Disclosure } from '@headlessui/vue';

    const state = reactive({
        loading: false,
        error: null,
        recipes: [],
        pagination: {
            currentPage: 1,
            lastPage: 1,
            nextPageUrl: null,
            prevPageUrl: null,
            total: 0,
        },
        search: {
            email: '',
            keyword: '',
            ingredient: '',
        },
    });

    const hasRecipes = computed(() => state.recipes.length > 0);
    const isEmpty = computed(() => !state.loading && hasRecipes.value === false);

    const { data: initialData, error: initialError } = await useFetch('/api/recipes');

    const processRecipeData = (data) => {
        if (!data) return;

        state.recipes = data.data || [];

        if (data.current_page) {
            state.pagination = {
                currentPage: data.current_page || 1,
                lastPage: data.last_page || 1,
                nextPageUrl: data.next_page_url,
                prevPageUrl: data.prev_page_url,
                total: data.total || 0,
            };
        } else if (data.data && data.data.current_page) {
            state.recipes = data.data.data || [];
            state.pagination = {
                currentPage: data.data.current_page || 1,
                lastPage: data.data.last_page || 1,
                nextPageUrl: data.data.next_page_url,
                prevPageUrl: data.data.prev_page_url,
                total: data.data.total || 0,
            };
        }
    };

    if (initialData.value) {
        processRecipeData(initialData.value);
    } else if (initialError.value) {
        state.error = initialError.value;
        console.error('Error loading initial recipes:', initialError.value);
    }

    const fetchRecipes = async (page = 1) => {
        state.loading = true;
        state.error = null;

        try {
            const response = await $fetch('/api/recipes', {
                method: 'GET',
                query: {
                    ...state.search,
                    page,
                },
            });

            processRecipeData(response);
        } catch (error) {
            state.error = error;
            console.error('Error fetching recipes:', error);
        } finally {
            state.loading = false;
        }
    };

    const handleSearchUpdated = (identifier, value) => {
        switch (identifier) {
            case 'author-email':
                state.search.email = value;
                break;
            case 'keyword':
                state.search.keyword = value;
                break;
            case 'ingredient':
                state.search.ingredient = value;
                break;
        }

        fetchRecipes(1);
    };

    const handlePageChange = async (pageNumber) => {
        await fetchRecipes(pageNumber);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
</script>
