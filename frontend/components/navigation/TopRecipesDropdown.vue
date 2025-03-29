<template>
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
                            selected ? 'border-sky-600 text-sky-600' : 'border-transparent text-gray-900',
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
</template>

<script setup>
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
