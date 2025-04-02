<template>
    <li class="py-3">
        <NuxtLink
            :to="`/recipes/${recipe.slug}`"
            class="flex items-center rounded-md p-2 hover:bg-gray-50"
            @click="$emit('click')"
        >
            <NuxtImg
                :src="recipe.image"
                :alt="recipe.name"
                class="mr-3 h-10 w-10 rounded-md object-cover"
                quality="70"
                format="webp"
                width="120"
                height="120"
                placeholder
                loading="lazy"
            />
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-900">
                    {{ recipe.name }}
                </p>
                <p class="truncate text-xs text-gray-500">
                    {{ recipe.email }}
                </p>
            </div>
        </NuxtLink>
    </li>
</template>

<script setup>
    defineProps({
        recipe: {
            type: Object,
            required: true,
        },
    });

    defineEmits(['click']);
</script>
