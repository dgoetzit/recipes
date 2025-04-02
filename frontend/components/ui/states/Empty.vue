<template>
    <div class="empty-state py-4">
        <div
            class="mb-6 inline-flex h-20 w-20 items-center justify-center rounded-full border border-gray-100 bg-gray-50 shadow-sm"
        >
            <span class="text-3xl">{{ emoji }}</span>
        </div>

        <h3 class="mb-3 text-xl font-medium text-gray-900">
            {{ title }}
        </h3>

        <p class="mx-auto max-w-md text-base leading-relaxed text-gray-500">
            {{ description }}
        </p>
    </div>
</template>

<script setup>
    defineProps({
        title: {
            type: String,
            default: 'No Results Found',
        },
        description: {
            type: String,
            default: 'Please try again later or refine your search.',
        },
        emoji: {
            type: String,
            default: '😕',
        },
    });
</script>

<style scoped>
    .empty-state {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
