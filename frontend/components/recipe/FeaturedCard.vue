<template>
    <div
        class="group relative flex h-full flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:translate-y-[-4px] hover:shadow-md"
    >
        <div class="aspect-[4/3] w-full overflow-hidden">
            <NuxtImg
                :src="recipe.image"
                :alt="recipe.image_alt"
                class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                quality="80"
                format="webp"
                width="200"
                height="200"
                placeholder
                loading="lazy"
            />

            <div
                class="absolute top-2 right-2 flex items-center rounded-full bg-black/60 px-2.5 py-1 text-xs text-white"
            >
                <EyeIcon class="mr-1 h-3 w-3" />
                {{ formattedViews }}
            </div>
        </div>

        <div class="flex flex-grow flex-col p-4">
            <h3 class="line-clamp-1 text-base font-medium text-gray-900">
                <NuxtLink
                    :to="`/recipes/${recipe.slug}`"
                    class="transition-colors hover:text-green-600"
                >
                    <span
                        aria-hidden="true"
                        class="absolute inset-0"
                    />
                    {{ recipe.name }}
                </NuxtLink>
            </h3>

            <p class="mt-1 line-clamp-1 text-sm text-gray-500">By: {{ recipe.email }}</p>

            <div class="mt-2 flex items-center">
                <div class="flex items-center">
                    <StarIcon
                        v-for="rating in [0, 1, 2, 3, 4]"
                        :key="rating"
                        :class="[recipe.rating > rating ? 'text-yellow-400' : 'text-gray-200', 'size-4 shrink-0']"
                        aria-hidden="true"
                    />
                </div>
                <p class="ml-1.5 text-xs text-gray-500">
                    {{ recipe.reviews }}
                </p>
            </div>

            <div class="mt-auto flex justify-end pt-3 text-xs text-gray-500">
                <time
                    :datetime="recipe.published_at"
                    class="rounded bg-gray-50 px-2 py-1 text-xs"
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
    import { EyeIcon } from '@heroicons/vue/24/outline';
    import { format, parseISO } from 'date-fns';

    const props = defineProps({
        recipe: {
            type: Object,
            required: true,
        },
    });

    const formattedViews = computed(() => {
        console.log('views', props.recipe.views);

        const views = props.recipe.views || 0;

        if (views >= 1000) {
            return (views / 1000).toFixed(1) + 'K';
        }

        return views.toString();
    });

    const formattedDate = computed(() => {
        if (!props.recipe.published_at) {
            return '';
        }

        return format(parseISO(props.recipe.published_at), 'MMM d');
    });
</script>
