<template>
    <div class="min-w-screen min-h-screen dark:text-surface-200 dark:bg-surface-800 ">
        <Toast />
        <ScrollTop />
        <ConfirmDialog></ConfirmDialog>
        <RouterView />
    </div>
</template>

<script>
export default {
    name: 'App',
    methods: {
        // Detect if user click F1 to open help
        handleHelp(e) {
            if (e.key === 'F1') {
                e.preventDefault()
                window.open('https://docs.biznisbox.com', '_blank')
            }
        },
    },

    mounted() {
        window.addEventListener('keydown', this.handleHelp)
    },

    beforeUnmount() {
        window.removeEventListener('keydown', this.handleHelp)
    },
}
</script>
