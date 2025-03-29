<template>
    <div class="flex w-full flex-col px-4">
        <label
            for="email"
            class="block text-sm/6 font-medium text-gray-900"
            >{{ label }}</label
        >
        <div class="mt-2 grid grid-cols-1">
            <input
                v-model="search"
                :type="type"
                :name="identifier"
                :id="identifier"
                class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pr-3 pl-10 text-base text-gray-900 outline -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:-outline-offset-2 focus:outline-sky-600 sm:pl-9 sm:text-sm/6"
                :placeholder="placeholder"
            />
            <MagnifyingGlassIcon
                class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400 sm:size-4"
                aria-hidden="true"
            />
        </div>
    </div>
</template>

<script setup>
    import { MagnifyingGlassIcon } from '@heroicons/vue/16/solid';

    import { ref, watch } from 'vue';

    const search = ref('');

    const emit = defineEmits(['search']);

    watch(search, async (newValue) => {
        emit('searchUpdated', props.identifier, newValue);
    });

    const props = defineProps({
        identifier: {
            type: String,
            required: true,
            default: 'search',
        },
        type: {
            type: String,
            required: true,
            default: 'text',
        },
        label: {
            type: String,
            required: true,
            default: 'Search',
        },
        placeholder: {
            type: String,
            required: false,
            default: 'Search',
        },
    });
</script>
