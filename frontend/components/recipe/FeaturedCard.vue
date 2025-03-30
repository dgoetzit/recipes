<template>
    <div
        class="group relative flex h-full flex-col overflow-hidden rounded-lg border border-gray-200 transition-shadow hover:shadow-md"
    >
        <div class="aspect-[4/3] w-full overflow-hidden">
            <img
                :src="recipe.image"
                :alt="recipe.image_alt"
                class="h-full w-full object-cover object-center group-hover:opacity-75"
            />
        </div>

        <div class="flex flex-grow flex-col p-3">
            <h3 class="line-clamp-1 text-sm font-medium text-gray-900">
                <NuxtLink :to="`/recipes/${recipe.slug}`">
                    <span
                        aria-hidden="true"
                        class="absolute inset-0"
                    />
                    {{ recipe.name }}
                </NuxtLink>
            </h3>

            <p class="mt-1 line-clamp-1 text-xs text-gray-500">By: {{ recipe.email }}</p>

            <div class="mt-2 flex items-center">
                <div class="flex items-center">
                    <StarIcon
                        v-for="rating in [0, 1, 2, 3, 4]"
                        :key="rating"
                        :class="[recipe.rating > rating ? 'text-yellow-400' : 'text-gray-200', 'size-3.5 shrink-0']"
                        aria-hidden="true"
                    />
                </div>
                <p class="ml-1 text-xs text-gray-500">
                    {{ recipe.reviews }}
                </p>
            </div>

            <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center">
                    <svg
                        class="mr-1 h-3.5 w-3.5 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        ></path>
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        ></path>
                    </svg>
                    {{ formattedViews }}
                </div>
                <time
                    :datetime="recipe.published_at"
                    class="text-xs"
                >
                    {{ formattedDate }}
                </time>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed } from 'vue';
    import { StarIcon } from '@heroicons/vue/20/solid';

    const props = defineProps({
        recipe: {
            type: Object,
            required: true,
        },
    });

    const formattedViews = computed(() => {
        const views = props.recipe.views || 0;
        if (views >= 1000) {
            return (views / 1000).toFixed(1) + 'K';
        }
        return views.toString();
    });

    const formattedDate = computed(() => {
        if (!props.recipe.published_at) return '';

        const date = new Date(props.recipe.published_at);
        return new Intl.DateTimeFormat('en-US', {
            month: 'short',
            day: 'numeric',
        }).format(date);
    });
</script>
