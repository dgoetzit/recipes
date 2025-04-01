<template>
    <TransitionRoot
        as="template"
        :show="isOpen"
    >
        <Dialog
            class="relative z-40 lg:hidden"
            @close="$emit('close')"
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
                                @click="$emit('close')"
                            >
                                <span class="sr-only">Close menu</span>
                                <XMarkIcon
                                    class="size-6"
                                    aria-hidden="true"
                                />
                            </button>
                        </div>

                        <NavigationElementsMobileTabs @close="$emit('close')" />
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { XMarkIcon } from '@heroicons/vue/24/outline';

    defineProps({
        isOpen: {
            type: Boolean,
            required: true,
        },
    });

    defineEmits(['close', 'open']);

    const closeMenu = () => {
        emit('close');
    };
</script>
