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
                :id="identifier"
                v-model="inputValue"
                :type="type"
                :name="identifier"
                :class="inputClasses"
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
    import { debounce } from 'lodash';

    const props = defineProps({
        identifier: {
            type: String,
            default: 'search',
        },
        type: {
            type: String,
            default: 'text',
        },
        label: {
            type: String,
            default: 'Search',
        },
        placeholder: {
            type: String,
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

    const inputClasses = computed(() => ({
        'outline-red-500': showError.value,
        'col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pr-3 pl-10 text-base text-gray-900 outline -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:-outline-offset-2 focus:outline-green-600 sm:pl-9 sm:text-sm/6': true,
    }));

    const validate = (value) => {
        errorMessage.value = '';

        if (!props.validationRules?.length || !value) {
            return true;
        }

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

    const debouncedEmit = debounce((value) => {
        const isValid = validate(value);

        if (isValid || value === '') {
            emit('searchUpdated', props.identifier, value);
        }
    }, 300);

    watch(inputValue, (newValue) => {
        debouncedEmit(newValue);
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
