<template>
    <PopoverGroup class="hidden lg:block lg:flex-1 lg:self-stretch">
        <div class="flex h-full space-x-8">
            <NavigationElementsTopRecipesPanel />

            <NavigationElementsSavedRecipesPanel />
        </div>
    </PopoverGroup>
</template>

<script setup>
    import { PopoverGroup } from '@headlessui/vue';
</script>
