export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{vue,js,ts}',
        './node_modules/primevue/**/*.{vue,js,ts,jsx,tsx',
        './resources/css/**/*.css',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: 'var(--primary-600)',
                'primary-contrast': 'var(--surface-50)',
                'primary-emphasis': 'var(--primary-700)',
                'border-surface': 'var(--surface-200)',
                'bg-emphasis': 'var(--surface-50)',
                'bg-highlight': 'var(--surface-100)',
                'bg-highlight-emphasis': 'var(--surface-300)',
                'text-color': 'var(--primary-900)',
                'text-color-emphasis': 'var(--primary-500)',
                'text-muted-color': 'var(--surface-600)',
                'text-muted-color-emphasis': 'var(--surface-500)',
                'primary-0': 'var(--primary-0)',
                'primary-50': 'var(--primary-50)',
                'primary-100': 'var(--primary-100)',
                'primary-200': 'var(--primary-200)',
                'primary-300': 'var(--primary-300)',
                'primary-400': 'var(--primary-400)',
                'primary-500': 'var(--primary-500)',
                'primary-600': 'var(--primary-600)',
                'primary-700': 'var(--primary-700)',
                'primary-800': 'var(--primary-800)',
                'primary-900': 'var(--primary-900)',
                'primary-950': 'var(--primary-950)',
                'surface-0': 'var(--surface-0)',
                'surface-50': 'var(--surface-50)',
                'surface-100': 'var(--surface-100)',
                'surface-200': 'var(--surface-200)',
                'surface-300': 'var(--surface-300)',
                'surface-400': 'var(--surface-400)',
                'surface-500': 'var(--surface-500)',
                'surface-600': 'var(--surface-600)',
                'surface-700': 'var(--surface-700)',
                'surface-800': 'var(--surface-800)',
                'surface-900': 'var(--surface-900)',
                'surface-950': 'var(--surface-950)',
            },
        },
    },
    plugins: [require('tailwindcss-primeui')],
}