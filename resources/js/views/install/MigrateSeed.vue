<template>
    <div class="container w-full md:w-1/2 mx-auto p-6">
        <div class="card">
            <h1 class="text-2xl font-bold text-center">{{ $t('install.creating_tables') }}</h1>

            <p class="text-center">{{ $t('install.creating_tables_description') }}</p>

            <div class="flex justify-between" v-if="loadingData">
                <ProgressSpinner />
            </div>

            <div v-if="error" class="mt-6">
                <p class="text-red-500 font-bold">{{ error }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'InstallMigrateSeedPage',
    data() {
        return {
            error: '',
        }
    },

    methods: {
        migrateAndSeed() {
            this.makeHttpRequest('POST', `/api/install/migrate-seed`)
                .then((response) => {
                    if (response.data.data.status === true) {
                        this.nextStep()
                    } else {
                        this.error = response.data.message
                    }
                })
                .catch((error) => {
                    console.log(error)
                })
        },

        nextStep() {
            this.$router.push({ name: 'install-company' })
        },
    },

    created() {
        new Promise(() => {
            this.makeHttpRequest('GET', '/api/install/check-app-installed', null, null, null, false).then((response) => {
                if (response.data.data.status == true) {
                    this.loadingData = true
                    return this.$router.push({ name: 'auth-login' })
                } else {
                    this.migrateAndSeed()
                }
            })
        }).then(() => {
            this.loadingData = false
            this.nextStep()
        })
    },
}
</script>
