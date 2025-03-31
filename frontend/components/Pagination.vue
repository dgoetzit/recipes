<template>
    <nav
        aria-label="Pagination"
        class="mx-auto mt-6 flex max-w-7xl justify-between px-4 text-sm font-medium text-gray-700 sm:px-6 lg:px-8"
    >
        <div class="min-w-0 flex-1">
            <button
                @click="changePage(props.currentPage - 1)"
                :disabled="props.currentPage <= 1"
                class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
            >
                Previous
            </button>
        </div>
        <div class="hidden space-x-2 sm:flex">
            <button
                v-if="props.lastPage > 0"
                @click="changePage(1)"
                :class="[
                    props.currentPage === 1 ? 'border-sky-600 ring-1 ring-sky-600' : 'border-gray-300',
                    'inline-flex h-10 items-center rounded-md border bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none',
                ]"
            >
                1
            </button>

            <span
                v-if="props.currentPage > 3"
                class="inline-flex h-10 items-center px-1.5 text-gray-500"
                >...</span
            >

            <!-- Fix: Move v-if outside of v-for element -->
            <template
                v-for="pageNum in visiblePages"
                :key="pageNum"
            >
                <button
                    v-if="pageNum !== 1 && pageNum !== props.lastPage"
                    @click="changePage(pageNum)"
                    :class="[
                        props.currentPage === pageNum ? 'border-sky-600 ring-1 ring-sky-600' : 'border-gray-300',
                        'inline-flex h-10 items-center rounded-md border bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none',
                    ]"
                >
                    {{ pageNum }}
                </button>
            </template>

            <span
                v-if="props.currentPage < props.lastPage - 2"
                class="inline-flex h-10 items-center px-1.5 text-gray-500"
                >...</span
            >

            <button
                v-if="props.lastPage > 1"
                @click="changePage(props.lastPage)"
                :class="[
                    props.currentPage === props.lastPage ? 'border-sky-600 ring-1 ring-sky-600' : 'border-gray-300',
                    'inline-flex h-10 items-center rounded-md border bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none',
                ]"
            >
                {{ props.lastPage }}
            </button>
        </div>

        <div class="flex min-w-0 flex-1 justify-end">
            <button
                @click="changePage(props.currentPage + 1)"
                :disabled="props.currentPage >= props.lastPage"
                class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 hover:bg-gray-100 focus:border-sky-600 focus:ring-2 focus:ring-sky-600/25 focus:ring-offset-1 focus:ring-offset-sky-600 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
            >
                Next
            </button>
        </div>
    </nav>
</template>

<script setup>
    import { computed } from 'vue';

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
        searchParams: {
            type: Object,
            default: () => ({}),
        },
    });

    const emit = defineEmits(['pageChange']);

    const changePage = (page) => {
        if (page < 1 || page > props.lastPage) return;
        emit('pageChange', page);
    };

    const visiblePages = computed(() => {
        const pages = [];

        if (props.lastPage <= 7) {
            for (let i = 2; i < props.lastPage; i++) {
                pages.push(i);
            }
        } else {
            const currentPage = props.currentPage;

            if (currentPage > 2) pages.push(currentPage - 1);
            if (currentPage > 3) pages.push(currentPage - 2);

            if (currentPage !== 1 && currentPage !== props.lastPage) {
                pages.push(currentPage);
            }

            if (currentPage < props.lastPage - 1) pages.push(currentPage + 1);
            if (currentPage < props.lastPage - 2) pages.push(currentPage + 2);

            return [...new Set(pages)].sort((a, b) => a - b);
        }

        return pages;
    });
</script>
