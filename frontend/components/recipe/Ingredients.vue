<template>
    <div>
        <h3 class="sr-only">Ingredients</h3>
        <ul
            role="list"
            class="divide-y divide-gray-100"
        >
            <li
                v-for="ingredient in ingredients"
                :key="ingredient.id"
                class="flex items-center justify-between gap-x-6 py-5"
            >
                <div class="min-w-0">
                    <div class="flex items-start gap-x-3">
                        <p class="text-sm text-gray-900">
                            {{ ingredient.name }}
                        </p>
                        <p
                            class="mt-0.5 rounded-md px-1.5 py-0.5 text-xs whitespace-nowrap text-gray-800 ring-1 ring-inset"
                        >
                            {{ ingredient.pivot.measure_amount }}
                            {{ ingredient.pivot.measure_unit }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-none items-center gap-x-4">
                    <!-- TODO suggested recipes... -->
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
    const props = defineProps({
        ingredients: {
            type: Object,
            required: true,
        },
    });

    console.log('ingredients', props.ingredients);
</script>
