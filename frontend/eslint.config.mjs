import withNuxt from './.nuxt/eslint.config.mjs'

export default withNuxt({
    rules: {
        'no-unused-vars': 'warn',
        'no-console': ['warn', { allow: ['warn', 'error'] }],
        'eqeqeq': ['error', 'always'],
        'no-var': 'error',
        'prefer-const': 'error',
        'vue/multi-word-component-names': 'off',
        'vue/require-prop-types': 'error',
        'vue/require-explicit-emits': 'error',
    },
})
