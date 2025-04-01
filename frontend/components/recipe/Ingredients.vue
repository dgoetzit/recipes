<template>
    <div>
        <h3 class="sr-only">Ingredients</h3>
        <ul
            role="list"
            class="divide-y divide-gray-100 rounded-lg bg-gray-50 p-1"
        >
            <li
                v-for="ingredient in ingredients"
                :key="ingredient.id"
                class="flex items-center justify-between gap-x-6 rounded-md px-3 py-4 transition-colors duration-150 hover:bg-white"
            >
                <div class="min-w-0">
                    <div class="flex items-start gap-x-3">
                        <p class="text-sm font-medium text-gray-900">
                            {{ ingredient.name }}
                        </p>
                        <p
                            class="mt-0.5 rounded-md bg-sky-50 px-2 py-0.5 text-xs font-medium whitespace-nowrap text-sky-700 ring-1 ring-sky-200 ring-inset"
                        >
                            {{ ingredient.pivot.measure_amount }}
                            {{ ingredient.pivot.measure_unit }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-none items-center gap-x-4">
                    <!-- Future functionality for suggested recipes -->
                    <button
                        class="rounded-full p-1 text-gray-400 transition-colors duration-150 hover:text-gray-500"
                        title="Find similar recipes"
                    >
                        <span class="sr-only">Find similar recipes with this ingredient</span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                            />
                        </svg>
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
    defineProps({
        ingredients: {
            type: Object,
            required: true,
        },
    });
</script>
