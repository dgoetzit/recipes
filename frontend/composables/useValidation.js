// composables/useValidation.js
import { ref, computed } from 'vue';

export function useValidation(initialValue = '', rules = []) {
    const value = ref(initialValue);
    const error = ref('');
    const isDirty = ref(false);

    const validateRule = (rule, val) => {
        if (typeof rule === 'string') {
            switch (rule) {
                case 'required':
                    return val.trim() ? '' : 'This field is required';
                case 'email':
                    return val === '' || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)
                        ? ''
                        : 'Please enter a valid email address';
                default:
                    if (rule.startsWith('minLength:')) {
                        const length = parseInt(rule.split(':')[1]);
                        return val === '' || val.length >= length ? '' : `Must be at least ${length} characters`;
                    }
            }
        }

        if (typeof rule === 'function') {
            return rule(val);
        }

        if (typeof rule === 'object' && rule !== null) {
            const { validate, message } = rule;
            return validate(val) ? '' : message;
        }

        return '';
    };

    const validate = (val = value.value) => {
        if (!rules.length) return true;

        for (const rule of rules) {
            const errorMessage = validateRule(rule, val);
            if (errorMessage) {
                error.value = errorMessage;
                return false;
            }
        }

        error.value = '';
        return true;
    };

    const isValid = computed(() => !error.value);
    const validationAttrs = computed(() => ({
        'aria-invalid': !isValid.value,
        'aria-errormessage': !isValid.value ? error.value : undefined,
    }));

    const reset = () => {
        value.value = initialValue;
        error.value = '';
        isDirty.value = false;
    };

    const updateValue = (newValue, validateOnUpdate = true) => {
        console.log('Updating value:', newValue);

        value.value = newValue;
        isDirty.value = true;

        if (validateOnUpdate) {
            validate(newValue);
        }

        console.log('Validation result:', isValid.value);

        return isValid.value;
    };

    return {
        value,
        error,
        isDirty,
        isValid,
        validationAttrs,
        validate,
        updateValue,
        reset,
    };
}
