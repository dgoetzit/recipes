<template>
    <div>
        <!-- Mobile menu -->
        <TransitionRoot
            as="template"
            :show="open"
        >
            <Dialog
                class="relative z-40 lg:hidden"
                @close="open = false"
            >
                <TransitionChild
                    as="template"
                    enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 z-40 flex">
                    <TransitionChild
                        as="template"
                        enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full"
                        enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform"
                        leave-from="translate-x-0"
                        leave-to="-translate-x-full"
                    >
                        <DialogPanel
                            class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-xl"
                        >
                            <div class="flex px-4 pt-5 pb-2">
                                <button
                                    type="button"
                                    class="-m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400"
                                    @click="open = false"
                                >
                                    <span class="sr-only">Close menu</span>
                                    <XMarkIcon
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>

                            <!-- Links -->
                            <TabGroup
                                as="div"
                                class="mt-2"
                            >
                                <div class="border-b border-gray-200">
                                    <TabList class="-mb-px flex space-x-8 px-4">
                                        <Tab
                                            as="template"
                                            v-for="category in navigation.categories"
                                            :key="category.name"
                                            v-slot="{ selected }"
                                        >
                                            <button
                                                :class="[
                                                    selected
                                                        ? 'border-sky-600 text-sky-600'
                                                        : 'border-transparent text-gray-900',
                                                    'flex-1 border-b-2 px-1 py-4 text-base font-medium whitespace-nowrap',
                                                ]"
                                            >
                                                {{ category.name }}
                                            </button>
                                        </Tab>
                                    </TabList>
                                </div>
                                <TabPanels as="template">
                                    <TabPanel
                                        v-for="category in navigation.categories"
                                        :key="category.name"
                                        class="space-y-10 px-4 pt-10 pb-8"
                                    >
                                        <div class="space-y-4">
                                            <div
                                                v-for="(item, itemIdx) in category.featured"
                                                :key="itemIdx"
                                                class="group relative overflow-hidden rounded-md bg-gray-100"
                                            >
                                                <img
                                                    :src="item.imageSrc"
                                                    :alt="item.imageAlt"
                                                    class="aspect-square w-full object-cover group-hover:opacity-75"
                                                />
                                                <div class="absolute inset-0 flex flex-col justify-end">
                                                    <div class="bg-white/60 p-4 text-base sm:text-sm">
                                                        <a
                                                            :href="item.href"
                                                            class="font-medium text-gray-900"
                                                        >
                                                            <span
                                                                class="absolute inset-0"
                                                                aria-hidden="true"
                                                            />
                                                            {{ item.name }}
                                                        </a>
                                                        <p
                                                            aria-hidden="true"
                                                            class="mt-0.5 text-gray-700 sm:mt-1"
                                                        >
                                                            Shop now
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-for="(column, columnIdx) in category.sections"
                                            :key="columnIdx"
                                            class="space-y-10"
                                        >
                                            <div
                                                v-for="section in column"
                                                :key="section.name"
                                            >
                                                <p
                                                    :id="`${category.id}-${section.id}-heading-mobile`"
                                                    class="font-medium text-gray-900"
                                                >
                                                    {{ section.name }}
                                                </p>
                                                <ul
                                                    role="list"
                                                    :aria-labelledby="`${category.id}-${section.id}-heading-mobile`"
                                                    class="mt-6 flex flex-col space-y-6"
                                                >
                                                    <li
                                                        v-for="item in section.items"
                                                        :key="item.name"
                                                        class="flow-root"
                                                    >
                                                        <a
                                                            :href="item.href"
                                                            class="-m-2 block p-2 text-gray-500"
                                                            >{{ item.name }}</a
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </TabPanel>
                                </TabPanels>
                            </TabGroup>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

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
                                @click="open = true"
                            >
                                <span class="sr-only">Open menu</span>
                                <Bars3Icon
                                    class="size-6"
                                    aria-hidden="true"
                                />
                            </button>

                            <a
                                href="#"
                                class="ml-2 p-2 text-gray-400 hover:text-gray-500"
                            >
                                <span class="sr-only">Search</span>
                                <MagnifyingGlassIcon
                                    class="size-6"
                                    aria-hidden="true"
                                />
                            </a>
                        </div>

                        <!-- Flyout menus -->
                        <PopoverGroup class="hidden lg:block lg:flex-1 lg:self-stretch">
                            <div class="flex h-full space-x-8">
                                <Popover
                                    v-for="category in navigation.categories"
                                    :key="category.name"
                                    class="flex"
                                    v-slot="{ open }"
                                >
                                    <div class="relative flex">
                                        <PopoverButton
                                            :class="[
                                                open ? 'text-sky-600' : 'text-gray-700 hover:text-gray-800',
                                                'relative z-10 flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out',
                                            ]"
                                        >
                                            {{ category.name }}
                                            <span
                                                :class="[
                                                    open ? 'bg-sky-600' : '',
                                                    'absolute inset-x-0 bottom-0 h-0.5 transition-colors duration-200 ease-out sm:mt-5 sm:translate-y-px sm:transform',
                                                ]"
                                                aria-hidden="true"
                                            />
                                        </PopoverButton>
                                    </div>

                                    <transition
                                        enter-active-class="transition ease-out duration-200"
                                        enter-from-class="opacity-0"
                                        enter-to-class="opacity-100"
                                        leave-active-class="transition ease-in duration-150"
                                        leave-from-class="opacity-100"
                                        leave-to-class="opacity-0"
                                    >
                                        <PopoverPanel class="absolute inset-x-0 top-full z-20">
                                            <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                                            <div
                                                class="absolute inset-0 top-1/2 bg-white shadow"
                                                aria-hidden="true"
                                            />

                                            <div class="relative bg-white">
                                                <div class="mx-auto max-w-7xl px-8">
                                                    <div class="grid grid-cols-2 gap-x-8 gap-y-10 py-16">
                                                        <div class="grid grid-cols-2 grid-rows-1 gap-8 text-sm">
                                                            <div
                                                                v-for="(item, itemIdx) in category.featured"
                                                                :key="item.name"
                                                                :class="[
                                                                    itemIdx === 0 ? 'col-span-2' : '',
                                                                    'group relative overflow-hidden rounded-md bg-gray-100',
                                                                ]"
                                                            >
                                                                <img
                                                                    :src="item.imageSrc"
                                                                    :alt="item.imageAlt"
                                                                    :class="[
                                                                        itemIdx === 0
                                                                            ? 'aspect-[2/1]'
                                                                            : 'aspect-square',
                                                                        'w-full object-cover group-hover:opacity-75',
                                                                    ]"
                                                                />
                                                                <div class="absolute inset-0 flex flex-col justify-end">
                                                                    <div class="bg-white/60 p-4 text-sm">
                                                                        <a
                                                                            :href="item.href"
                                                                            class="font-medium text-gray-900"
                                                                        >
                                                                            <span
                                                                                class="absolute inset-0"
                                                                                aria-hidden="true"
                                                                            />
                                                                            {{ item.name }}
                                                                        </a>
                                                                        <p
                                                                            aria-hidden="true"
                                                                            class="mt-0.5 text-gray-700 sm:mt-1"
                                                                        >
                                                                            Shop now
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="grid grid-cols-3 gap-x-8 gap-y-10 text-sm text-gray-500"
                                                        >
                                                            <div
                                                                v-for="(column, columnIdx) in category.sections"
                                                                :key="columnIdx"
                                                                class="space-y-10"
                                                            >
                                                                <div
                                                                    v-for="section in column"
                                                                    :key="section.name"
                                                                >
                                                                    <p
                                                                        :id="`${category.id}-${section.id}-heading`"
                                                                        class="font-medium text-gray-900"
                                                                    >
                                                                        {{ section.name }}
                                                                    </p>
                                                                    <ul
                                                                        role="list"
                                                                        :aria-labelledby="`${category.id}-${section.id}-heading`"
                                                                        class="mt-4 space-y-4"
                                                                    >
                                                                        <li
                                                                            v-for="item in section.items"
                                                                            :key="item.name"
                                                                            class="flex"
                                                                        >
                                                                            <a
                                                                                :href="item.href"
                                                                                class="hover:text-gray-800"
                                                                                >{{ item.name }}</a
                                                                            >
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>

                                <a
                                    v-for="page in navigation.pages"
                                    :key="page.name"
                                    :href="page.href"
                                    class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800"
                                    >{{ page.name }}</a
                                >
                            </div>
                        </PopoverGroup>

                        <!-- Logo -->
                        <NuxtLink to="/">Recipe Search 3000</NuxtLink>

                        <div class="flex flex-1 items-center justify-end">
                            <!-- TODO ensure this search is functional... -->
                            <!-- This can exemplify the consolidated search from a single
                            endpoint, without 3 separate inputs -->
                            <a
                                href="#"
                                class="ml-6 hidden p-2 text-gray-400 hover:text-gray-500 lg:block"
                            >
                                <span class="sr-only">Search</span>
                                <MagnifyingGlassIcon
                                    class="size-6"
                                    aria-hidden="true"
                                />
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import {
        Dialog,
        DialogPanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Popover,
        PopoverButton,
        PopoverGroup,
        PopoverPanel,
        Tab,
        TabGroup,
        TabList,
        TabPanel,
        TabPanels,
        TransitionChild,
        TransitionRoot,
    } from '@headlessui/vue';

    import { Bars3Icon, MagnifyingGlassIcon, UserIcon, XMarkIcon } from '@heroicons/vue/24/outline';

    const open = ref(false);

    const navigation = {
        categories: [
            {
                id: 'top-recipes',
                name: 'Top Recipes',
                featured: [
                    {
                        name: 'New Arrivals',
                        href: '#',
                        imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-01.jpg',
                        imageAlt: 'Models sitting back to back, wearing Basic Tee in black and bone.',
                    },
                    {
                        name: 'Basic Tees',
                        href: '#',
                        imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-02.jpg',
                        imageAlt: 'Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees.',
                    },
                    {
                        name: 'Accessories',
                        href: '#',
                        imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-03.jpg',
                        imageAlt: 'Model wearing minimalist watch with black wristband and white watch face.',
                    },
                ],
            },
        ],
    };
</script>
