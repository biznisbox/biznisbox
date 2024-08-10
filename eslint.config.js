import globals from 'globals'
import pluginJs from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'

export default [
    { files: ['**/*.{js,mjs,cjs,vue}'] },
    { languageOptions: { globals: globals.browser } },
    { ignores: ['node_modules', 'vendor', 'public', 'resources/js/presets', 'resources/js/plugins/primevue.js'] },
    pluginJs.configs.recommended,
    ...pluginVue.configs['flat/essential'],
]
