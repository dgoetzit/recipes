<template>
    <div class="flex w-full flex-col px-4">
        <label
            :for="identifier"
            class="block text-sm/6 font-medium text-gray-900"
        >
            {{ label }}
        </label>
        <div class="mt-2 grid grid-cols-1">
            <input
                v-model="inputValue"
                :type="type"
                :name="identifier"
                :id="identifier"
                class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pr-3 pl-10 text-base text-gray-900 outline -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:-outline-offset-2 focus:outline-sky-600 sm:pl-9 sm:text-sm/6"
                :class="{ 'outline-red-500': showError }"
                :placeholder="placeholder"
                @blur="handleBlur"
            />
            <MagnifyingGlassIcon
                class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400 sm:size-4"
                aria-hidden="true"
            />
        </div>
        <p
            v-if="showError"
            class="mt-1 text-sm text-red-600"
        >
            {{ errorMessage }}
        </p>
    </div>
</template>

<script setup>
    import { MagnifyingGlassIcon } from '@heroicons/vue/16/solid';
    import { ref, watch, computed } from 'vue';

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
        value: {
            type: String,
            default: '',
        },
        validationRules: {
            type: Array,
            default: () => [],
        },
    });

    const emit = defineEmits(['searchUpdated']);

    const inputValue = ref(props.value || '');
    const wasTouched = ref(false);
    const errorMessage = ref('');

    const showError = computed(() => wasTouched.value && errorMessage.value);

    const validate = (value) => {
        errorMessage.value = '';

        if (!props.validationRules || !props.validationRules.length) {
            return true;
        }

        if (!value) {
            return true;
        }

        for (const rule of props.validationRules) {
            if (rule === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    errorMessage.value = 'Please enter a valid email address';
                    return false;
                }
            } else if (typeof rule === 'string' && rule.startsWith('minLength:')) {
                const length = parseInt(rule.split(':')[1]);
                if (value.length < length) {
                    errorMessage.value = `Must be at least ${length} characters`;
                    return false;
                }
            }
        }

        return true;
    };

    let debounceTimer = null;
    const debounce = (callback, time = 300) => {
        if (debounceTimer) clearTimeout(debounceTimer);
        debounceTimer = setTimeout(callback, time);
    };

    watch(inputValue, (newValue) => {
        const isValid = validate(newValue);

        debounce(() => {
            if (isValid || newValue === '') {
                emit('searchUpdated', props.identifier, newValue);
            }
        });
    });

    const handleBlur = () => {
        wasTouched.value = true;
        validate(inputValue.value);
    };

    watch(
        () => props.value,
        (newValue) => {
            if (newValue !== inputValue.value) {
                inputValue.value = newValue;
            }
        },
        { immediate: true },
    );
</script>
