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
                    Search Bars
                </h2>
                <div class="relative col-start-1 row-start-1 py-4">
                    <div class="mx-auto flex max-w-7xl justify-between px-4 text-sm sm:px-6 lg:px-8">
                        <Search
                            identifier="author-email"
                            type="text"
                            label="Author Email"
                            placeholder="Search by author email"
                            @search-updated="handleSearchUpdated"
                        ></Search>

                        <Search
                            identifier="keyword"
                            type="text"
                            label="Keyword"
                            placeholder="Search by recipe keyword"
                            @search-updated="handleSearchUpdated"
                        ></Search>

                        <Search
                            identifier="ingredient"
                            type="text"
                            label="Ingredient"
                            placeholder="Search by an ingredient"
                            @search-updated="handleSearchUpdated"
                        ></Search>
                    </div>
                </div>
            </Disclosure>

            <!-- Product grid -->
            <RecipeGrid :recipes="recipes" />

            <!-- TODO move this to a better logical location - Pagination -->
            <!-- <NavigationPagination
                :current-page="currentPage"
                :last-page="lastPage"
                :next-page-url="nextPageUrl"
                :prev-page-url="prevPageUrl"
                @page-change="handlePageChange"
            /> -->
        </main>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { Disclosure } from '@headlessui/vue';

    // TODO introduce loading skeleton

    const config = useRuntimeConfig();
    const baseApiEndpoint = config.public.apiEndpoint;
    const apiEndpoint = `${baseApiEndpoint}/recipes`;

    const recipes = ref([]);
    const currentPage = ref(1);
    const lastPage = ref(1);
    const nextPageUrl = ref(null);
    const prevPageUrl = ref(null);
    const total = ref(0);

    const { data: initialData, state, error } = await useFetch('/api/recipes');

    const renderRecipes = (paginationData) => {
        if (!paginationData) {
            return;
        }

        let data = paginationData.data;

        console.log('renderRecipes', data);

        // TODO empty state
        recipes.value = data.data || [];
        currentPage.value = data.current_page || 1;
        lastPage.value = data.last_page || 1;
        nextPageUrl.value = data.next_page_url;
        prevPageUrl.value = data.prev_page_url;
        total.value = data.total || 0;
    };

    renderRecipes(initialData.value);

    const handlePageChange = async (url) => {
        await fetchRecipes(url);

        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    const searchEmail = ref('');
    const searchKeyword = ref('');
    const searchIngredient = ref('');

    const fetchRecipes = async () => {
        try {
            const response = await $fetch('/api/recipes', {
                method: 'GET',
                query: {
                    email: searchEmail.value,
                    keyword: searchKeyword.value,
                    ingredient: searchIngredient.value,
                },
            });

            renderRecipes({ data: response.data });
        } catch (error) {
            console.error('Error fetching recipes:', error);
        }
    };

    function handleSearchUpdated(identifier, value) {
        if (identifier === 'author-email') {
            searchEmail.value = value;
        } else if (identifier === 'keyword') {
            searchKeyword.value = value;
        } else if (identifier === 'ingredient') {
            searchIngredient.value = value;
        }

        fetchRecipes(apiEndpoint);
    }
</script>
