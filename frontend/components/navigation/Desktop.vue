<template>
    <PopoverGroup class="hidden lg:block lg:flex-1 lg:self-stretch">
        <div class="flex h-full space-x-8">
            <NavigationElementsTopRecipePopover />
        </div>
    </PopoverGroup>
</template>

<script setup>
    import { PopoverGroup } from '@headlessui/vue';

    defineProps({
        navigation: {
            type: Object,
            required: true,
        },
    });
</script>
