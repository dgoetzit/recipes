<template>
    <div class="group relative rounded-lg border border-gray-200 p-4 transition-shadow hover:shadow-md sm:p-6">
        <div class="relative">
            <img
                :src="recipe.image"
                :alt="recipe.image_alt"
                class="aspect-[4/3] w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75"
            />

            <div
                class="absolute right-2 bottom-2 flex items-center rounded-full bg-black/60 px-2 py-1 text-xs text-white"
            >
                <svg
                    class="mr-1 h-3 w-3"
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
        </div>

        <div class="pt-4 pb-2">
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

            <div class="mt-2 flex items-center justify-between">
                <div class="flex items-center">
                    <StarIcon
                        v-for="rating in [0, 1, 2, 3, 4]"
                        :key="rating"
                        :class="[recipe.rating > rating ? 'text-yellow-400' : 'text-gray-200', 'size-4 shrink-0']"
                        aria-hidden="true"
                    />
                    <span class="ml-1 text-xs text-gray-500">{{ recipe.reviews }}</span>
                </div>
                <!-- Use clientOnly to prevent hydration mismatch -->
                <ClientOnly>
                    <time
                        v-if="recipe.published_at"
                        :datetime="recipe.published_at"
                        class="text-xs text-gray-500"
                    >
                        {{ formattedDate }}
                    </time>
                    <template #fallback>
                        <time
                            v-if="recipe.published_at"
                            :datetime="recipe.published_at"
                            class="text-xs text-gray-500"
                        >
                            <!-- Use a placeholder or fixed format that won't change between server/client -->
                            {{ fixedFormattedDate }}
                        </time>
                    </template>
                </ClientOnly>
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

    const formatDateWithTimezone = (dateString) => {
        if (!dateString) return '';

        const date = new Date(dateString);

        return new Intl.DateTimeFormat('en-US', {
            month: 'short',
            day: 'numeric',
            timeZone: 'UTC',
        }).format(date);
    };

    const formattedDate = computed(() => {
        return formatDateWithTimezone(props.recipe.published_at);
    });

    const fixedFormattedDate = computed(() => {
        if (!props.recipe.published_at) return '';

        const datePart = props.recipe.published_at.split('T')[0];
        const [year, month, day] = datePart.split('-');

        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthName = monthNames[parseInt(month) - 1];

        return `${monthName} ${parseInt(day)}`;
    });
</script>
