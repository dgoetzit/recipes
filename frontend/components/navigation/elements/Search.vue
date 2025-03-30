<template>
    <a
        href="#"
        :class="[className, 'p-2 text-gray-400 hover:text-gray-500']"
    >
        <span class="sr-only">Search</span>
        <MagnifyingGlassIcon
            class="size-6"
            aria-hidden="true"
        />
    </a>
</template>

<script setup>
    import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

    defineProps({
        className: {
            type: String,
            default: 'ml-2',
        },
    });
</script>
