<template>
    <div class="container w-full md:w-1/2 mx-auto p-6">
        <div class="card">
            <h1 class="text-2xl font-bold text-center">{{ $t('install.finish_installation') }}</h1>

            <p class="text-center">{{ $t('install.finish_installation_description') }}</p>

            <div class="flex justify-center mt-6">
                <Button @click="$router.push({ name: 'auth-login' })" :label="$t('install.go_to_login')" icon="fas fa-sign-in-alt" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'InstallFinishPage',

    created() {
        document.title = this.$t('install.installation')
        this.checkIfInstalled()
    },
}
</script>
