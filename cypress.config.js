const { defineConfig } = require('cypress')

module.exports = defineConfig({
    e2e: {
        baseUrl: 'http://localhost',
        setupNodeEvents(on, config) {
            // implement node event listeners here
        },
    },
    env: {
        USERNAME: 'admin@test.com',
        PASSWORD: 'password',
        BASE_URL: 'http://localhost',
    },
})
