const { defineConfig } = require('cypress')
const { verifyDownloadTasks } = require('cy-verify-downloads')

module.exports = defineConfig({
    e2e: {
        baseUrl: 'http://localhost',
        browser: 'chrome',
        setupNodeEvents(on, config) {
            on('task', verifyDownloadTasks)
        },
    },
    env: {
        USERNAME: 'admin@test.com',
        PASSWORD: 'password',
        BASE_URL: 'http://localhost',
    },
})
