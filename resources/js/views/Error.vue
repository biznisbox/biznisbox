<template>
    <div id="error_page">
        <div class="flex justify-content-center mt-5 px-5">
            <div class="surface-card p-4 shadow-2 border-round w-full lg:w-6">
                <div class="text-center">
                    <i class="fa fa-exclamation-triangle text-red-500 fa-5x"></i>
                    <h1 class="text-900 font-medium text-5xl mb-4">404</h1>
                    <p class="text-900 font-medium text-2xl mb-4">{{ $t('errors.error_404') }}</p>
                    <p class="text-900 font-medium text-xl mb-4">{{ $t('errors.error_404_message') }}</p>
                    <RouterLink to="/" class="font-medium no-underline ml-2 text-blue-500 text-right cursor-pointer">{{
                        $t('errors.back_to_dashboard')
                    }}</RouterLink>
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
