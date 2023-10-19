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
                        <div class="col-6">
                            <DisplayData :input="$t('admin.app_status.current_version')" :value="version.version" />
                        </div>

                        <div class="col-6">
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
    },
}
</script>

<style></style>
