<template>
    <div>
        <NavigationMobile
            :isOpen="mobileMenuOpen"
            @close="mobileMenuOpen = false"
            @open="mobileMenuOpen = true"
        />

        <header class="relative bg-white">
            <nav
                aria-label="Top"
                class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
            >
                <div class="border-b border-gray-200">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex flex-1 items-center lg:hidden">
                            <button
                                type="button"
                                class="-ml-2 rounded-md bg-white p-2 text-gray-400"
                                @click="mobileMenuOpen = true"
                            >
                                <span class="sr-only">Open menu</span>
                                <Bars3Icon
                                    class="size-6"
                                    aria-hidden="true"
                                />
                            </button>

                            <NavigationElementsSearch class="ml-2" />
                        </div>

                        <NavigationDesktop />

                        <NavigationElementsLogo />

                        <div class="flex flex-1 items-center justify-end">
                            <NavigationElementsSearch class="hidden lg:block" />
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { Bars3Icon } from '@heroicons/vue/24/outline';

    const mobileMenuOpen = ref(false);
</script>
