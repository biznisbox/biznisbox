<template>
    <div id="error_page" class="bg-gradient-to-r from-cyan-500 to-blue-500">
        <div class="flex justify-center items-center h-screen mx-5">
            <div class="p-4 shadow-md w-full border border-surface-300 rounded-md card">
                <div class="text-center">
                    <i class="fa fa-exclamation-triangle text-red-500 fa-5x"></i>
                    <h1 class="text-2xl font-bold mb-4 dark:text-surface-200">
                        {{ $t('errors.error_404') }}
                    </h1>
                    <p class="dark:text-surface-200">
                        {{ $t('errors.error_404_message') }}
                    </p>
                    <RouterLink to="/" class="font-medium no-underline ml-2 text-blue-500 text-right cursor-pointer hover:underline">
                        {{ $t('errors.back_to_dashboard') }}
                    </RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ErrorPage',
}
</script>
