<template>
    <div class="animate-pulse text-center">
        <div class="mx-auto h-8 w-24 rounded bg-gray-200" />
        <p class="mt-4 text-gray-500">
            {{ message }}
        </p>
    </div>
</template>

<script setup>
    defineProps({
        message: {
            type: String,
            default: 'Loading...',
        },
    });
</script>
