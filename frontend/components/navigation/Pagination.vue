<template>
    <nav
        aria-label="Pagination"
        class="mx-auto mt-6 flex max-w-7xl justify-between px-4 text-sm font-medium text-gray-700 sm:px-6 lg:px-8"
    >
        <div class="min-w-0 flex-1">
            <button
                @click="changePage(prevPageUrl)"
                :disabled="!prevPageUrl"
                class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
            >
                Previous
            </button>
        </div>
        <div class="hidden space-x-2 sm:flex">
            <!-- First page -->
            <button
                v-if="lastPage > 0"
                @click="changePage(`${baseUrl}?page=1`)"
                :class="[
                    currentPage === 1 ? 'border-sky-600 ring-1 ring-sky-600' : 'border-gray-300',
                    'inline-flex h-10 items-center rounded-md border bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none',
                ]"
            >
                1
            </button>

            <!-- Ellipsis if needed -->
            <span
                v-if="currentPage > 3"
                class="inline-flex h-10 items-center px-1.5 text-gray-500"
                >...</span
            >

            <!-- Pages before current -->
            <button
                v-for="page in getVisiblePageNumbers()"
                :key="page"
                v-if="page !== 1 && page !== lastPage"
                @click="changePage(`${baseUrl}?page=${page}`)"
                :class="[
                    currentPage === page ? 'border-sky-600 ring-1 ring-sky-600' : 'border-gray-300',
                    'inline-flex h-10 items-center rounded-md border bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none',
                ]"
            >
                {{ page }}
            </button>

            <!-- Ellipsis if needed -->
            <span
                v-if="currentPage < lastPage - 2"
                class="inline-flex h-10 items-center px-1.5 text-gray-500"
                >...</span
            >

            <!-- Last page (if not the first page) -->
            <button
                v-if="lastPage > 1"
                @click="changePage(`${baseUrl}?page=${lastPage}`)"
                :class="[
                    currentPage === lastPage ? 'border-sky-600 ring-1 ring-sky-600' : 'border-gray-300',
                    'inline-flex h-10 items-center rounded-md border bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none',
                ]"
            >
                {{ lastPage }}
            </button>
        </div>

        <div class="flex min-w-0 flex-1 justify-end">
            <button
                @click="changePage(nextPageUrl)"
                :disabled="!nextPageUrl"
                class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
            >
                Next
            </button>
        </div>
    </nav>
</template>

<script setup>
    import { ref, computed } from 'vue';

    // Props or data that should come from your parent component
    const props = defineProps({
        currentPage: {
            type: Number,
            required: true,
        },
        lastPage: {
            type: Number,
            required: true,
        },
        nextPageUrl: {
            type: String,
            default: null,
        },
        prevPageUrl: {
            type: String,
            default: null,
        },
    });

    // You'll need to know the base URL to construct page URLs
    const baseUrl = ref('/api/recipes/search');

    // Emit events for parent component to handle
    const emit = defineEmits(['pageChange']);

    // Function to handle page changes
    const changePage = (url) => {
        if (!url) return;
        emit('pageChange', url);
    };

    // Function to determine which page numbers to show
    const getVisiblePageNumbers = () => {
        let pages = [];

        if (props.lastPage <= 7) {
            // Show all pages if there are 7 or fewer
            for (let i = 1; i <= props.lastPage; i++) {
                pages.push(i);
            }
        } else {
            // More complex logic for pagination with lots of pages

            // Always include current page
            pages.push(props.currentPage);

            // Include 1-2 pages before current
            if (props.currentPage > 2) pages.push(props.currentPage - 1);
            if (props.currentPage > 3) pages.push(props.currentPage - 2);

            // Include 1-2 pages after current
            if (props.currentPage < props.lastPage - 1) pages.push(props.currentPage + 1);
            if (props.currentPage < props.lastPage - 2) pages.push(props.currentPage + 2);

            // Sort and remove duplicates
            pages = [...new Set(pages)].sort((a, b) => a - b);
        }

        return pages;
    };
</script>
