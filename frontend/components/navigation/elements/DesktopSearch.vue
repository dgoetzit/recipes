<template>
    <div>
        <button
            type="button"
            :class="[className, 'p-2 text-gray-400 hover:text-gray-500']"
            @click="openModal"
        >
            <span class="sr-only">Search</span>
            <MagnifyingGlassIcon
                class="size-6"
                aria-hidden="true"
            />
        </button>

        <TransitionRoot
            appear
            :show="isOpen"
            as="template"
        >
            <Dialog
                as="div"
                class="relative z-50"
                @close="closeModal"
            >
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-gray-800/80 backdrop-blur-sm transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild
                            as="template"
                            enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to="opacity-100 translate-y-0 sm:scale-100"
                            leave="ease-in duration-200"
                            leave-from="opacity-100 translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        >
                            <DialogPanel
                                class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6"
                            >
                                <div>
                                    <div class="absolute top-0 right-0 pt-4 pr-4">
                                        <button
                                            type="button"
                                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none"
                                            @click="closeModal"
                                        >
                                            <span class="sr-only">Close</span>
                                            <XMarkIcon
                                                class="h-6 w-6"
                                                aria-hidden="true"
                                            />
                                        </button>
                                    </div>

                                    <div class="w-full sm:flex sm:items-start">
                                        <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <DialogTitle
                                                as="h3"
                                                class="text-lg leading-6 font-medium text-gray-900"
                                            >
                                                Search Recipes
                                            </DialogTitle>

                                            <div class="mt-4">
                                                <form
                                                    class="flex flex-col gap-4"
                                                    @submit.prevent="submitSearch"
                                                >
                                                    <div>
                                                        <label
                                                            for="search-query"
                                                            class="sr-only"
                                                            >Search query</label
                                                        >
                                                        <div class="relative rounded-md shadow-sm">
                                                            <div
                                                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                                                            >
                                                                <MagnifyingGlassIcon
                                                                    class="h-5 w-5 text-gray-400"
                                                                    aria-hidden="true"
                                                                />
                                                            </div>

                                                            <input
                                                                id="search-query"
                                                                ref="searchInput"
                                                                v-model="searchQuery"
                                                                type="text"
                                                                name="search"
                                                                class="block w-full rounded-md border-gray-300 py-3 pl-10 text-base focus:border-green-500 focus:ring-green-500"
                                                                placeholder="Search for a recipe by name or ingredients"
                                                                @input="debouncedSearch"
                                                            />
                                                        </div>
                                                    </div>

                                                    <div
                                                        v-if="isSearching"
                                                        class="flex justify-center py-4"
                                                    >
                                                        <UiStatesLoading message="Searching recipes" />
                                                    </div>

                                                    <div
                                                        v-if="!isSearching"
                                                        class="mt-2"
                                                    >
                                                        <h4
                                                            v-if="searchResults.length > 0"
                                                            class="mb-2 text-xs font-semibold tracking-wider text-gray-500 uppercase"
                                                        >
                                                            {{
                                                                searchQuery
                                                                    ? 'Search Results'
                                                                    : 'Recipes You Might Enjoy'
                                                            }}
                                                        </h4>
                                                        <div
                                                            v-if="searchResults.length === 0 && searchQuery.length >= 2"
                                                            class="py-8 text-center text-gray-500"
                                                        >
                                                            No recipes found matching "{{ searchQuery }}"
                                                        </div>
                                                        <ul
                                                            v-else-if="searchResults.length > 0"
                                                            class="max-h-60 divide-y divide-gray-200 overflow-y-auto"
                                                        >
                                                            <RecipeSlimCard
                                                                v-for="result in searchResults"
                                                                :key="result.id"
                                                                :recipe="result"
                                                                @click="closeModal"
                                                            />
                                                        </ul>

                                                        <div
                                                            v-if="searchResults.length > 0 && searchQuery.length >= 2"
                                                            class="mt-4 text-center"
                                                        >
                                                            <NuxtLink
                                                                :to="`/?keyword=${encodeURIComponent(searchQuery)}`"
                                                                class="text-sm font-medium text-green-600 hover:text-green-500"
                                                                @click="closeModal"
                                                            >
                                                                View all results
                                                            </NuxtLink>
                                                        </div>
                                                    </div>

                                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                                        <button
                                                            type="submit"
                                                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm"
                                                            :disabled="searchQuery.length < 2"
                                                        >
                                                            Search
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm"
                                                            @click="closeModal"
                                                        >
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup>
    import { ref, nextTick, watch } from 'vue';
    import { MagnifyingGlassIcon, XMarkIcon } from '@heroicons/vue/24/outline';
    import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { useRouter } from 'vue-router';
    import debounce from 'lodash/debounce';

    defineProps({
        className: {
            type: String,
            default: 'ml-2',
        },
    });

    const router = useRouter();
    const isOpen = ref(false);
    const searchQuery = ref('');
    const searchInput = ref(null);
    const isSearching = ref(false);
    const searchResults = ref([]);

    const performSearch = async (query = null) => {
        if (query !== null && query.length < 2) {
            searchResults.value = [];
            return;
        }

        isSearching.value = true;

        try {
            const response = await $fetch('/api/recipes/search', {
                params: {
                    q: query || '',
                },
            });

            if (response && response.data) {
                searchResults.value = response.data;
            } else {
                searchResults.value = [];
            }
        } catch (error) {
            console.error('Search error:', error);
            searchResults.value = [];
        } finally {
            isSearching.value = false;
        }
    };

    const debouncedSearch = debounce(() => {
        performSearch(searchQuery.value);
    }, 300);

    watch(searchQuery, (newQuery) => {
        if (newQuery.length < 2) {
            searchResults.value = [];
        }
    });

    watch(isOpen, async (newValue) => {
        if (newValue) {
            await performSearch();

            nextTick(() => {
                setTimeout(() => {
                    searchInput.value?.focus();
                }, 100);
            });
        }
    });

    const openModal = () => {
        isOpen.value = true;
    };

    const closeModal = () => {
        isOpen.value = false;
        searchQuery.value = '';
    };

    const submitSearch = () => {
        if (!searchQuery.value.trim() || searchQuery.value.length < 2) return;

        router.push({
            name: 'index',
            query: { keyword: searchQuery.value },
        });

        closeModal();
    };
</script>
