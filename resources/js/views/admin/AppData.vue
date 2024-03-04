<template>
    <admin-layout>
        <div id="app_data_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.app_status.title')" />

                <div class="card">
                    <Message v-if="version.version != version.latest_version" severity="error" class="mb-4"
                        >{{ $t('admin.app_status.update_available') }} <Badge type="error">{{ version.latest_version }}</Badge></Message
                    >
                    <div class="grid">
                        <div class="col-6" id="app_version">
                            <div class="grid">
                                <DisplayData :input="$t('admin.app_status.current_version')" :value="version.version" class="col-6" />
                                <DisplayData :input="$t('admin.app_status.latest_version')" :value="version.latest_version" class="col-6" />
                            </div>
                        </div>

                        <div class="col-6" id="server_status">
                            <DisplayData :input="$t('admin.app_status.hostname')" :value="server_status.hostname" />
                            <DisplayData :input="$t('admin.app_status.server_os')" :value="server_status.server_os" />

                            <div class="grid">
                                <div class="col-6">
                                    <Chart :data="server_status.disk_graph" type="pie" :height="100" />
                                </div>
                                <div class="col-6">
                                    <Chart :data="server_status.memory_graph" type="pie" :height="100" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="test_email">
                        <TextInput v-model="email_test.email" :label="$t('form.email')" />
                        <Button @click="sendTestEmail" :label="$t('admin.app_status.send_test_email')" />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </admin-layout>
</template>

<script>
export default {
    name: 'AdminAppData',
    data() {
        return {
            version: [],
            server_status: [],
            email_test: {
                email: '',
            },
        }
    },

    created() {
        this.checkForUpdates()
        this.checkServerStatus()
    },

    methods: {
        checkForUpdates() {
            this.makeHttpRequest('GET', '/api/admin/check_version').then((response) => {
                this.version = response.data.data
            })
        },

        checkServerStatus() {
            this.makeHttpRequest('GET', '/api/admin/check_server_status').then((response) => {
                this.server_status = response.data.data
            })
        },

        sendTestEmail() {
            if (this.email_test.email == '') {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            this.makeHttpRequest('POST', '/api/admin/send_test_email', this.email_test).then((response) => {
                this.showToast(response.data.message)
            })
        },
    },
}
</script>

<style></style>
