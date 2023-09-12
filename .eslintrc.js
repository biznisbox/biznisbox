module.exports = {
    env: {
        browser: true,
    },
    extends: ['eslint:recommended', 'plugin:vue/vue3-recommended', 'prettier'],
    overrides: [],
    ignorePatterns: ['node_modules/', 'dist/', 'public/', 'cypress/', 'cypress.config.js', '.eslintrc.js'],
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module',
    },
    plugins: ['vue'],
    rules: {},
}
