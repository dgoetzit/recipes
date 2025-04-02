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
                            class="mt-0.5 rounded-md bg-green-50 px-2 py-0.5 text-xs font-medium whitespace-nowrap text-green-700 ring-1 ring-green-200 ring-inset"
                        >
                            {{ ingredient.pivot.measure_amount }}
                            {{ ingredient.pivot.measure_unit }}
                        </p>
                    </div>
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
