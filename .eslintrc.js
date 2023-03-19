module.exports = {
    env: {
        browser: true,
    },
    extends: ['eslint:recommended', 'plugin:vue/vue3-recommended', 'prettier'],
    overrides: [],
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module',
    },
    plugins: ['vue'],
    rules: {},
}
