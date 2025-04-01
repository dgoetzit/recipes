<template>
    <div>
        <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-200">
            <span class="text-gray-600">{{ emoji }}</span>
        </div>
        <h3 class="text-lg font-medium text-gray-900">
            {{ title }}
        </h3>
        <p class="mt-2 text-sm text-gray-500">
            {{ description }}
        </p>
    </div>
</template>

<script setup>
    defineProps({
        title: {
            type: String,
            default: 'Something is not quite right!',
        },
        description: {
            type: String,
            default: 'Please refresh the page or try again later.',
        },
        emoji: {
            type: String,
            default: '❗️',
        },
    });
</script>
